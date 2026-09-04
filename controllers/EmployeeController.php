<?php

require_once __DIR__ . "/../models/Employee.php";
require_once __DIR__ . "/../services/EmployeeService.php";
require_once __DIR__ . "/../utilities/FileUpload.php";
require_once __DIR__ . "/../config/database.php";
class EmployeeController
{
    private $employeeModel;
    private $employeeService;
    private $fileUpload;

    public function __construct()
{
    global $pdo;

    $this->employeeModel = new Employee($pdo);

    $this->employeeService =
        new EmployeeService(
            $this->employeeModel
        );

    $uploadDirectory =
        __DIR__ .
        "/../public/uploads/employees/";

    $this->fileUpload =
        new FileUpload($uploadDirectory);
}

    // =========================
    // CREATE EMPLOYEE
    // =========================

    public function createEmployee(
        $employee_id,
        $first_name,
        $last_name,
        $email,
        $phone,
        $date_of_birth,
        $gender,
        $date_of_joining,
        $department_id,
        $designation,
        $salary,
        $address,
        $profile_photo,
        $status
    ) {

        // =========================
        // EMPLOYEE DATA
        // =========================

        $employeeData = [
            "employee_id" => $employee_id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "phone" => $phone,
            "date_of_birth" => $date_of_birth,
            "gender" => $gender,
            "date_of_joining" => $date_of_joining,
            "department_id" => $department_id,
            "designation" => $designation,
            "salary" => $salary,
            "address" => $address,
            "status" => $status
        ];


        // =========================
        // REQUIRED FIELD VALIDATION
        // =========================

        $requiredValidation =
            $this->employeeService->validateRequiredFields(
                $employeeData
            );

        if (!$requiredValidation["success"]) {
            return $requiredValidation;
        }


        


        // =========================
        // PROFILE PHOTO
        // =========================

        $profilePhoto = "";

if (
    $profile_photo !== null &&
    $profile_photo["error"] !== UPLOAD_ERR_NO_FILE
) {

    $uploadResult =
        $this->fileUpload->upload(
            $profile_photo
        );

    if (!$uploadResult["success"]) {
        return $uploadResult;
    }

    $profilePhoto =
        $uploadResult["filename"];
}


        // =========================
        // VALIDATE STATUS
        // =========================

        $statusValidation =
            $this->employeeService->validateStatus(
                $status
            );

        if (!$statusValidation["success"]) {
            return $statusValidation;
        }
        $duplicateCheck =
    $this->employeeService->checkDuplicate(
        $employee_id,
        $email
    );

if (!$duplicateCheck["success"]) {
    return $duplicateCheck;
}


        // =========================
        // VALIDATE GENDER
        // =========================

        $genderValidation =
            $this->employeeService->validateGender(
                $gender
            );

        if (!$genderValidation["success"]) {
            return $genderValidation;
        }


        // =========================
        // VALIDATE EMPLOYEE ID
        // =========================

        $employeeIdValidation =
            $this->employeeService->validateEmployeeId(
                $employee_id
            );

        if (!$employeeIdValidation["success"]) {
            return $employeeIdValidation;
        }


        // =========================
        // VALIDATE EMAIL
        // =========================

        $emailValidation =
            $this->employeeService->validateEmail(
                $email
            );

        if (!$emailValidation["success"]) {
            return $emailValidation;
        }


        // =========================
        // VALIDATE PHONE
        // =========================

        $phoneValidation =
            $this->employeeService->validatePhone(
                $phone
            );

        if (!$phoneValidation["success"]) {
            return $phoneValidation;
        }


        // =========================
        // VALIDATE DATE OF BIRTH
        // =========================

        $dateOfBirthValidation =
            $this->employeeService->validateDateOfBirth(
                $date_of_birth
            );

        if (!$dateOfBirthValidation["success"]) {
            return $dateOfBirthValidation;
        }


        // =========================
        // VALIDATE DATE OF JOINING
        // =========================

        $dateOfJoiningValidation =
            $this->employeeService->validateDateOfJoining(
                $date_of_joining
            );

        if (!$dateOfJoiningValidation["success"]) {
            return $dateOfJoiningValidation;
        }


        // =========================
        // VALIDATE SALARY
        // =========================

        $salaryValidation =
            $this->employeeService->validateSalary(
                $salary
            );

        if (!$salaryValidation["success"]) {
            return $salaryValidation;
        }


        // =========================
        // CREATE EMPLOYEE
        // =========================

        $success =
            $this->employeeModel->createEmployee(
                $employee_id,
                $first_name,
                $last_name,
                $email,
                $phone,
                $date_of_birth,
                $gender,
                $date_of_joining,
                $department_id,
                $designation,
                $salary,
                $address,
                $profilePhoto,
                $status
            );


        // =========================
        // SUCCESS
        // =========================

        if ($success) {
            return [
                "success" => true,
                "message" =>
                    "Employee created successfully."
            ];
        }


        return [
            "success" => false,
            "message" =>
                "Failed to create employee."
        ];
    }


    // =========================
    // GET ALL EMPLOYEES
    // =========================

