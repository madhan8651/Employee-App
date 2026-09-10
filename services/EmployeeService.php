<?php

namespace App\Services;

require_once __DIR__ . "/../interfaces/EmployeeServiceInterface.php";
require_once __DIR__ . "/../traits/ValidationTrait.php";

class EmployeeService implements \EmployeeServiceInterface
{
    use \ValidationTrait;

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

            if (
                !isset($data[$field]) ||
                $this->isEmpty($data[$field])
            ) {
                return [
                    "success" => false,
                    "message" => $field === "department_id"
                        ? "Department is required."
                        : ucfirst(
                            str_replace("_", " ", $field)
                        ) . " is required."
                ];
            }
        }

        return [
            "success" => true
        ];
    }

    public function validateEmail($email)
    {
        if (!$this->isValidEmail($email)) {
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

    // =========================
    // VALIDATE EMPLOYEE PROFILE UPDATE
    // =========================

    public function validateProfileUpdate($data)
    {
        $allowedFields = [
            "phone",
            "address",
            "profile_photo"
        ];

        foreach ($data as $field => $value) {

            if (!in_array($field, $allowedFields)) {

                return [
                    "success" => false,
                    "message" =>
                        "You are not allowed to update this field."
                ];
            }
        }

        // Validate phone if provided
        if (isset($data["phone"])) {

            $phoneValidation =
                $this->validatePhone(
                    $data["phone"]
                );

            if (!$phoneValidation["success"]) {
                return $phoneValidation;
            }
        }

        // Validate address if provided
        if (isset($data["address"])) {

            if ($this->isEmpty($data["address"])) {

                return [
                    "success" => false,
                    "message" =>
                        "Address cannot be empty."
                ];
            }
        }

        // Profile photo filename check
        if (isset($data["profile_photo"])) {

            if (
                !is_string($data["profile_photo"]) ||
                $this->isEmpty($data["profile_photo"])
            ) {

                return [
                    "success" => false,
                    "message" =>
                        "Invalid profile photo."
                ];
            }
        }

        if (empty($data)) {

            return [
                "success" => false,
                "message" =>
                    "No profile changes were provided."
            ];
        }

        return [
            "success" => true
        ];
    }
}