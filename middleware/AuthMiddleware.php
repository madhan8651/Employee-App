<?php

class AuthMiddleware
{
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /Employee_App/public/login.php"
            );
            exit;
        }

        return true;
    }
}