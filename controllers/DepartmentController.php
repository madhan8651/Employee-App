<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Department.php";

class DepartmentController
{
    private $departmentModel;

    public function __construct()
    {
        global $pdo;

        $this->departmentModel = new Department($pdo);
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

        if ($departmentName === "") {
            return [
                "success" => false,
                "message" => "Department name is required."
            ];
        }

        if (strlen($departmentName) > 100) {
            return [
                "success" => false,
                "message" => "Department name must not exceed 100 characters."
            ];
        }

        if (!in_array($status, ["Active", "Inactive"], true)) {
            return [
                "success" => false,
                "message" => "Invalid department status."
            ];
        }

        if ($this->departmentModel->departmentNameExists($departmentName)) {
            return [
                "success" => false,
                "message" => "Department name already exists."
            ];
        }

        $created = $this->departmentModel->createDepartment(
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

        if ($departmentId <= 0) {
            return [
                "success" => false,
                "message" => "Invalid department ID."
            ];
        }

        if ($departmentName === "") {
            return [
                "success" => false,
                "message" => "Department name is required."
            ];
        }

        if (strlen($departmentName) > 100) {
            return [
                "success" => false,
                "message" => "Department name must not exceed 100 characters."
            ];
        }

        if (!in_array($status, ["Active", "Inactive"], true)) {
            return [
                "success" => false,
                "message" => "Invalid department status."
            ];
        }

        $department = $this->departmentModel->getDepartmentById($departmentId);

        if (!$department) {
            return [
                "success" => false,
                "message" => "Department not found."
            ];
        }

        if (
            $this->departmentModel->departmentNameExists(
                $departmentName,
                $departmentId
            )
        ) {
            return [
                "success" => false,
                "message" => "Department name already exists."
            ];
        }

        $updated = $this->departmentModel->updateDepartment(
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
        $departmentId = (int) $departmentId;

        if ($departmentId <= 0) {
            return [
                "success" => false,
                "message" => "Invalid department ID."
            ];
        }

        $department = $this->departmentModel->getDepartmentById($departmentId);

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

        $deactivated = $this->departmentModel->deactivateDepartment(
            $departmentId
        );

        if ($deactivated) {
            return [
                "success" => true,
                "message" => "Department deactivated successfully."
            ];
        }

        return [
            "success" => false,
            "message" => "Unable to deactivate department."
        ];
    }
}
