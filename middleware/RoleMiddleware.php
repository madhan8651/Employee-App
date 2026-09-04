<?php

class RoleMiddleware
{
    public static function check($requiredRole)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["role"])) {
            header("Location: ../auth/login.php");
            exit;
        }

        if ($_SESSION["role"] !== $requiredRole) {
            http_response_code(403);
            die("Access denied.");
        }

        return true;
    }
}