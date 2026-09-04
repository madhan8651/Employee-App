<?php

class AuthenticationService
{
    private $userModel;
    private $passwordService;

    public function __construct($userModel, $passwordService)
    {
        $this->userModel = $userModel;
        $this->passwordService = $passwordService;
    }

    public function authenticate($login, $password)
{
    $login = trim($login);
    $password = trim($password);

    if ($login === "" || $password === "") {
        return "Username or password is required";
    }

    $user = $this->userModel->findByLogin($login);

    if (!$user) {
        return "Username or password is wrong";
    }

    if (strtolower(trim($user["status"])) !== "active") {
        return "User account is inactive";
    }

    if (!$this->passwordService->verify(
        $password,
        $user["password"]
    )) {
        return "Username or password is wrong";
    }

    return $user;
}
}