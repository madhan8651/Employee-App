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
    <link rel="stylesheet" href="../../../public/css/style.css">

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