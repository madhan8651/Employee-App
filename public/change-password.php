<?php

require_once __DIR__ . "/../controllers/AuthController.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $currentPassword = $_POST["current_password"] ?? "";
    $newPassword = $_POST["new_password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    $auth = new AuthController();

    $message = $auth->changePassword(
        $currentPassword,
        $newPassword,
        $confirmPassword
    );
}

require_once __DIR__ . "/../views/auth/change-password.php";