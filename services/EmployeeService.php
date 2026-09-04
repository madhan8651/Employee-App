<?php

class EmployeeService
{
    private $employeeModel;

    public function __construct($employeeModel)
    {
        $this->employeeModel = $employeeModel;
    }

    public function checkDuplicate($employee_id, $email)
    {
        $existingEmployee = $this->employeeModel->existsByEmployeeIdOrEmail(
            $employee_id,
            $email
        );

        if ($existingEmployee) {

            if ($existingEmployee["employee_id"] === $employee_id) {
                return [
                    "success" => false,
                    "message" => "Employee ID already exists."
                ];
            }

            if ($existingEmployee["email"] === $email) {
                return [
                    "success" => false,
                    "message" => "Email already exists."
                ];
            }
        }

        return [
            "success" => true
        ];
    }

public function validateRequiredFields($data)
{
    $requiredFields = [
    "employee_id",
    "first_name",
    "last_name",
    "email",
    "phone",
    "date_of_birth",
    "gender",
    "date_of_joining",
    "department_id",
    "designation",
    "salary",
    "address",
    "status"
];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === "") {
            return [
                "success" => false,
                "message" => $field === "department_id"
    ? "Department is required."
    : ucfirst(str_replace("_", " ", $field)) . " is required."
            ];
        }
    }

    return [
        "success" => true
    ];
}
public function validateEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            "success" => false,
            "message" => "Invalid email address."
        ];
    }

    return [
        "success" => true
    ];
}
public function validateEmployeeId($employee_id)
{
    if (!preg_match('/^EMP[0-9]{3}$/', $employee_id)) {
        return [
            "success" => false,
            "message" => "Employee ID must be in the format EMP001."
        ];
    }

    return [
        "success" => true
    ];
}
public function validatePhone($phone)
{
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        return [
            "success" => false,
            "message" => "Phone number must contain exactly 10 digits."
        ];
    }

    return [
        "success" => true
    ];
}
public function validateDateOfBirth($date_of_birth)
{
    if ($date_of_birth > date("Y-m-d")) {
        return [
            "success" => false,
            "message" => "Date of birth cannot be a future date."
        ];
    }

    return [
        "success" => true
    ];
}
public function validateDateOfJoining($date_of_joining)
{
    if ($date_of_joining > date("Y-m-d")) {
        return [
            "success" => false,
            "message" => "Date of joining cannot be a future date."
        ];
    }

    return [
        "success" => true
    ];
}
public function validateSalary($salary)
{
    if (!is_numeric($salary) || $salary <= 0) {
        return [
            "success" => false,
            "message" => "Salary must be greater than 0."
        ];
    }

    return [
        "success" => true
    ];
}
public function validateGender($gender)
{
    if (!in_array($gender, ["Male", "Female", "Other"])) {
        return [
            "success" => false,
            "message" => "Invalid gender selected."
        ];
    }

    return [
        "success" => true
    ];
}
public function validateStatus($status)
{
    if (!in_array($status, ["active", "inactive"])) {
        return [
            "success" => false,
            "message" => "Invalid status selected."
        ];
    }

    return [
        "success" => true
    ];
}
}