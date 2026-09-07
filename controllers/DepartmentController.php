<?php
require_once __DIR__ . "/../services/DepartmentService.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Department.php";

class DepartmentController
{
    private $departmentModel;
    private $departmentService;
    public function __construct()
{
    global $pdo;

    $this->departmentModel =
        new Department($pdo);

    $this->departmentService =
        new DepartmentService(
            $this->departmentModel
        );
}

    // Get all departments
    public function getAllDepartments()
    {
        return $this->departmentModel->getAllDepartments();
    }

    // Get department by ID
    public function getDepartmentById($departmentId)
    {
        return $this->departmentModel->getDepartmentById($departmentId);
    }

    // Search departments
    public function searchDepartments($search)
    {
        return $this->departmentModel->searchDepartments($search);
    }

    // Add department
    public function createDepartment(
    $departmentName,
    $description,
    $status = "Active"
) {
    $departmentName = trim($departmentName);
    $description = trim($description);
    $status = trim($status);


    // Validate department name
    $nameValidation =
        $this->departmentService
            ->validateDepartmentName(
                $departmentName
            );

    if (!$nameValidation["success"]) {
        return $nameValidation;
    }


    // Validate status
    $statusValidation =
        $this->departmentService
            ->validateStatus(
                $status
            );

    if (!$statusValidation["success"]) {
        return $statusValidation;
    }


    // Check duplicate department name
    $duplicateValidation =
        $this->departmentService
            ->checkDuplicateDepartmentName(
                $departmentName
            );

    if (!$duplicateValidation["success"]) {
        return $duplicateValidation;
    }


    // Create department
    $created =
        $this->departmentModel->createDepartment(
            $departmentName,
            $description,
            $status
        );


    if ($created) {

        return [
            "success" => true,
            "message" => "Department added successfully."
        ];
    }


    return [
        "success" => false,
        "message" => "Unable to add department."
    ];
}

    // Edit department
    public function updateDepartment(
    $departmentId,
    $departmentName,
    $description,
    $status
) {
    $departmentId = (int) $departmentId;
    $departmentName = trim($departmentName);
    $description = trim($description);
    $status = trim($status);


    // Validate ID
    $idValidation =
        $this->departmentService
            ->validateDepartmentId(
                $departmentId
            );

    if (!$idValidation["success"]) {
        return $idValidation;
    }


    // Validate name
    $nameValidation =
        $this->departmentService
            ->validateDepartmentName(
                $departmentName
            );

    if (!$nameValidation["success"]) {
        return $nameValidation;
    }


    // Validate status
    $statusValidation =
        $this->departmentService
            ->validateStatus(
                $status
            );

    if (!$statusValidation["success"]) {
        return $statusValidation;
    }


    // Check department exists
    $department =
        $this->departmentModel
            ->getDepartmentById(
                $departmentId
            );

    if (!$department) {

        return [
            "success" => false,
            "message" => "Department not found."
        ];
    }


    // Check duplicate name
    $duplicateValidation =
        $this->departmentService
            ->checkDuplicateDepartmentName(
                $departmentName,
                $departmentId
            );

    if (!$duplicateValidation["success"]) {
        return $duplicateValidation;
    }


    // Update department
    $updated =
        $this->departmentModel->updateDepartment(
            $departmentId,
            $departmentName,
            $description,
            $status
        );


    if ($updated) {

        return [
            "success" => true,
            "message" => "Department updated successfully."
        ];
    }


    return [
        "success" => false,
        "message" => "Unable to update department."
    ];
}

    // Deactivate department
    public function deactivateDepartment($departmentId)
{
    $idValidation =
        $this->departmentService
            ->validateDepartmentId(
                $departmentId
            );

    if (!$idValidation["success"]) {
        return $idValidation;
    }


    $department =
        $this->departmentModel
            ->getDepartmentById(
                $departmentId
            );

    if (!$department) {

        return [
            "success" => false,
            "message" => "Department not found."
        ];
    }


    if ($department["status"] === "Inactive") {

        return [
            "success" => false,
            "message" => "Department is already inactive."
        ];
    }


    $deactivated =
        $this->departmentModel
            ->deactivateDepartment(
                $departmentId
            );


    if ($deactivated) {

        return [
            "success" => true,
            "message" =>
                "Department deactivated successfully."
        ];
    }


    return [
        "success" => false,
        "message" =>
            "Unable to deactivate department."
    ];
}
}