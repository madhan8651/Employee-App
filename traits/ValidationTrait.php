<?php

trait ValidationTrait
{
    protected function isEmpty($value)
    {
        return trim($value) === "";
    }

    protected function isValidEmail($email)
    {
        return filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        ) !== false;
    }
}