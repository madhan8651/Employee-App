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


    <style>

        :root {

            --bg: #f5f7fb;

            --panel: #ffffff;

            --panel-border: #e5e7eb;

            --text: #111827;

            --muted: #6b7280;

            --accent: #4f46e5;

            --shadow:
                0 18px 40px
                rgba(17, 24, 39, 0.08);

        }


        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            min-height: 100vh;

            padding: 40px 24px;

            background: var(--bg);

            font-family:
                'Inter',
                'Segoe UI',
                sans-serif;

            color: var(--text);

        }


        .dashboard-shell {

            width: min(100%, 1100px);

            margin: 0 auto;

        }


        .dashboard-card {

            background: var(--panel);

            border: 1px solid var(--panel-border);

            border-radius: 18px;

            box-shadow: var(--shadow);

            padding: 2.5rem;

        }


        /* =========================
           BRAND
        ========================= */

        .brand {

            text-align: center;

            margin-bottom: 2.5rem;

        }


        .brand-mark {

            width: 64px;

            height: 64px;

            margin: 0 auto 1rem;

            border-radius: 16px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #111827 0%,
                    #4f46e5 100%
                );

            color: #fff;

            font-size: 1.6rem;

            font-weight: 800;

        }


        .brand-title {

            margin: 0;

            font-size: 1.8rem;

            font-weight: 800;

            letter-spacing: -0.04em;

        }


        .brand-subtitle {

            margin: 0.4rem 0 0;

            color: var(--muted);

            font-size: 0.9rem;

        }


        /* =========================
           PAGE HEADER
        ========================= */

        .page-header {

            text-align: center;

            margin-bottom: 2.5rem;

        }


        .eyebrow {

            display: inline-block;

            margin-bottom: 0.7rem;

            padding: 0.42rem 0.8rem;

            border-radius: 999px;

            background:
                rgba(79, 70, 229, 0.08);

            color: var(--accent);

            font-size: 0.72rem;

            font-weight: 700;

            letter-spacing: 0.08em;

            text-transform: uppercase;

        }


        .page-header h2 {

            margin: 0;

            font-size: 2rem;

            font-weight: 800;

            letter-spacing: -0.04em;

        }


        .page-header p {

            margin: 0.6rem 0 0;

            color: var(--muted);

            font-size: 0.96rem;

        }


        /* =========================
           MODULE CARDS
        ========================= */

        .dashboard-link {

            display: block;

            height: 100%;

            text-decoration: none;

            color: inherit;

        }


        .module-card {

            height: 100%;

            padding: 1.6rem;

            background: #ffffff;

            border: 1px solid var(--panel-border);

            border-radius: 14px;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                border-color 0.2s ease;

        }


        .module-card:hover {

            transform: translateY(-5px);

            border-color:
                rgba(79, 70, 229, 0.25);

            box-shadow:
                0 12px 28px
                rgba(17, 24, 39, 0.10);

        }


        .module-icon {

            width: 52px;

            height: 52px;

            margin-bottom: 1.3rem;

            border-radius: 14px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                rgba(79, 70, 229, 0.08);

            color: var(--accent);

            font-size: 1.35rem;

        }


        .module-card h5 {

            margin-bottom: 0.55rem;

            font-size: 1rem;

            font-weight: 700;

        }


        .module-card p {

            margin-bottom: 1.3rem;

            color: var(--muted);

            font-size: 0.85rem;

            line-height: 1.6;

        }


        .module-action {

            color: var(--accent);

            font-size: 0.82rem;

            font-weight: 700;

        }


        /* =========================
           LOGOUT
        ========================= */

        .bottom-actions {

            display: flex;

            justify-content: flex-end;

            margin-top: 2rem;

        }


        .btn-logout {

            padding: 0.7rem 1.2rem;

            border-radius: 12px;

            font-size: 0.85rem;

            font-weight: 700;

        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 576px) {

            body {

                padding: 20px 12px;

            }


            .dashboard-card {

                padding: 1.2rem;

            }


            .brand {

                margin-bottom: 2rem;

            }


            .page-header h2 {

                font-size: 1.6rem;

            }


            .bottom-actions {

                justify-content: stretch;

            }


            .btn-logout {

                width: 100%;

            }

        }

    </style>

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

            <a
                href="../../../public/logout.php"
                class="btn btn-outline-danger btn-logout"
            >
                Logout
            </a>

        </div>


    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>