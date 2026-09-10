<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../middleware/RoleMiddleware.php";

AuthMiddleware::check();
RoleMiddleware::check("Admin");

$employeeId = $_GET["employee_id"] ?? "";

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
        Deactivate Employee - Employee Management System
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


    <!-- Main CSS -->

    <link
        rel="stylesheet"
        href="../../../public/css/style.css"
    >


    <link
        rel="stylesheet"
        href="../../../public/css/employee/employee-deactivate.css"
    >

</head>


<body>

<div class="deactivate-page">

    <div class="deactivate-card">


        <!-- Brand -->

        <div class="deactivate-brand">

            <div class="deactivate-brand-mark">
                E
            </div>

            <h2 class="deactivate-brand-title">
                Employee App
            </h2>

        </div>


        <!-- Warning Icon -->

        <div class="warning-icon">
            !
        </div>


        <!-- Header -->

        <div class="deactivate-header">

            <span class="deactivate-eyebrow">
                Employee Management
            </span>

            <h1>
                Deactivate Employee
            </h1>

            <p>
                Please review the employee before confirming this action.
            </p>

        </div>


        <!-- Message -->

        <div id="message"></div>


        <!-- Employee Information -->

        <div class="employee-info-box">

            <div class="employee-info-icon">
                👤
            </div>

            <div>

                <div class="employee-info-label">
                    Employee ID
                </div>

                <div class="employee-info-id">
                    <?= htmlspecialchars($employeeId) ?>
                </div>

                <div class="employee-info-text">
                    This employee will be marked as inactive.
                </div>

            </div>

        </div>


        <!-- Warning -->

        <div class="warning-box">

            <div class="warning-box-title">
                ⚠ Confirmation required
            </div>

            <p>
                Deactivating this employee will change their status
                to inactive while keeping their existing records
                in the system.
            </p>

        </div>


        <!-- Actions -->

        <div class="deactivate-actions">

            <!-- Hidden Employee ID -->

            <input
                type="hidden"
                id="employeeId"
                value="<?= htmlspecialchars($employeeId) ?>"
            >


            <!-- Cancel -->

            <a
                href="index.php"
                class="btn btn-cancel-deactivate d-flex align-items-center justify-content-center"
            >
                ←&nbsp; Cancel
            </a>


            <!-- Deactivate -->

            <button
                type="button"
                id="deactivateButton"
                class="btn btn-deactivate"
            >
                Deactivate Employee
            </button>

        </div>


        <!-- Confirmation Note -->

        <div class="confirmation-note">

            <span>
                🔒
            </span>

            <span>
                This action requires confirmation
            </span>

        </div>


    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


<!-- Deactivate JS -->

<script src="../../../public/js/employee/deactivate.js"></script>

</body>

</html>