    public function getAllEmployees()
    {
        return $this->employeeModel
            ->getAllEmployees();
    }
    // =========================
// GET PAGINATED EMPLOYEES
// =========================

public function getEmployeesPaginated($limit, $offset)
{
    return $this->employeeModel
        ->getEmployeesPaginated(
            $limit,
            $offset
        );
}
// =========================
// GET FILTERED EMPLOYEES WITH PAGINATION
// =========================

public function getFilteredEmployees(
    $search,
    $department_id,
    $status,
    $sort,
    $limit,
    $offset
) {
    return $this->employeeModel
        ->getFilteredEmployees(
            $search,
            $department_id,
            $status,
            $sort,
            $limit,
            $offset
        );
}
// =========================
// COUNT FILTERED EMPLOYEES
// =========================

public function countFilteredEmployees(
    $search,
    $department_id,
    $status
) {
    return $this->employeeModel
        ->countFilteredEmployees(
            $search,
            $department_id,
            $status
        );
}

    // =========================
    // SEARCH EMPLOYEES
    // =========================

    public function searchEmployees($search)
    {
        return $this->employeeModel
            ->searchEmployees($search);
    }


    // =========================
    // GET EMPLOYEE BY ID
    // =========================

    public function getEmployeeById($employee_id)
    {
        return $this->employeeModel
            ->getEmployeeById($employee_id);
    }


    // =========================
    // FILTER BY DEPARTMENT
    // =========================

    public function getEmployeesByDepartment(
        $department_id
    ) {
        return $this->employeeModel
            ->getEmployeesByDepartment(
                $department_id
            );
    }


    // =========================
    // FILTER BY STATUS
    // =========================

    public function getEmployeesByStatus($status)
    {
        return $this->employeeModel
            ->getEmployeesByStatus($status);
    }


    // =========================
    // SORT EMPLOYEES
    // =========================

    public function getEmployeesSorted($sort)
    {
        return $this->employeeModel
            ->getEmployeesSorted($sort);
    }


    // =========================
    // UPDATE EMPLOYEE
    // =========================

    public function updateEmployee(
        $employee_id,
        $data
    ) {

        // Make sure employee exists
        $employee =
            $this->employeeModel
                ->getEmployeeById(
                    $employee_id
                );

        if (!$employee) {
            return [
                "success" => false,
                "message" =>
                    "Employee not found."
            ];
        }


        // Store old profile photo
        $oldProfilePhoto =
            $employee["profile_photo"];


        // =========================
        // VALIDATION
        // =========================

        // Validate email
        if (isset($data["email"])) {

            $emailValidation =
                $this->employeeService->validateEmail(
                    $data["email"]
                );

            if (!$emailValidation["success"]) {
                return $emailValidation;
            }
        }


        // Validate phone
        if (isset($data["phone"])) {

            $phoneValidation =
                $this->employeeService->validatePhone(
                    $data["phone"]
                );

            if (!$phoneValidation["success"]) {
                return $phoneValidation;
            }
        }


        // Validate date of birth
        if (isset($data["date_of_birth"])) {

            $dateOfBirthValidation =
                $this->employeeService->validateDateOfBirth(
                    $data["date_of_birth"]
                );

            if (!$dateOfBirthValidation["success"]) {
                return $dateOfBirthValidation;
            }
        }


        // Validate date of joining
        if (isset($data["date_of_joining"])) {

            $dateOfJoiningValidation =
                $this->employeeService->validateDateOfJoining(
                    $data["date_of_joining"]
                );

            if (!$dateOfJoiningValidation["success"]) {
                return $dateOfJoiningValidation;
            }
        }


        // Validate salary
        if (isset($data["salary"])) {

            $salaryValidation =
                $this->employeeService->validateSalary(
                    $data["salary"]
                );

            if (!$salaryValidation["success"]) {
                return $salaryValidation;
            }
        }


        // Validate gender
        if (isset($data["gender"])) {

            $genderValidation =
                $this->employeeService->validateGender(
                    $data["gender"]
                );

            if (!$genderValidation["success"]) {
                return $genderValidation;
            }
        }


        // Validate status
        if (isset($data["status"])) {

            $statusValidation =
                $this->employeeService->validateStatus(
                    $data["status"]
                );

            if (!$statusValidation["success"]) {
                return $statusValidation;
            }
        }


        // =========================
        // HANDLE PROFILE PHOTO
        // =========================

        if (
    isset($_FILES["profile_photo"]) &&
    $_FILES["profile_photo"]["error"] !==
    UPLOAD_ERR_NO_FILE
) {

    $uploadResult =
        $this->fileUpload->upload(
            $_FILES["profile_photo"]
        );

    if (!$uploadResult["success"]) {
        return $uploadResult;
    }

    $data["profile_photo"] =
        $uploadResult["filename"];
}


        // =========================
        // UPDATE DATABASE
        // =========================

        $success =
            $this->employeeModel
                ->updateEmployee(
                    $employee_id,
                    $data
                );


        // =========================
        // SUCCESS
        // =========================

        if ($success) {

            // Delete old profile photo
            if (
                isset($data["profile_photo"]) &&
                !empty($oldProfilePhoto)
            ) {

                $oldPhotoPath =
                    __DIR__ .
                    "/../public/uploads/employees/" .
                    $oldProfilePhoto;

                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }


            return [
                "success" => true,
                "message" =>
                    "Employee updated successfully."
            ];
        }


        // =========================
        // NO UPDATE
        // =========================

        return [
            "success" => false,
            "message" =>
                "No changes were made."
        ];
    }


    // =========================
    // DEACTIVATE EMPLOYEE
    // =========================

    public function deactivateEmployee(
        $employee_id
    ) {
        return $this->employeeModel
            ->updateEmployee(
                $employee_id,
                [
                    "status" => "inactive"
                ]
            );
    }
}