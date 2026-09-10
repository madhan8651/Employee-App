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
        View Department - Employee Management System
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

<link
    rel="stylesheet"
    href="/Employee_App/public/css/department/department-view.css"
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
                View Department
            </h3>

            <p>
                View department information.
            </p>

        </div>


        <!-- Message -->

        <div id="message"></div>


        <!-- Department Details -->

        <div
    id="departmentDetails"
    class="department-view-card"
>
    <div class="text-center py-4">
        Loading department...
    </div>
</div>


        <!-- Actions -->

        <div class="form-actions mt-4 d-flex justify-content-center gap-2">

            <a
                href="index.php"
                class="btn btn-add"
            >
               <- Back
            </a>

            <a
                href="edit.php?department_id=<?= $departmentId ?>"
                class="btn btn-add"
            >
                Edit Department
            </a>

        </div>


    </div>

</div>


<script>

const departmentId =
    <?= json_encode($departmentId) ?>;

</script>

<script src="../../../../public/js/department/department-view.js"></script>

</body>

</html>
