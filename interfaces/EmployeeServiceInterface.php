<?php

interface EmployeeServiceInterface
{
    public function validateRequiredFields($data);

    public function validateEmail($email);

    public function validateEmployeeId($employee_id);

    public function validatePhone($phone);

    public function validateDateOfBirth($date_of_birth);

    public function validateDateOfJoining($date_of_joining);

    public function validateSalary($salary);

    public function validateGender($gender);

    public function validateStatus($status);

    public function validateProfileUpdate($data);
}