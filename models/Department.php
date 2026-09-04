<?php

class Department
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

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

        return $stmt->fetchAll();
    }
}