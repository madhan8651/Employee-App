<?php

require_once __DIR__ . "/../../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../../middleware/RoleMiddleware.php";

AuthMiddleware::check();
RoleMiddleware::check("Admin");

$departmentId = (int) ($_GET["department_id"] ?? 0);

if ($departmentId <= 0) {
    header("Location: index.php");
    exit;
}

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
        Deactivate Department - Employee Management System
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="/Employee_App/public/css/style.css"
    >

</head>


<body>

<div class="employee-shell">

    <div class="employee-card">


        <!-- Brand -->

        <div class="brand">

            <div class="brand-mark">
                E
            </div>

            <h1 class="brand-title">
                Employee App
            </h1>

        </div>


        <!-- Header -->

        <div class="page-header">

            <span class="eyebrow">
                Department Management
            </span>

            <h3>
                Deactivate Department
            </h3>

            <p>
                Deactivate the selected department.
            </p>

        </div>


        <!-- Message -->

        <div id="message"></div>


        <!-- Confirmation -->

        <div class="text-center mt-4">

            <p class="mb-4">
                Are you sure you want to deactivate this department?
            </p>

            <button
                type="button"
                id="deactivateButton"
                class="btn btn-add"
            >
                Deactivate Department
            </button>

            <a
                href="index.php"
                class="btn btn-light border ms-2"
            >
                Cancel
            </a>

        </div>


    </div>

</div>


<script src="/Employee_App/public/js/department/department-deactivate.js"></script>

</body>

</html>
