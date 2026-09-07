<?php

require_once __DIR__ . "/../utilities/Response.php";
require_once __DIR__ . "/../middleware/CsrfMiddleware.php";
require_once __DIR__ . "/../controllers/DepartmentController.php";
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
|--------------------------------------------------------------------------
| GET ALL / FILTERED EMPLOYEES
|--------------------------------------------------------------------------
*/

if (
    $method === "GET" &&
    $path === "/employees"
) {

    require_once __DIR__ . "/../controllers/EmployeeController.php";

    $controller = new EmployeeController();


    /*
    |--------------------------------------------------------------------------
    | FILTERS
    |--------------------------------------------------------------------------
    */

    $search =
        trim($_GET["search"] ?? "");

    $departmentId =
        $_GET["department_id"] ?? "";

    $status =
        $_GET["status"] ?? "";

    $sort =
        $_GET["sort"] ?? "";


    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    $limit = 5;

    $page =
        isset($_GET["page"])
            ? (int) $_GET["page"]
            : 1;

    if ($page < 1) {
        $page = 1;
    }


    $offset =
        ($page - 1) * $limit;


    /*
    |--------------------------------------------------------------------------
    | COUNT EMPLOYEES
    |--------------------------------------------------------------------------
    */

    $totalEmployees =
        $controller->countFilteredEmployees(
            $search,
            $departmentId,
            $status
        );


    /*
    |--------------------------------------------------------------------------
    | TOTAL PAGES
    |--------------------------------------------------------------------------
    */

    $totalPages =
        (int) ceil(
            $totalEmployees / $limit
        );


    if (
        $totalPages > 0 &&
        $page > $totalPages
    ) {

        $page = $totalPages;

        $offset =
            ($page - 1) * $limit;
    }


    /*
    |--------------------------------------------------------------------------
    | GET EMPLOYEES
    |--------------------------------------------------------------------------
    */

    $employees =
        $controller->getFilteredEmployees(
            $search,
            $departmentId,
            $status,
            $sort,
            $limit,
            $offset
        );


    /*
    |--------------------------------------------------------------------------
    | JSON RESPONSE
    |--------------------------------------------------------------------------
    */

    Response::json(
        [
            "success" => true,

            "data" => $employees,

            "pagination" => [
                "current_page" => $page,
                "per_page" => $limit,
                "total_employees" => $totalEmployees,
                "total_pages" => $totalPages
            ]
        ],
        200
    );
}


/*
|--------------------------------------------------------------------------
| GET SINGLE EMPLOYEE
|--------------------------------------------------------------------------
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

    $employee =
        $controller->getEmployeeById(
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
|--------------------------------------------------------------------------
| CREATE EMPLOYEE
|--------------------------------------------------------------------------
*/

