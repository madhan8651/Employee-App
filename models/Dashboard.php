<?php

class Dashboard
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function getDashboardSummary()
{
    $sql = "
        SELECT
            COUNT(*) AS total_employees,
            SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) AS active_employees,
            SUM(CASE WHEN status = 'Inactive' THEN 1 ELSE 0 END) AS inactive_employees
        FROM employees
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $departmentStmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM departments
    ");

    $departmentStmt->execute();

    $result["total_departments"] =
        $departmentStmt->fetchColumn();

    return $result;
}
public function getEmployeesByDepartment()
{
    $sql = "
        SELECT
            d.department_id,
            d.department_name,
            COUNT(e.employee_id) AS employee_count
        FROM departments d
        LEFT JOIN employees e
            ON d.department_id = e.department_id
        GROUP BY
            d.department_id,
            d.department_name
        ORDER BY
            d.department_name
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
