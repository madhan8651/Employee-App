<?php

require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../middleware/CsrfMiddleware.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!CsrfMiddleware::validateToken($_POST["csrf_token"] ?? "")) {

        $message = "Invalid CSRF token.";

    } else {

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
}

require_once __DIR__ . "/../views/auth/change-password.php";