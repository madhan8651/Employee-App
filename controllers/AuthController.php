<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../services/PasswordService.php";
require_once __DIR__ . "/../services/AuthenticationService.php";

class AuthController
{
    private $authenticationService;
    private $passwordService;

    public function __construct()
    {
        global $pdo;

        $userModel = new User($pdo);

        $this->passwordService = new PasswordService();

        $this->authenticationService =
            new AuthenticationService(
                $userModel,
                $this->passwordService
            );
    }

    public function login($login, $password)
{
    $user = $this->authenticationService->authenticate(
        $login,
        $password
    );

    if (!is_array($user)) {
        return $user;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($user["role"] === "Admin") {

        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        header(
            "Location: /Employee_App/views/auth/admin/dashboard.php"
        );
        exit;
    }

    if ($user["role"] === "Employee") {

        return "You are not authorized to access the Admin Dashboard.";
    }

    return "Invalid user role.";
}

    public function changePassword(
        $currentPassword,
        $newPassword,
        $confirmPassword
    ) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user_id"])) {
            return "User is not logged in";
        }

        $userId = $_SESSION["user_id"];

        $userModel = new User($GLOBALS["pdo"]);

        $user = $userModel->findByUserId($userId);

        if (!$user) {
            return "User not found";
        }

        if (!$this->passwordService->verify(
            $currentPassword,
            $user["password"]
        )) {
            return "Current password is incorrect";
        }

        if ($newPassword !== $confirmPassword) {
            return "New passwords do not match";
        }

        $passwordValidation =
            $this->passwordService->validate($newPassword);

        if ($passwordValidation !== true) {
            return $passwordValidation;
        }

        if ($this->passwordService->verify(
            $newPassword,
            $user["password"]
        )) {
            return "New password must be different from current password";
        }

        $hashedPassword =
            $this->passwordService->hash($newPassword);

        $updated = $userModel->updatePassword(
            $userId,
            $hashedPassword
        );

        if (!$updated) {
            return "Failed to update password";
        }

        return "Password changed successfully";
    }
}