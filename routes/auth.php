<?php

require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../middleware/CsrfMiddleware.php";


$method = $_SERVER["REQUEST_METHOD"];


$path = parse_url(
    $_SERVER["REQUEST_URI"],
    PHP_URL_PATH
);


$basePath = "/Employee_App/routes/auth.php";


$path = str_replace(
    $basePath,
    "",
    $path
);


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

if (
    $path === "/login"
) {

    $message = "";


    /*
    |--------------------------------------------------------------------------
    | LOGIN REQUEST
    |--------------------------------------------------------------------------
    */

    if ($method === "POST") {

        $login =
            $_POST["login"] ?? "";

        $password =
            $_POST["password"] ?? "";


        $auth =
            new AuthController();


        $message =
            $auth->login(
                $login,
                $password
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN VIEW
    |--------------------------------------------------------------------------
    */

    require_once __DIR__ .
    "/../views/auth/login.php";

    exit;
}


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

if (
    $method === "GET" &&
    $path === "/logout"
) {

    if (
        session_status() === PHP_SESSION_NONE
    ) {
        session_start();
    }


    $_SESSION = [];


    if (
        ini_get("session.use_cookies")
    ) {

        $params =
            session_get_cookie_params();


        setcookie(
            session_name(),
            "",
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }


    session_destroy();


    header(
        "Location: /Employee_App/routes/auth.php/login"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CHANGE PASSWORD
|--------------------------------------------------------------------------
|
| Available for:
| - Admin
| - Employee
|
| Both roles use the same page and same processing.
|
*/

if (
    $path === "/change-password"
) {

    $message = "";


    /*
    |--------------------------------------------------------------------------
    | CHANGE PASSWORD REQUEST
    |--------------------------------------------------------------------------
    */

    if ($method === "POST") {

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

            $message =
                "Invalid CSRF token.";

        } else {

            /*
            |--------------------------------------------------------------------------
            | PASSWORD DATA
            |--------------------------------------------------------------------------
            */

            $currentPassword =
                $_POST["current_password"] ?? "";


            $newPassword =
                $_POST["new_password"] ?? "";


            $confirmPassword =
                $_POST["confirm_password"] ?? "";


            /*
            |--------------------------------------------------------------------------
            | AUTH CONTROLLER
            |--------------------------------------------------------------------------
            */

            $auth =
                new AuthController();


            $message =
                $auth->changePassword(
                    $currentPassword,
                    $newPassword,
                    $confirmPassword
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGE PASSWORD VIEW
    |--------------------------------------------------------------------------
    */

    require_once __DIR__ .
        "/../views/auth/change-password.php";

    exit;
}
/*
|--------------------------------------------------------------------------
| EMPLOYEE PROFILE
|--------------------------------------------------------------------------
| Employee-only profile page.
*/

if (
    $method === "GET" &&
    $path === "/employees/profile"
) {

    require_once __DIR__ .
        "/../middleware/AuthMiddleware.php";

    require_once __DIR__ .
        "/../middleware/RoleMiddleware.php";


    AuthMiddleware::check();

    RoleMiddleware::check("Employee");


    require_once __DIR__ .
        "/../views/auth/employees/profile.php";

    exit;
}
/*
|--------------------------------------------------------------------------
| EMPLOYEE DEPARTMENT
|--------------------------------------------------------------------------
| Employee-only department information page.
*/

if (
    $method === "GET" &&
    $path === "/employees/department"
) {

    require_once __DIR__ .
        "/../middleware/AuthMiddleware.php";

    require_once __DIR__ .
        "/../middleware/RoleMiddleware.php";


    AuthMiddleware::check();

    RoleMiddleware::check("Employee");


    require_once __DIR__ .
        "/../views/auth/employees/department.php";

    exit;
}