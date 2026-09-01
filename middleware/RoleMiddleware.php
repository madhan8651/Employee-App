<?php

class RoleMiddleware
{
    public function handle($requiredRole)
    {
        session_start();

        if (!isset($_SESSION["role"])) {
            header("Location: login.php");
            exit;
        }

        if ($_SESSION["role"] !== $requiredRole) {
            http_response_code(403);
            echo "Access denied";
            exit;
        }
    }
}