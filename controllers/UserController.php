<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../services/PasswordService.php";

class UserController
{
    private $userModel;
    private $passwordService;

    public function __construct()
    {
        global $pdo;

        $this->userModel = new User($pdo);
        $this->passwordService = new PasswordService();
    }

    public function createUser(
        $name,
        $email,
        $username,
        $password,
        $role,
        $status
    ) {
        // Required field validation
        if (
            trim($name) === "" ||
            trim($email) === "" ||
            trim($username) === "" ||
            trim($password) === "" ||
            trim($role) === "" ||
            trim($status) === ""
        ) {
            return [
                "success" => false,
                "message" => "All fields are required."
            ];
        }
        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            "success" => false,
            "message" => "Invalid email address."
        ];
    }
    // Password validation
$passwordValidation = $this->passwordService->validate($password);

if ($passwordValidation !== true) {
    return [
        "success" => false,
        "message" => $passwordValidation
    ];
}
// Step 4: Role validation
if (!in_array($role, ["Admin", "Employee"])) {
    return [
        "success" => false,
        "message" => "Invalid role."
    ];
}
// Status validation
if (!in_array($status, ["active", "inactive"])) {
    return [
        "success" => false,
        "message" => "Invalid status."
    ];
}
// Check duplicate email or username
if ($this->userModel->existsByEmailOrUsername($email, $username)) {
    return [
        "success" => false,
        "message" => "Email or username already exists."
    ];
}
        // Hash password
        $hashedPassword = $this->passwordService->hash($password);

        // Store user
        $success = $this->userModel->createUser(
    $name,
    $email,
    $username,
    $hashedPassword,
    $role,
    $status
);

if ($success) {
    return [
        "success" => true,
        "message" => "User created successfully."
    ];
}

return [
    "success" => false,
    "message" => "Failed to create user."
];
    }
}