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

        $this->passwordService =
            new PasswordService();

        $this->authenticationService =
            new AuthenticationService(
                $userModel,
                $this->passwordService
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login($login, $password)
    {
        $user =
            $this->authenticationService->authenticate(
                $login,
                $password
            );


        if (!is_array($user)) {
            return $user;
        }


        if (
            session_status() === PHP_SESSION_NONE
        ) {
            session_start();
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN LOGIN
        |--------------------------------------------------------------------------
        */

        if ($user["role"] === "Admin") {

            $_SESSION["user_id"] =
                $user["user_id"];

            $_SESSION["name"] =
                $user["name"];

            $_SESSION["role"] =
                $user["role"];


            header(
                "Location: /Employee_App/views/auth/admin/dashboard.php"
            );

            exit;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE LOGIN
        |--------------------------------------------------------------------------
        */

        if ($user["role"] === "Employee") {

            $_SESSION["user_id"] =
                $user["user_id"];

            $_SESSION["name"] =
                $user["name"];

            $_SESSION["email"] =
                $user["email"];

            $_SESSION["role"] =
                $user["role"];


            header(
                "Location: /Employee_App/views/auth/employees/profile.php"
            );

            exit;
        }


        return "Invalid user role.";
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGE PASSWORD
    |--------------------------------------------------------------------------
    |
    | Available for both:
    | Admin
    | Employee
    |
    */

    public function changePassword(
        $currentPassword,
        $newPassword,
        $confirmPassword
    ) {

        /*
        |--------------------------------------------------------------------------
        | START SESSION
        |--------------------------------------------------------------------------
        */

        if (
            session_status() === PHP_SESSION_NONE
        ) {
            session_start();
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            empty($_SESSION["user_id"])
        ) {

            return "User is not logged in";
        }


        $userId =
            $_SESSION["user_id"];


        /*
        |--------------------------------------------------------------------------
        | GET USER
        |--------------------------------------------------------------------------
        */

        $userModel =
            new User($GLOBALS["pdo"]);


        $user =
            $userModel->findByUserId(
                $userId
            );


        if (!$user) {

            return "User not found";
        }


        /*
        |--------------------------------------------------------------------------
        | CURRENT PASSWORD VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            trim($currentPassword) === ""
        ) {

            return "Current password is required";
        }


        if (
            !$this->passwordService->verify(
                $currentPassword,
                $user["password"]
            )
        ) {

            return "Current password is incorrect";
        }


        /*
        |--------------------------------------------------------------------------
        | NEW PASSWORD REQUIRED
        |--------------------------------------------------------------------------
        */

        if (
            trim($newPassword) === ""
        ) {

            return "New password is required";
        }


        /*
        |--------------------------------------------------------------------------
        | CONFIRM PASSWORD REQUIRED
        |--------------------------------------------------------------------------
        */

        if (
            trim($confirmPassword) === ""
        ) {

            return "Please confirm your new password";
        }


        /*
        |--------------------------------------------------------------------------
        | PASSWORD MATCH VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            $newPassword !== $confirmPassword
        ) {

            return "New passwords do not match";
        }


        /*
        |--------------------------------------------------------------------------
        | NEW PASSWORD VALIDATION
        |--------------------------------------------------------------------------
        */

        $passwordValidation =
            $this->passwordService->validate(
                $newPassword
            );


        if (
            $passwordValidation !== true
        ) {

            return $passwordValidation;
        }


        /*
        |--------------------------------------------------------------------------
        | DIFFERENT PASSWORD VALIDATION
        |--------------------------------------------------------------------------
        */

        if (
            $this->passwordService->verify(
                $newPassword,
                $user["password"]
            )
        ) {

            return
                "New password must be different from current password";
        }


        /*
        |--------------------------------------------------------------------------
        | HASH NEW PASSWORD
        |--------------------------------------------------------------------------
        */

        $hashedPassword =
            $this->passwordService->hash(
                $newPassword
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        $updated =
            $userModel->updatePassword(
                $userId,
                $hashedPassword
            );


        if (!$updated) {

            return "Failed to update password";
        }


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return "Password changed successfully";
    }
}