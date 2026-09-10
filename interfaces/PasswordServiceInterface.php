<?php

interface PasswordServiceInterface
{
    public function hash($password);

    public function verify($password, $hashedPassword);

    public function validate($password);
}