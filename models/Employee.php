<?php

require_once __DIR__ . "/../config/database.php";

class Employee
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

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
        $sql = "
            INSERT INTO employees
            (
                employee_id,
                first_name,
                last_name,
                email,
                phone,
                date_of_birth,
                gender,
                date_of_joining,
                department_id,
                designation,
                salary,
                address,
                profile_photo,
                status
            )
            VALUES
            (
                :employee_id,
                :first_name,
                :last_name,
                :email,
                :phone,
                :date_of_birth,
                :gender,
                :date_of_joining,
                :department_id,
                :designation,
                :salary,
                :address,
                :profile_photo,
                :status
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
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
            "profile_photo" => $profile_photo,
            "status" => $status
        ]);
    }

    public function existsByEmployeeIdOrEmail($employee_id, $email)
    {
        $sql = "
            SELECT employee_id, email
            FROM employees
            WHERE employee_id = :employee_id
               OR email = :email
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "employee_id" => $employee_id,
            "email" => $email
        ]);

        return $stmt->fetch();
    }

    public function getAllEmployees()
    {
        $sql = "
            SELECT
                e.employee_id,
                e.first_name,
                e.last_name,
                e.email,
                e.phone,
                e.designation,
                e.salary,
                e.status,
                d.department_name
            FROM employees e
            LEFT JOIN departments d
                ON e.department_id = d.department_id
            ORDER BY e.employee_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function searchEmployees($search)
{
    $sql = "
        SELECT
            e.employee_id,
            e.first_name,
            e.last_name,
            e.email,
            e.phone,
            e.designation,
            e.salary,
            e.status,
            d.department_name
        FROM employees e
        LEFT JOIN departments d
            ON e.department_id = d.department_id
        WHERE
            e.employee_id LIKE :search
            OR e.first_name LIKE :search
            OR e.last_name LIKE :search
            OR CONCAT(e.first_name, ' ', e.last_name) LIKE :search
            OR e.email LIKE :search
            OR e.phone LIKE :search
        ORDER BY e.employee_id
    ";

    $stmt = $this->pdo->prepare($sql);

    $searchValue = "%" . trim($search) . "%";

    $stmt->execute([
        "search" => $searchValue
    ]);

    return $stmt->fetchAll();
}
public function getEmployeesPaginated($limit, $offset)
{
    $sql = "
        SELECT
            e.employee_id,
            e.first_name,
            e.last_name,
            e.email,
            e.phone,
            e.designation,
            e.salary,
            e.status,
            d.department_name
        FROM employees e
        LEFT JOIN departments d
            ON e.department_id = d.department_id
        ORDER BY e.employee_id
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(":limit", (int) $limit, PDO::PARAM_INT);
    $stmt->bindValue(":offset", (int) $offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll();
}
public function getEmployeesByDepartment($department_id)
{
    $sql = "
        SELECT
            e.employee_id,
            e.first_name,
            e.last_name,
            e.email,
            e.phone,
            e.designation,
            e.salary,
            e.status,
            d.department_name
        FROM employees e
        LEFT JOIN departments d
            ON e.department_id = d.department_id
        WHERE e.department_id = :department_id
        ORDER BY e.employee_id
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        "department_id" => $department_id
    ]);

    return $stmt->fetchAll();
}
public function getEmployeesByStatus($status)
{
    $sql = "
        SELECT
            e.employee_id,
            e.first_name,
            e.last_name,
            e.email,
            e.phone,
            e.designation,
            e.salary,
            e.status,
            d.department_name
        FROM employees e
        LEFT JOIN departments d
            ON e.department_id = d.department_id
        WHERE e.status = :status
        ORDER BY e.employee_id
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        "status" => $status
    ]);

    return $stmt->fetchAll();
}
public function getEmployeesSorted($sort)
{
    $allowedSorts = [
        "employee_id" => "e.employee_id",
        "name"        => "e.first_name",
        "department"  => "d.department_name",
        "salary"      => "e.salary"
    ];

    $sortColumn = $allowedSorts[$sort] ?? "e.employee_id";

    $sql = "
        SELECT
            e.employee_id,
            e.first_name,
            e.last_name,
            e.email,
            e.phone,
            e.designation,
            e.salary,
            e.status,
            d.department_name
        FROM employees e
        LEFT JOIN departments d
            ON e.department_id = d.department_id
        ORDER BY $sortColumn
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

    public function getEmployeeById($employee_id)
    {
        $sql = "
            SELECT
                employee_id,
                first_name,
                last_name,
                email,
                phone,
                date_of_birth,
                gender,
                date_of_joining,
                department_id,
                designation,
                salary,
                address,
                profile_photo,
                status
            FROM employees
            WHERE employee_id = :employee_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "employee_id" => $employee_id
        ]);

        return $stmt->fetch();
    }

    public function updateEmployee($employee_id, $data)
    {
        $allowedFields = [
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
            "status",
            "profile_photo"
        ];

        $fields = [];

        $values = [
            "employee_id" => $employee_id
        ];

        foreach ($data as $column => $value) {

            if (!in_array($column, $allowedFields)) {
                continue;
            }

            $fields[] = "$column = :$column";

            $values[$column] = $value;
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "
            UPDATE employees
            SET " . implode(", ", $fields) . ",
                updated_at = NOW()
            WHERE employee_id = :employee_id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($values);
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
    $sql = "
        SELECT
            e.employee_id,
            e.first_name,
            e.last_name,
            e.email,
            e.phone,
            e.designation,
            e.salary,
            e.status,
            d.department_name
        FROM employees e
        LEFT JOIN departments d
            ON e.department_id = d.department_id
        WHERE 1=1
    ";

    $params = [];


    // Search
    if ($search !== "") {

        $sql .= "
            AND (
                e.employee_id LIKE :search
                OR e.first_name LIKE :search
                OR e.last_name LIKE :search
                OR CONCAT(e.first_name, ' ', e.last_name) LIKE :search
                OR e.email LIKE :search
                OR e.phone LIKE :search
            )
        ";

        $params["search"] = "%" . trim($search) . "%";
    }


    // Department
    if ($department_id !== "") {

        $sql .= "
            AND e.department_id = :department_id
        ";

        $params["department_id"] = $department_id;
    }


    // Status
    if ($status !== "") {

        $sql .= "
            AND e.status = :status
        ";

        $params["status"] = $status;
    }


    // Sorting
    $allowedSorts = [
        "employee_id" => "e.employee_id",
        "name"        => "e.first_name",
        "salary"      => "e.salary"
    ];

    $sortColumn = $allowedSorts[$sort] ?? "e.employee_id";

    $sql .= "
        ORDER BY $sortColumn
        LIMIT :limit OFFSET :offset
    ";


    $stmt = $this->pdo->prepare($sql);


    foreach ($params as $key => $value) {
        $stmt->bindValue(
            ":" . $key,
            $value
        );
    }

    $stmt->bindValue(
        ":limit",
        (int) $limit,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ":offset",
        (int) $offset,
        PDO::PARAM_INT
    );


    $stmt->execute();

    return $stmt->fetchAll();
}
// =========================
// COUNT FILTERED EMPLOYEES
// =========================

public function countFilteredEmployees(
    $search,
    $department_id,
    $status
) {
    $sql = "
        SELECT COUNT(*)
        FROM employees e
        WHERE 1=1
    ";

    $params = [];


    // Search
    if ($search !== "") {

        $sql .= "
            AND (
                e.employee_id LIKE :search
                OR e.first_name LIKE :search
                OR e.last_name LIKE :search
                OR CONCAT(e.first_name, ' ', e.last_name) LIKE :search
                OR e.email LIKE :search
                OR e.phone LIKE :search
            )
        ";

        $params["search"] = "%" . trim($search) . "%";
    }


    // Department
    if ($department_id !== "") {

        $sql .= "
            AND e.department_id = :department_id
        ";

        $params["department_id"] = $department_id;
    }


    // Status
    if ($status !== "") {

        $sql .= "
            AND e.status = :status
        ";

        $params["status"] = $status;
    }


    $stmt = $this->pdo->prepare($sql);

    $stmt->execute($params);

    return $stmt->fetchColumn();
}
}