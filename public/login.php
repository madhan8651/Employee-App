<?php

require_once __DIR__ . "/../controllers/AuthController.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["login"] ?? "";
    $password = $_POST["password"] ?? "";

    $auth = new AuthController();

    $message = $auth->login(
        $email,
        $password
    );
}

require_once __DIR__ . "/../views/auth/login.php";