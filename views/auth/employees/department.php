<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

AuthMiddleware::check();
RoleMiddleware::check("Employee");


/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/

$csrfToken =
    CsrfMiddleware::generateToken();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        My Department - Employee Management System
    </title>


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =====================================================
         GOOGLE FONT
    ====================================================== -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         MAIN CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="../../../public/css/style.css"
    >


    <!-- =====================================================
         DEPARTMENT CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="../../../public/css/employee/employee-department.css"
    >

</head>


<body>


<div class="employee-department-shell">

    <div class="employee-department-card">


        <!-- =================================================
             TOP HEADER
        ================================================== -->

        <div class="employee-department-top">


            <!-- =============================================
                 BRAND
            ============================================== -->

            <div class="employee-department-brand">

                <div class="department-brand-logo">
                    E
                </div>


                <div class="department-brand-text">

                    <h2>
                        Employee App
                    </h2>

                    <p>
                        Employee Management System
                    </p>

                </div>

            </div>


            <!-- =============================================
                 BACK BUTTON
            ============================================== -->

            <button
                type="button"
                id="backToProfileButton"
                class="department-back-button"
            >

                <span>
                    ←
                </span>

                Back to Profile

            </button>

        </div>


        <!-- =================================================
             PAGE HEADER
        ================================================== -->

        <div class="employee-department-header">

            <span class="department-eyebrow">
                Employee Portal
            </span>


            <h1>
                Your Department
            </h1>


            <p>
                View your department information and team details.
            </p>

        </div>


        <!-- =================================================
             MESSAGE
        ================================================== -->

        <div id="departmentMessage"></div>


        <!-- =================================================
             CSRF TOKEN
        ================================================== -->

        <input
            type="hidden"
            id="csrf_token"
            name="csrf_token"
            value="<?= htmlspecialchars($csrfToken) ?>"
        >


        <!-- =================================================
             DEPARTMENT CONTENT
        ================================================== -->

        <div id="departmentContainer">

        </div>


    </div>

</div>


<!-- =========================================================
     BOOTSTRAP JS
========================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
></script>


<!-- =========================================================
     EMPLOYEE DEPARTMENT JS
========================================================== -->

<script
    src="../../../public/js/employee/employee-department.js"
></script>


</body>

</html>