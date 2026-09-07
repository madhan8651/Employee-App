<?php

class DepartmentService
{
    private $departmentModel;

    public function __construct($departmentModel)
    {
        $this->departmentModel = $departmentModel;
    }


    // =========================
    // VALIDATE DEPARTMENT NAME
    // =========================

    public function validateDepartmentName($departmentName)
    {
        $departmentName = trim($departmentName);

        if ($departmentName === "") {
            return [
                "success" => false,
                "message" => "Department name is required."
            ];
        }

        if (strlen($departmentName) > 100) {
            return [
                "success" => false,
                "message" =>
                    "Department name must not exceed 100 characters."
            ];
        }

        return [
            "success" => true,
            "message" => "Valid department name."
        ];
    }


    // =========================
    // VALIDATE STATUS
    // =========================

    public function validateStatus($status)
    {
        $status = trim($status);

        if (!in_array(
            $status,
            ["Active", "Inactive"],
            true
        )) {
            return [
                "success" => false,
                "message" => "Invalid department status."
            ];
        }

        return [
            "success" => true,
            "message" => "Valid department status."
        ];
    }


    // =========================
    // CHECK DUPLICATE NAME
    // =========================

    public function checkDuplicateDepartmentName(
        $departmentName,
        $excludeId = null
    ) {
        if (
            $this->departmentModel->departmentNameExists(
                $departmentName,
                $excludeId
            )
        ) {
            return [
                "success" => false,
                "message" => "Department name already exists."
            ];
        }

        return [
            "success" => true,
            "message" => "Department name is available."
        ];
    }


    // =========================
    // VALIDATE DEPARTMENT ID
    // =========================

    public function validateDepartmentId($departmentId)
    {
        $departmentId = (int) $departmentId;

        if ($departmentId <= 0) {
            return [
                "success" => false,
                "message" => "Invalid department ID."
            ];
        }

        return [
            "success" => true,
            "message" => "Valid department ID."
        ];
    }
}