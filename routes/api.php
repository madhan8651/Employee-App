<?php

require_once __DIR__ . "/../utilities/Response.php";

$method = $_SERVER["REQUEST_METHOD"];

$path = parse_url(
    $_SERVER["REQUEST_URI"],
    PHP_URL_PATH
);

$basePath = "/Employee_App/routes/api.php";

$path = str_replace(
    $basePath,
    "",
    $path
);


/*
|--------------------------------------------------------------------------|
| GET ALL EMPLOYEES
|--------------------------------------------------------------------------|
*/

if ($method === "GET" && $path === "/employees") {

    require_once __DIR__ . "/../controllers/EmployeeController.php";

    $controller = new EmployeeController();

    $employees = $controller->getAllEmployees();

    Response::json(
        $employees,
        200
    );
}


/*
|--------------------------------------------------------------------------|
| GET SINGLE EMPLOYEE
|--------------------------------------------------------------------------|
*/

if (
    $method === "GET" &&
    preg_match(
        "#^/employees/([^/]+)$#",
        $path,
        $matches
    )
) {

    require_once __DIR__ . "/../controllers/EmployeeController.php";

    $controller = new EmployeeController();

    $employeeId = $matches[1];

    $employee = $controller->getEmployeeById(
        $employeeId
    );

    if (!$employee) {

        Response::json(
            [
                "success" => false,
                "message" => "Employee not found."
            ],
            404
        );
    }

    Response::json(
        $employee,
        200
    );
}


/*
|--------------------------------------------------------------------------|
| CREATE EMPLOYEE
|--------------------------------------------------------------------------|
*/

if ($method === "POST" && $path === "/employees") {

    $input = json_decode(
        file_get_contents("php://input"),
        true
    );

    if (!is_array($input)) {

        Response::json(
            [
                "success" => false,
                "message" => "Invalid JSON request body."
            ],
            400
        );
    }

    require_once __DIR__ . "/../controllers/EmployeeController.php";

    $controller = new EmployeeController();

    $result = $controller->createEmployee(
        $input["employee_id"] ?? "",
        $input["first_name"] ?? "",
        $input["last_name"] ?? "",
        $input["email"] ?? "",
        $input["phone"] ?? "",
        $input["date_of_birth"] ?? "",
        $input["gender"] ?? "",
        $input["date_of_joining"] ?? "",
        $input["department_id"] ?? "",
        $input["designation"] ?? "",
        $input["salary"] ?? "",
        $input["address"] ?? "",
        null,
        $input["status"] ?? ""
    );

    if ($result["success"]) {

        Response::json(
            $result,
            201
        );
    }

    Response::json(
        $result,
        400
    );
}


/*
|--------------------------------------------------------------------------|
| UPDATE EMPLOYEE
|--------------------------------------------------------------------------|
*/

if (
    $method === "PUT" &&
    preg_match(
        "#^/employees/([^/]+)$#",
        $path,
        $matches
    )
) {

    $employeeId = $matches[1];

    $input = json_decode(
        file_get_contents("php://input"),
        true
    );

    if (!is_array($input)) {

        Response::json(
            [
                "success" => false,
                "message" => "Invalid JSON request body."
            ],
            400
        );
    }

    require_once __DIR__ . "/../controllers/EmployeeController.php";

    $controller = new EmployeeController();

    $result = $controller->updateEmployee(
        $employeeId,
        $input
    );

    if ($result["success"]) {

        Response::json(
            $result,
            200
        );
    }

    Response::json(
        $result,
        400
    );
}
if (
    $method === "DELETE" &&
    preg_match(
        "#^/employees/([^/]+)$#",
        $path,
        $matches
    )
) {

    $employeeId = $matches[1];

    require_once __DIR__ . "/../controllers/EmployeeController.php";

    $controller = new EmployeeController();

    $result = $controller->deactivateEmployee(
        $employeeId
    );
    if ($result["success"]) {

    Response::json(
        [
            "success" => true,
            "message" => "Employee deactivated successfully."
        ],
        200
    );
}

Response::json(
    [
        "success" => false,
        "message" => "Employee not found or could not be deactivated."
    ],
    404
);
}