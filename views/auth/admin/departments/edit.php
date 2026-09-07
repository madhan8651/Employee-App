<?php

require_once __DIR__ . "/../../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../../middleware/CsrfMiddleware.php";

AuthMiddleware::check();

$departmentId = (int) ($_GET["department_id"] ?? 0);

if ($departmentId <= 0) {
    header("Location: index.php");
    exit;
}

$csrfToken = CsrfMiddleware::generateToken();

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
        Edit Department - Employee Management System
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
        href="../../../../public/css/style.css"
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


        <!-- Page Header -->

        <div class="page-header">

            <span class="eyebrow">
                Department Management
            </span>

            <h3>
                Edit Department
            </h3>

            <p>
                Update department information.
            </p>

        </div>


        <!-- Form -->

        <form id="departmentForm">


            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($csrfToken) ?>"
            >


            <div class="row g-3">


                <!-- Department Name -->

                <div class="col-md-12">

                    <label
                        for="department_name"
                        class="form-label"
                    >
                        Department Name
                    </label>

                    <input
                        type="text"
                        id="department_name"
                        name="department_name"
                        class="form-control"
                        maxlength="100"
                        required
                    >

                </div>


                <!-- Description -->

                <div class="col-md-12">

                    <label
                        for="description"
                        class="form-label"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                    ></textarea>

                </div>


                <!-- Status -->

                <div class="col-md-6">

                    <label
                        for="status"
                        class="form-label"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select"
                    >

                        <option value="Active">
                            Active
                        </option>

                        <option value="Inactive">
                            Inactive
                        </option>

                    </select>

                </div>

            </div>


            <!-- Message -->

            <div
                id="message"
                class="mt-3"
            ></div>


            <!-- Buttons -->

            <div class="form-actions mt-4">

                <a
                    href="index.php"
                    class="btn btn-light border"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-add"
                    id="updateButton"
                >
                    Update Department
                </button>

            </div>


        </form>

    </div>

</div>


<script>

const departmentId =
    <?= json_encode($departmentId) ?>;

const csrfToken =
    <?= json_encode($csrfToken) ?>;

</script>


<script src="/Employee_App/public/js/department-edit.js?v=2"></script>


</body>

</html>