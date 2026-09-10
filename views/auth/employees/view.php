<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../middleware/RoleMiddleware.php";

AuthMiddleware::check();
RoleMiddleware::check("Admin");


$employee_id = $_GET["employee_id"] ?? "";

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
        View Employee - Employee Management System
    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Google Font -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- Custom CSS -->

    <link
        rel="stylesheet"
        href="../../../public/css/style.css"
    >

</head>


<body>


<div class="employee-view-shell">

    <div class="employee-view-card">


        <!-- Brand -->

        <div class="brand">

            <div class="brand-mark">
                E
            </div>

            <h1 class="brand-title">
                Employee App
            </h1>

        </div>


        <!-- Page Header -->

        <div class="page-header">

            <span class="eyebrow">
                Employee Management
            </span>

            <h3>
                Employee Details
            </h3>

            <p>
                View employee information.
            </p>

        </div>


        <!-- Message -->

        <div id="message"></div>


        <!-- Profile Section -->

        <div class="profile-section">


            <div class="profile-avatar">

                <img
                    id="profilePhoto"
                    src=""
                    alt="Profile Photo"
                    style="display: none;"
                >

                <span id="profileInitial">
                </span>

            </div>


            <div
                class="profile-name"
                id="profileName"
            >
            </div>


            <div
                class="profile-id"
                id="profileId"
            >
            </div>

        </div>


        <!-- Employee Details -->

        <div class="details-card">


            <div class="detail-row">

                <div class="detail-label">
                    Employee ID
                </div>

                <div
                    class="detail-value"
                    id="employee_id"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    First Name
                </div>

                <div
                    class="detail-value"
                    id="first_name"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Last Name
                </div>

                <div
                    class="detail-value"
                    id="last_name"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Email
                </div>

                <div
                    class="detail-value"
                    id="email"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Phone
                </div>

                <div
                    class="detail-value"
                    id="phone"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Date of Birth
                </div>

                <div
                    class="detail-value"
                    id="date_of_birth"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Gender
                </div>

                <div
                    class="detail-value"
                    id="gender"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Date of Joining
                </div>

                <div
                    class="detail-value"
                    id="date_of_joining"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Department
                </div>

                <div
                    class="detail-value"
                    id="department_id"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Designation
                </div>

                <div
                    class="detail-value"
                    id="designation"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Salary
                </div>

                <div
                    class="detail-value"
                    id="salary"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Address
                </div>

                <div
                    class="detail-value"
                    id="address"
                >
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Status
                </div>

                <div class="detail-value">

                    <span
                        id="status"
                        class="status-badge"
                    >
                    </span>

                </div>

            </div>


        </div>


        <!-- Bottom Actions -->

        <div class="bottom-actions">

            <a
                href="index.php"
                class="btn btn-edit"
            >
                ← Back to Employees
            </a>


            <a
                id="editEmployeeLink"
                href="#"
                class="btn btn-edit"
            >
                ✎ Edit Employee
            </a>

        </div>


    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>
<script>
    const employeeId =
    <?= json_encode($employee_id) ?>;
</script>
<script src="../../../public/js/employee/employee-view.js"></script>
</body>

</html>