if (
    $method === "POST" &&
    $path === "/employees"
) {

    /*
    |--------------------------------------------------------------------------
    | CSRF VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        !CsrfMiddleware::validateToken(
            $_POST["csrf_token"] ?? ""
        )
    ) {

        Response::json(
            [
                "success" => false,
                "message" => "Invalid CSRF token."
            ],
            403
        );
    }


    require_once __DIR__ . "/../controllers/EmployeeController.php";

    $controller = new EmployeeController();


    $result =
        $controller->createEmployee(
            $_POST["employee_id"] ?? "",
            $_POST["first_name"] ?? "",
            $_POST["last_name"] ?? "",
            $_POST["email"] ?? "",
            $_POST["phone"] ?? "",
            $_POST["date_of_birth"] ?? "",
            $_POST["gender"] ?? "",
            $_POST["date_of_joining"] ?? "",
            $_POST["department_id"] ?? "",
            $_POST["designation"] ?? "",
            $_POST["salary"] ?? "",
            $_POST["address"] ?? "",
            $_FILES["profile_photo"] ?? null,
            $_POST["status"] ?? ""
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
|--------------------------------------------------------------------------
| UPDATE EMPLOYEE
|--------------------------------------------------------------------------
*/

$isUpdateRequest =
    $method === "PUT" ||
    (
        $method === "POST" &&
        isset($_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"]) &&
        strtoupper(
            $_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"]
        ) === "PUT"
    );


if (
    $isUpdateRequest &&
    preg_match(
        "#^/employees/([^/]+)$#",
        $path,
        $matches
    )
) {

    $employeeId = $matches[1];


    /*
    |--------------------------------------------------------------------------
    | CSRF VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        !CsrfMiddleware::validateToken(
            $_POST["csrf_token"] ?? ""
        )
    ) {

        Response::json(
            [
                "success" => false,
                "message" => "Invalid CSRF token."
            ],
            403
        );
    }


    require_once __DIR__ .
        "/../controllers/EmployeeController.php";

    $controller =
        new EmployeeController();


    /*
    |--------------------------------------------------------------------------
    | EMPLOYEE DATA
    |--------------------------------------------------------------------------
    */

    $data = [];

    $editableFields = [
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


    foreach ($editableFields as $field) {

        if (isset($_POST[$field])) {

            $data[$field] =
                trim($_POST[$field]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE EMPLOYEE
    |--------------------------------------------------------------------------
    */

    $result =
        $controller->updateEmployee(
            $employeeId,
            $data
        );


    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

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


/*
|--------------------------------------------------------------------------
| DELETE / DEACTIVATE DEPARTMENT
|--------------------------------------------------------------------------
*/

if (
    $method === "DELETE" &&
    preg_match(
        "#^/departments/([0-9]+)$#",
        $path,
        $matches
    )
) {

    $departmentId = (int) $matches[1];

    $controller =
        new DepartmentController();

    $result =
        $controller->deactivateDepartment(
            $departmentId
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
/*
|--------------------------------------------------------------------------
| CREATE USER
|--------------------------------------------------------------------------
*/

if (
    $method === "POST" &&
    $path === "/users"
) {

    /*
    |--------------------------------------------------------------------------
    | CSRF VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        !CsrfMiddleware::validateToken(
            $_POST["csrf_token"] ?? ""
        )
    ) {

        Response::json(
            [
                "success" => false,
                "message" => "Invalid CSRF token."
            ],
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER CONTROLLER
    |--------------------------------------------------------------------------
    */

    require_once __DIR__ .
        "/../controllers/UserController.php";

    $controller =
        new UserController();


    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */

    $result =
        $controller->createUser(
            $_POST["name"] ?? "",
            $_POST["email"] ?? "",
            $_POST["username"] ?? "",
            $_POST["password"] ?? "",
            $_POST["role"] ?? "",
            $_POST["status"] ?? ""
        );


    /*
    |--------------------------------------------------------------------------
    | JSON RESPONSE
    |--------------------------------------------------------------------------
    */

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
// =========================
// DEPARTMENT API ROUTES
// =========================

// GET /departments
// GET /departments?search=IT
if ($method === "GET" && $path === "/departments") {

    $controller = new DepartmentController();

    $search = trim($_GET["search"] ?? "");

    if ($search !== "") {
        $departments = $controller->searchDepartments($search);
    } else {
        $departments = $controller->getAllDepartments();
    }

    Response::json([
        "success" => true,
        "data" => $departments
    ]);
}


// GET /departments/{id}
if ($method === "GET" && preg_match("#^/departments/([0-9]+)$#", $path, $matches)) {

    $departmentId = (int) $matches[1];

    $controller = new DepartmentController();

    $department = $controller->getDepartmentById($departmentId);

    if (!$department) {
        Response::json([
            "success" => false,
            "message" => "Department not found."
        ], 404);
    }

    Response::json([
        "success" => true,
        "data" => $department
    ]);
}


// POST /departments
if ($method === "POST" && $path === "/departments") {

    if (!CsrfMiddleware::validateToken($_POST["csrf_token"] ?? "")) {
        Response::json([
            "success" => false,
            "message" => "Invalid CSRF token."
        ], 403);
    }

    $controller = new DepartmentController($pdo);

    $result = $controller->createDepartment(
        $_POST["department_name"] ?? "",
        $_POST["description"] ?? "",
        $_POST["status"] ?? "Active"
    );

    if ($result["success"]) {
        Response::json($result, 201);
    }

    Response::json($result, 400);
}


// PUT /departments/{id}
// Also supports POST + X-HTTP-Method-Override: PUT
if (
    ($method === "PUT" || $method === "POST")
    && preg_match("#^/departments/([0-9]+)$#", $path, $matches)
) {

    if ($method === "POST" && ($_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"] ?? "") !== "PUT") {
        // Continue only when this is a real PUT request
        if ($method !== "PUT") {
            // This will only be reached for a normal POST
        }
    }

    $isPutRequest =
        $method === "PUT"
        || (
            $method === "POST"
            && strtoupper($_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"] ?? "") === "PUT"
        );

    if (!$isPutRequest) {
        Response::json([
            "success" => false,
            "message" => "Invalid request method."
        ], 405);
    }

    if (!CsrfMiddleware::validateToken($_POST["csrf_token"] ?? "")) {
        Response::json([
            "success" => false,
            "message" => "Invalid CSRF token."
        ], 403);
    }

    $departmentId = (int) $matches[1];

    $controller = new DepartmentController($pdo);

    $result = $controller->updateDepartment(
        $departmentId,
        $_POST["department_name"] ?? "",
        $_POST["description"] ?? "",
        $_POST["status"] ?? "Active"
    );

    if ($result["success"]) {
        Response::json($result);
    }

    Response::json($result, 400);
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

    require_once __DIR__ .
        "/../controllers/EmployeeController.php";

    $controller =
        new EmployeeController();

    $result =
        $controller->deactivateEmployee(
            $employeeId
        );

    if ($result["success"]) {

        Response::json(
            $result,
            200
        );
    }

    Response::json(
        $result,
        404
    );
}