<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../middleware/RoleMiddleware.php";

AuthMiddleware::check();
RoleMiddleware::check("Admin");

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
        Admin Dashboard - Employee App
    </title>


    <!-- Bootstrap 5 -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Google Font -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- Existing Dashboard CSS -->

    <link
        rel="stylesheet"
        href="/Employee_App/public/css/admin/dashboard.css?v=2"
    >


    <!-- Shared CSS -->

    <link
        rel="stylesheet"
        href="/Employee_App/public/css/style.css"
    >


    <!-- New Dashboard Data CSS -->

    <link
        rel="stylesheet"
        href="/Employee_App/public/css/admin/dashboard-data.css?v=2"
    >

</head>


<body>


<div class="dashboard-shell">

    <div class="dashboard-card">


        <!-- =========================================
             Top Navigation
             ========================================= -->

        <div class="top-navigation">


            <!-- Brand -->

            <div class="top-brand">

                <div class="brand-column">

                    <div class="brand-mark">
                        E
                    </div>

                </div>


                <div class="brand-info">

                    <h1>
                        Employee App
                    </h1>

                    <span>
                        Employee Management System
                    </span>

                </div>

            </div>


            <!-- Management Navigation -->

            <div class="top-actions">

    <a
        href="../employees/index.php"
        class="top-nav-button"
    >
        👥 Employee Management
    </a>


    <div class="department-nav-group">

        <a
            href="departments/index.php"
            class="top-nav-button"
        >
            🏢 Department Management
        </a>

    </div>

</div>

        </div>


        <!-- =========================================
             Dashboard Header
             ========================================= -->

        <!-- Dashboard Header -->

<div class="page-header">

    <div class="header-content">

        <span class="eyebrow">
            Administration
        </span>

        <h2>
            Admin Dashboard
        </h2>

        <p>
            Welcome,
            <strong>
                <?= htmlspecialchars($_SESSION["name"]) ?>
            </strong>
        </p>

        <p>
            View system summary and manage employee information.
        </p>

    </div>
    


    <!-- Add User -->

    <a
        href="add.php"
        class="btn btn-add add-user-button"
    >
        + Add User
    </a>

</div>


        <!-- System Overview -->

<div class="summary-section">

    <div class="section-heading">

        <h3>
            System Overview
        </h3>

    </div>


    <div class="overview-card">


        <!-- Total Employees -->

        <div class="overview-stat">

            <span class="overview-label">
                Total Employees
            </span>

            <strong
                id="totalEmployees"
                class="overview-number"
            >
                0
            </strong>

        </div>


        <!-- Active Employees -->

        <div class="overview-stat">

            <span class="overview-label">
                Active Employees
            </span>

            <strong
                id="activeEmployees"
                class="overview-number"
            >
                0
            </strong>

        </div>


        <!-- Inactive Employees -->

        <div class="overview-stat">

            <span class="overview-label">
                Inactive Employees
            </span>

            <strong
                id="inactiveEmployees"
                class="overview-number"
            >
                0
            </strong>

        </div>


        <!-- Total Departments -->

        <div class="overview-stat">

            <span class="overview-label">
                Total Departments
            </span>

            <strong
                id="totalDepartments"
                class="overview-number"
            >
                0
            </strong>

        </div>


    </div>

</div>

        <!-- =========================================
             Employees By Department
             ========================================= -->

        <div class="department-summary-section">


            <div class="section-heading">

                <h3>
                    Employees by Department
                </h3>

                <p>
                    Number of employees assigned to each department.
                </p>

            </div>


            <div
                id="departmentSummaryBody"
                class="department-summary-list"
            >

                <div class="loading-message">
                    Loading department data...
                </div>

            </div>


        </div>


        <!-- =========================================
             Account Actions
             ========================================= -->

        <div class="account-actions">


            <!-- Change Password -->

            <a
                href="/Employee_App/routes/auth.php/change-password"
                class="account-action"
            >

                <div class="account-action-icon">
                    🔑
                </div>


                <div>

                    <strong>
                        Change Password
                    </strong>

                    <small>
                        Update your account password
                    </small>

                </div>

            </a>


            <!-- Logout -->

            <a
                href="/Employee_App/routes/auth.php/logout"
                class="account-action account-action-logout"
            >

                <div class="account-action-icon">
                    ↪
                </div>


                <div>

                    <strong>
                        Logout
                    </strong>

                    <small>
                        Sign out of your account
                    </small>

                </div>

            </a>


        </div>


    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


<!-- Dashboard JS -->

<script
    src="/Employee_App/public/js/admin/dashboard.js?v=2">
</script>


</body>

</html>
