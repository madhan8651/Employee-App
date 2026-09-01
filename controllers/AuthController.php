<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../config/database.php";

class AuthController
{
    private $userModel;

    public function __construct()
    {
        global $pdo;

        $this->userModel = new User($pdo);
    }


    // Login
    public function login($login, $password)
    {
        // Remove unnecessary spaces
        $login = trim($login);
        $password = trim($password);

        // Validate empty input
        if ($login === "" || $password === "") {
            return "Username or password is required";
        }

        // Find user by email or username
        $user = $this->userModel->findByLogin($login);

        // Generic error for security
        if (!$user) {
            return "Username or password is wrong";
        }

        // Check account status
        if ($user["status"] !== "Active") {
            return "User account is inactive";
        }

        // Verify password
        if (!password_verify($password, $user["password"])) {
            return "Username or password is wrong";
        }

        // Start session
        session_start();

        // Store minimum required user information
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    }

    // Check whether user is logged in
    public function isLoggedIn()
    {
        session_start();

        return isset($_SESSION["user_id"]);
    }


    // Check whether user is Admin
    public function isAdmin()
    {
        session_start();

        if (!isset($_SESSION["role"])) {
            return false;
        }

        return $_SESSION["role"] === "Admin";
    }


    // Change password
    public function changePassword(
    $currentPassword,
    $newPassword,
    $confirmPassword
) {
    // Start the session
    session_start();

    // 1. Check whether the user is logged in
    if (!isset($_SESSION["user_id"])) {
        return "User is not logged in";
    }

    // 2. Get logged-in user's ID
    $userId = $_SESSION["user_id"];

    // 3. Get user details from database
    $user = $this->userModel->findByUserId($userId);

    if (!$user) {
        return "User not found";
    }

    // 4. Verify old/current password
    if (!password_verify(
        $currentPassword,
        $user["password"]
    )) {
        return "Current password is incorrect";
    }

    // 5. Check new password
    if (empty($newPassword)) {
        return "New password is required";
    }

    // 6. Check confirmation password
if ($newPassword !== $confirmPassword) {
    return "New passwords do not match";
}

// 7. Validate new password strength
$passwordValidation = $this->validatePassword($newPassword);

if ($passwordValidation !== true) {
    return $passwordValidation;
}

// 8. Hash the new password
$hashedPassword = password_hash(
    $newPassword,
    PASSWORD_DEFAULT
);

    // 9. Update password in database
    $updated = $this->userModel->updatePassword(
        $userId,
        $hashedPassword
    );

    if (!$updated) {
        return "Failed to update password";
    }

    return "Password changed successfully";
}
private function validatePassword($password)
{
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain an uppercase letter";
    }

    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain a lowercase letter";
    }

    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain a number";
    }

    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        return "Password must contain a special character";
    }

    return true;
}
}