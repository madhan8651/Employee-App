<?php

require_once __DIR__ . "/../config/database.php";

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByLogin($login)
{
    $sql = "
        SELECT
            user_id,
            name,
            email,
            username,
            password,
            role,
            status
        FROM users
        WHERE email = :login
           OR username = :login
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        "login" => $login
    ]);

    return $stmt->fetch();
}
    public function updatePassword($userId, $newPassword)
{
    $sql = "
        UPDATE users
        SET password = :password
        WHERE user_id = :user_id
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        "password" => $newPassword,
        "user_id" => $userId
    ]);
}
public function findByUserId($user_id){
    $sql = "
        SELECT
            user_id,
            name,
            email,
            username,
            password,
            role,
            status
        FROM users
        WHERE user_id = :user_id
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        "user_id" => $user_id
    ]);

    return $stmt->fetch();
}
public function createUser($name, $email, $username, $password, $role, $status)
{
    $sql = "
        INSERT INTO users
        (name, email, username, password, role, status)
        VALUES
        (:name, :email, :username, :password, :role, :status)
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        "name" => $name,
        "email" => $email,
        "username" => $username,
        "password" => $password,
        "role" => $role,
        "status" => $status
    ]);
}
}