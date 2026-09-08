<?php

require_once __DIR__ . "/../utilities/Response.php";
require_once __DIR__ . "/../middleware/CsrfMiddleware.php";

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
| EMPLOYEE API ROUTES
|--------------------------------------------------------------------------
*/


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

    $controller =
        new EmployeeController();


    $search =
        trim($_GET["search"] ?? "");

    $departmentId =
        $_GET["department_id"] ?? "";

    $status =
        $_GET["status"] ?? "";

    $sort =
        $_GET["sort"] ?? "";


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


    $totalEmployees =
        $controller->countFilteredEmployees(
            $search,
            $departmentId,
            $status
        );


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


    $employees =
        $controller->getFilteredEmployees(
            $search,
            $departmentId,
            $status,
            $sort,
            $limit,
            $offset
        );


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

    require_once __DIR__ .
        "/../controllers/EmployeeController.php";

    $controller =
        new EmployeeController();

    $employeeId =
        $matches[1];

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

    $employeeId =
        $matches[1];


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


    $result =
        $controller->updateEmployee(
            $employeeId,
            $data
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
| DELETE / DEACTIVATE EMPLOYEE
|--------------------------------------------------------------------------
*/

if (
    $method === "DELETE" &&
    preg_match(
        "#^/employees/([^/]+)$#",
        $path,
        $matches
    )
) {

    $employeeId =
        $matches[1];


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


/*
|--------------------------------------------------------------------------
| USER API ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| CREATE USER
|--------------------------------------------------------------------------
*/

if (
    $method === "POST" &&
    $path === "/users"
) {

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
        "/../controllers/UserController.php";

    $controller =
        new UserController();


    $result =
        $controller->createUser(
            $_POST["name"] ?? "",
            $_POST["email"] ?? "",
            $_POST["username"] ?? "",
            $_POST["password"] ?? "",
            $_POST["role"] ?? "",
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
| DEPARTMENT API ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| GET ALL / SEARCH DEPARTMENTS
|--------------------------------------------------------------------------
*/

if (
    $method === "GET" &&
    $path === "/departments"
) {

    require_once __DIR__ .
        "/../controllers/DepartmentController.php";

    $controller =
        new DepartmentController();


    $search =
        trim($_GET["search"] ?? "");


    if ($search !== "") {

        $departments =
            $controller->searchDepartments(
                $search
            );

    } else {

        $departments =
            $controller->getAllDepartments();
    }


    Response::json(
        [
            "success" => true,
            "data" => $departments
        ],
        200
    );
}


/*
|--------------------------------------------------------------------------
| GET SINGLE DEPARTMENT
|--------------------------------------------------------------------------
*/

if (
    $method === "GET" &&
    preg_match(
        "#^/departments/([0-9]+)$#",
        $path,
        $matches
    )
) {

    require_once __DIR__ .
        "/../controllers/DepartmentController.php";

    $controller =
        new DepartmentController();


    $departmentId =
        (int) $matches[1];


    $department =
        $controller->getDepartmentById(
            $departmentId
        );


    if (!$department) {

        Response::json(
            [
                "success" => false,
                "message" => "Department not found."
            ],
            404
        );
    }


    Response::json(
        [
            "success" => true,
            "data" => $department
        ],
        200
    );
}


/*
|--------------------------------------------------------------------------
| CREATE DEPARTMENT
|--------------------------------------------------------------------------
*/

if (
    $method === "POST" &&
    $path === "/departments"
) {

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
        "/../controllers/DepartmentController.php";

    $controller =
        new DepartmentController();


    $result =
        $controller->createDepartment(
            $_POST["department_name"] ?? "",
            $_POST["description"] ?? "",
            $_POST["status"] ?? "Active"
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
| UPDATE DEPARTMENT
|--------------------------------------------------------------------------
*/

$isDepartmentUpdateRequest =
    $method === "PUT" ||
    (
        $method === "POST" &&
        isset(
            $_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"]
        ) &&
        strtoupper(
            $_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"]
        ) === "PUT"
    );


if (
    $isDepartmentUpdateRequest &&
    preg_match(
        "#^/departments/([0-9]+)$#",
        $path,
        $matches
    )
) {

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
        "/../controllers/DepartmentController.php";

    $controller =
        new DepartmentController();


    $departmentId =
        (int) $matches[1];


    $result =
        $controller->updateDepartment(
            $departmentId,
            $_POST["department_name"] ?? "",
            $_POST["description"] ?? "",
            $_POST["status"] ?? "Active"
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

    require_once __DIR__ .
        "/../controllers/DepartmentController.php";

    $controller =
        new DepartmentController();


    $departmentId =
        (int) $matches[1];


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
| DASHBOARD API ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| GET DASHBOARD SUMMARY
|--------------------------------------------------------------------------
*/

if (
    $method === "GET" &&
    $path === "/dashboard/summary"
) {

    require_once __DIR__ .
        "/../controllers/DashboardController.php";

    $controller =
        new DashboardController();


    $summary =
        $controller->getSummary();


    Response::json(
        [
            "success" => true,
            "data" => $summary
        ],
        200
    );
}


/*
|--------------------------------------------------------------------------
| GET EMPLOYEES BY DEPARTMENT
|--------------------------------------------------------------------------
*/

if (
    $method === "GET" &&
    $path === "/dashboard/employees-by-department"
) {

    require_once __DIR__ .
        "/../controllers/DashboardController.php";

    $controller =
        new DashboardController();


    $departments =
        $controller->getEmployeesByDepartment();


    Response::json(
        [
            "success" => true,
            "data" => $departments
        ],
        200
    );
}


/*
|--------------------------------------------------------------------------
| FINAL 404 FALLBACK
|--------------------------------------------------------------------------
*/

Response::json(
    [
        "success" => false,
        "message" => "API endpoint not found."
    ],
    404
);