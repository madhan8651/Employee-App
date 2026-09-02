<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../controllers/EmployeeController.php";

AuthMiddleware::check();

$controller = new EmployeeController();

$employee_id = $_GET["employee_id"] ?? "";

if ($employee_id === "") {
    die("Employee ID is required.");
}

$employee = $controller->getEmployeeById($employee_id);

if (!$employee) {
    die("Employee not found.");
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

    <style>

        :root {
            --bg: #f5f7fb;
            --panel: #ffffff;
            --panel-border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --accent: #4f46e5;
            --shadow: 0 18px 40px rgba(17, 24, 39, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 40px 24px;
            background: var(--bg);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: var(--text);
        }

        .employee-shell {
            width: min(100%, 900px);
            margin: 0 auto;
        }

        .employee-card {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 2rem;
        }

        .brand {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .brand-mark {
            width: 58px;
            height: 58px;
            margin: 0 auto 1rem;
            border-radius: 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: linear-gradient(
                135deg,
                #111827 0%,
                #4f46e5 100%
            );

            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .brand-title {
            font-size: 1.8rem;
            margin: 0;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .eyebrow {
            display: inline-block;
            margin-bottom: 0.7rem;
            padding: 0.42rem 0.8rem;
            border-radius: 999px;

            background: rgba(79, 70, 229, 0.08);

            color: var(--accent);

            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .page-header h3 {
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

        .profile-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            margin: 0 auto 1rem;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(79, 70, 229, 0.08);

            color: var(--accent);

            font-size: 1.8rem;
            font-weight: 800;

            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-name {
            font-size: 1.4rem;
            font-weight: 800;
        }

        .profile-id {
            margin-top: 4px;
            color: var(--muted);
            font-size: 0.85rem;
        }

        .details-card {
            border: 1px solid var(--panel-border);
            border-radius: 14px;
            overflow: hidden;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;

            padding: 15px 18px;

            border-bottom: 1px solid #f0f1f3;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--muted);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .detail-value {
            text-align: right;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .bottom-actions {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 1.5rem;
        }

        .btn-back,
        .btn-edit {
            border-radius: 12px;
            padding: 0.75rem 1.1rem;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .btn-edit {
            border: none;

            background: linear-gradient(
                135deg,
                #111827 0%,
                #4f46e5 100%
            );

            color: #fff;
        }

        .btn-edit:hover {
            color: #fff;
        }

        @media (max-width: 576px) {

            body {
                padding: 20px 12px;
            }

            .employee-card {
                padding: 1.2rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }

            .detail-value {
                text-align: left;
            }

            .bottom-actions {
                flex-direction: column;
            }

            .bottom-actions a {
                width: 100%;
            }

        }

    </style>

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


        <!-- Profile Section -->

        <div class="profile-section">

            <div class="profile-avatar">

                <?php
                $profilePhotoPath =
                    __DIR__
                    . "/../../../public/uploads/employees/"
                    . ($employee["profile_photo"] ?? "");
                ?>

                <?php if (
                    !empty($employee["profile_photo"]) &&
                    file_exists($profilePhotoPath)
                ): ?>

                    <img
                        src="../../../public/uploads/employees/<?= htmlspecialchars($employee["profile_photo"]) ?>"
                        alt="Profile Photo"
                    >

                <?php else: ?>

                    <?= strtoupper(
                        substr(
                            $employee["first_name"],
                            0,
                            1
                        )
                    ) ?>

                <?php endif; ?>

            </div>


            <div class="profile-name">

                <?= htmlspecialchars(
                    $employee["first_name"]
                    . " "
                    . $employee["last_name"]
                ) ?>

            </div>


            <div class="profile-id">

                <?= htmlspecialchars(
                    $employee["employee_id"]
                ) ?>

            </div>

        </div>


        <!-- Employee Details -->

        <div class="details-card">


            <div class="detail-row">

                <div class="detail-label">
                    Employee ID
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["employee_id"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    First Name
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["first_name"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Last Name
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["last_name"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Email
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["email"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Phone
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["phone"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Date of Birth
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["date_of_birth"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Gender
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["gender"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Date of Joining
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["date_of_joining"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Department
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["department_id"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Designation
                </div>

                <div class="detail-value">
                    <?= htmlspecialchars(
                        $employee["designation"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Salary
                </div>

                <div class="detail-value">
                    ₹<?= htmlspecialchars(
                        $employee["salary"]
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Address
                </div>

                <div class="detail-value">
                    <?= nl2br(
                        htmlspecialchars(
                            $employee["address"]
                        )
                    ) ?>
                </div>

            </div>


            <div class="detail-row">

                <div class="detail-label">
                    Status
                </div>

                <div class="detail-value">

                    <?php if (
                        strtolower(
                            $employee["status"]
                        ) === "active"
                    ): ?>

                        <span
                            class="badge bg-success-subtle text-success status-badge"
                        >
                            Active
                        </span>

                    <?php else: ?>

                        <span
                            class="badge bg-secondary-subtle text-secondary status-badge"
                        >
                            Inactive
                        </span>

                    <?php endif; ?>

                </div>

            </div>


        </div>


        <!-- Bottom Actions -->

        <div class="bottom-actions">

            <a
                href="index.php"
                class="btn btn-light border btn-back"
            >
                ← Back to Employees
            </a>


            <a
                href="edit.php?employee_id=<?= urlencode($employee["employee_id"]) ?>"
                class="btn btn-edit"
            >
                ✎ Edit Employee
            </a>

        </div>


    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>