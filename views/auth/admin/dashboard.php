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
    <link
    rel="stylesheet"
    href="../../../public/css/style.css"
>
</head>


<body>


<div class="dashboard-shell">

    <div class="dashboard-card">


        <!-- Brand -->

        <div class="brand">

            <div class="brand-mark">
                E
            </div>

            <h1 class="brand-title">
                Employee App
            </h1>

            <p class="brand-subtitle">
                Employee Management System
            </p>

        </div>


        <!-- Page Header -->

        <div class="page-header">

            <span class="eyebrow">
                Administration
            </span>

            <h2>
                Admin Dashboard
            </h2>
            <p>
    Welcome, <strong><?= htmlspecialchars($_SESSION["name"]) ?></strong>
</p>
            <p>
                Manage employees, departments and application users.
            </p>

        </div>


        <!-- Dashboard Modules -->

        <div class="row g-4">


            <!-- Employee Management -->

            <div class="col-md-4">

                <a
                    href="../employees/index.php"
                    class="dashboard-link"
                >

                    <div class="module-card">

                        <div class="module-icon">
                            👥
                        </div>

                        <h5>
                            Employee Management
                        </h5>

                        <p>
                            Add, view, edit, search and
                            manage employee records.
                        </p>

                        <div class="module-action">
                            Manage Employees →
                        </div>

                    </div>

                </a>

            </div>


            <!-- Department Management -->

            <div class="col-md-4">

                <a
                    href="../departments/index.php"
                    class="dashboard-link"
                >

                    <div class="module-card">

                        <div class="module-icon">
                            🏢
                        </div>

                        <h5>
                            Department Management
                        </h5>

                        <p>
                            Create and manage departments
                            and department information.
                        </p>

                        <div class="module-action">
                            Manage Departments →
                        </div>

                    </div>

                </a>

            </div>


            <!-- User Management -->

            <div class="col-md-4">

                <a
                    href="../users/index.php"
                    class="dashboard-link"
                >

                    <div class="module-card">

                        <div class="module-icon">
                            👤
                        </div>

                        <h5>
                            User Management
                        </h5>

                        <p>
                            Manage application users,
                            roles and login accounts.
                        </p>

                        <div class="module-action">
                            Manage Users →
                        </div>

                    </div>

                </a>

            </div>


        </div>


        <!-- Logout -->

        <div class="bottom-actions">

    <!-- Account Actions -->

<div class="account-actions">

    <a
        href="../../../public/change-password.php"
        class="account-action account-action-password"
    >
        <span class="account-action-icon">🔑</span>

        <span>
            <strong>Change Password</strong>
            <small>Update your login password</small>
        </span>
    </a>

    <a
        href="../../../public/logout.php"
        class="account-action account-action-logout"
    >
        <span class="account-action-icon">↪</span>

        <span>
            <strong>Logout</strong>
            <small>Sign out of your account</small>
        </span>
    </a>

</div>

</div>


    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>