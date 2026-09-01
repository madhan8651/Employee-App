<?php

class PasswordService
{
    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verify($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public function validate($password)
    {
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return "Password must contain an uppercase letter";
        }

        if (!preg_match('/[a-z]/', $password)) {
            return "Password must contain a lowercase letter";
        }

        if (!preg_match('/[0-9]/', $password)) {
            return "Password must contain a number";
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            return "Password must contain a special character";
        }

        return true;
    }
}