<?php

class Department
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Get active departments
    // Used by Employee module dropdowns
    public function getActiveDepartments()
    {
        $sql = "
            SELECT department_id, department_name
            FROM departments
            WHERE status = 'Active'
            ORDER BY department_name
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all departments
    public function getAllDepartments()
    {
        $sql = "
            SELECT department_id, department_name, description, status
            FROM departments
            ORDER BY department_id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get department by ID
    public function getDepartmentById($departmentId)
{
    $sql = "
        SELECT
            d.department_id,
            d.department_name,
            d.description,
            d.status,
            COUNT(e.employee_id) AS employee_count
        FROM departments d
        LEFT JOIN employees e
            ON e.department_id = d.department_id
            AND e.status = 'Active'
        WHERE d.department_id = :department_id
        GROUP BY
            d.department_id,
            d.department_name,
            d.description,
            d.status
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(
        ":department_id",
        $departmentId,
        PDO::PARAM_INT
    );

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Search departments
    public function searchDepartments($search)
    {
        $sql = "
            SELECT department_id, department_name, description, status
            FROM departments
            WHERE department_name LIKE :search
               OR description LIKE :search
            ORDER BY department_id DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $searchTerm = "%" . $search . "%";

        $stmt->bindValue(
            ":search",
            $searchTerm,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check whether department name already exists
    public function departmentNameExists($departmentName, $excludeId = null)
    {
        $sql = "
            SELECT department_id
            FROM departments
            WHERE department_name = :department_name
        ";

        if ($excludeId !== null) {
            $sql .= " AND department_id != :department_id";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ":department_name",
            $departmentName,
            PDO::PARAM_STR
        );

        if ($excludeId !== null) {
            $stmt->bindValue(
                ":department_id",
                $excludeId,
                PDO::PARAM_INT
            );
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Add department
    public function createDepartment(
        $departmentName,
        $description,
        $status = "Active"
    ) {
        $sql = "
            INSERT INTO departments
            (department_name, description, status)
            VALUES
            (:department_name, :description, :status)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ":department_name",
            $departmentName,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ":description",
            $description,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ":status",
            $status,
            PDO::PARAM_STR
        );

        return $stmt->execute();
    }

    // Update department
    public function updateDepartment(
        $departmentId,
        $departmentName,
        $description,
        $status
    ) {
        $sql = "
            UPDATE departments
            SET department_name = :department_name,
                description = :description,
                status = :status
            WHERE department_id = :department_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ":department_name",
            $departmentName,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ":description",
            $description,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ":status",
            $status,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ":department_id",
            $departmentId,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }

    // Deactivate department
    public function deactivateDepartment($departmentId)
    {
        $sql = "
            UPDATE departments
            SET status = 'Inactive'
            WHERE department_id = :department_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ":department_id",
            $departmentId,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }
}