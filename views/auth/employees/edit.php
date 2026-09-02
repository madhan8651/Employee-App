<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../middleware/CsrfMiddleware.php";
require_once __DIR__ . "/../../../controllers/EmployeeController.php";
require_once __DIR__ . "/../../../models/Department.php";
require_once __DIR__ . "/../../../config/database.php";

AuthMiddleware::check();

$csrfToken = CsrfMiddleware::generateToken();

$controller = new EmployeeController();

$departmentModel = new Department($pdo);
$departments = $departmentModel->getActiveDepartments();

$message = "";
$result = null;


// Get employee ID

$employee_id = $_GET["employee_id"] ?? $_POST["employee_id"] ?? "";


// Check employee ID

if (empty($employee_id)) {
    die("Employee ID is required.");
}


// Get current employee details

$employee = $controller->getEmployeeById($employee_id);


// Check employee exists

if (!$employee) {
    die("Employee not found.");
}


// Handle form submission

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validate CSRF token

    if (
        !CsrfMiddleware::validateToken(
            $_POST["csrf_token"] ?? ""
        )
    ) {

        $result = [
            "success" => false,
            "message" => "Invalid CSRF token."
        ];

        $message = $result["message"];

    } else {

        $data = [];

        $editableFields = [
            "first_name",
            "last_name",
            "email",
            "phone",
            "date_of_birth",
            "gender",
            "date_of_joining",
            "department_id",
            "designation",
            "salary",
            "address",
            "status"
        ];


        foreach ($editableFields as $field) {

            if (isset($_POST[$field])) {

                $newValue = trim($_POST[$field]);
                $oldValue = (string) $employee[$field];

                // Add only changed fields

                if ($newValue !== $oldValue) {
                    $data[$field] = $newValue;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Profile Photo
        |--------------------------------------------------------------------------
        |
        | EmployeeController handles the actual upload.
        |
        */

        $photoUploaded =
            isset($_FILES["profile_photo"]) &&
            $_FILES["profile_photo"]["error"] !== UPLOAD_ERR_NO_FILE;


        // Update if something changed

        if (!empty($data) || $photoUploaded) {

            $result = $controller->updateEmployee(
                $employee_id,
                $data
            );

            $message = $result["message"];


            // Reload updated employee data

            if ($result["success"]) {

                $employee = $controller->getEmployeeById(
                    $employee_id
                );

            }

        } else {

            $result = [
                "success" => false,
                "message" => "No changes were made."
            ];

            $message = $result["message"];

        }

    }

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
        Edit Employee - Employee Management System
    </title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

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

        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
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

        .form-header h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .form-header p {
            margin: 0.6rem 0 0;
            color: var(--muted);
            font-size: 0.96rem;
        }

        .form-section {
            margin-top: 2rem;
        }

        .section-title {
            margin-bottom: 1rem;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            width: 100%;
            min-height: 50px;
            padding: 0.8rem 0.95rem;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            background: #fff;
            font-size: 0.96rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(79, 70, 229, 0.85);
            box-shadow:
                0 0 0 0.2rem rgba(79, 70, 229, 0.12);
            outline: none;
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            margin-top: 1rem;
            border: none;
            border-radius: 12px;
            padding: 0.9rem 1rem;
            background: linear-gradient(
                135deg,
                #111827 0%,
                #4f46e5 100%
            );
            color: #fff;
            font-size: 0.98rem;
            font-weight: 700;
            box-shadow:
                0 12px 22px rgba(79, 70, 229, 0.18);
        }

        .btn-submit:hover {
            color: #fff;
        }

        .btn-cancel {
            width: 100%;
            margin-top: 1rem;
            border-radius: 12px;
            padding: 0.9rem 1rem;
            font-size: 0.98rem;
            font-weight: 600;
        }

        @media (max-width: 575.98px) {

            body {
                padding: 20px 12px;
            }

            .employee-card {
                padding: 1.5rem 1.1rem;
            }

            .form-header h3 {
                font-size: 1.7rem;
            }

        }

    </style>

</head>


<body>

<div class="employee-shell">

    <div class="employee-card">

        <div class="brand">

            <div class="brand-mark">
                E
            </div>

            <h1 class="brand-title">
                Employee App
            </h1>

        </div>


        <div class="form-header">

            <span class="eyebrow">
                Employee Management
            </span>

            <h3>
                Edit Employee
            </h3>

            <p>
                Update the employee details below.
            </p>

        </div>


        <?php if (!empty($message)): ?>

            <div
                class="alert <?= $result["success"] ? "alert-success" : "alert-danger" ?>"
            >
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            action=""
            enctype="multipart/form-data"
        >

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($csrfToken) ?>"
            >

            <input
                type="hidden"
                name="employee_id"
                value="<?= htmlspecialchars($employee["employee_id"]) ?>"
            >


            <div class="form-section">

                <div class="section-title">
                    Personal Information
                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="employee_id_display">
                                Employee ID
                            </label>

                            <input
                                type="text"
                                id="employee_id_display"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["employee_id"]) ?>"
                                readonly
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="first_name">
                                First Name
                            </label>

                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["first_name"]) ?>"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="last_name">
                                Last Name
                            </label>

                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["last_name"]) ?>"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="email">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["email"]) ?>"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="phone">
                                Phone
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["phone"]) ?>"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="date_of_birth">
                                Date of Birth
                            </label>

                            <input
                                type="date"
                                id="date_of_birth"
                                name="date_of_birth"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["date_of_birth"]) ?>"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="gender">
                                Gender
                            </label>

                            <select
                                id="gender"
                                name="gender"
                                class="form-select"
                            >

                                <option value="">
                                    Select gender
                                </option>

                                <option
                                    value="Male"
                                    <?= $employee["gender"] === "Male" ? "selected" : "" ?>
                                >
                                    Male
                                </option>

                                <option
                                    value="Female"
                                    <?= $employee["gender"] === "Female" ? "selected" : "" ?>
                                >
                                    Female
                                </option>

                                <option
                                    value="Other"
                                    <?= $employee["gender"] === "Other" ? "selected" : "" ?>
                                >
                                    Other
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            <div class="form-section">

                <div class="section-title">
                    Employment Information
                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="date_of_joining">
                                Date of Joining
                            </label>

                            <input
                                type="date"
                                id="date_of_joining"
                                name="date_of_joining"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["date_of_joining"]) ?>"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="department_id">
                                Department
                            </label>

                            <select
                                id="department_id"
                                name="department_id"
                                class="form-select"
                            >

                                <option value="">
                                    Select department
                                </option>

                                <?php foreach ($departments as $department): ?>

                                    <option
                                        value="<?= htmlspecialchars($department["department_id"]) ?>"
                                        <?= $employee["department_id"] == $department["department_id"] ? "selected" : "" ?>
                                    >
                                        <?= htmlspecialchars($department["department_name"]) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="designation">
                                Designation
                            </label>

                            <input
                                type="text"
                                id="designation"
                                name="designation"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["designation"]) ?>"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="salary">
                                Salary
                            </label>

                            <input
                                type="number"
                                id="salary"
                                name="salary"
                                class="form-control"
                                value="<?= htmlspecialchars($employee["salary"]) ?>"
                                step="0.01"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="status">
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="form-select"
                            >

                                <option
                                    value="active"
                                    <?= strtolower($employee["status"]) === "active" ? "selected" : "" ?>
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    <?= strtolower($employee["status"]) === "inactive" ? "selected" : "" ?>
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            <div class="form-section">

                <div class="section-title">
                    Address
                </div>

                <div class="form-group">

                    <label for="address">
                        Address
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        class="form-control"
                        placeholder="Enter address"
                    ><?= htmlspecialchars($employee["address"]) ?></textarea>

                </div>

            </div>


            <div class="form-section">

                <div class="section-title">
                    Profile Photo
                </div>

                <div class="form-group">

                    <label for="profile_photo">
                        Profile Photo
                    </label>

                    <input
                        type="file"
                        id="profile_photo"
                        name="profile_photo"
                        class="form-control"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <?php if (!empty($employee["profile_photo"])): ?>

                        <small class="text-muted d-block mt-2">
                            Current profile photo:
                            <?= htmlspecialchars($employee["profile_photo"]) ?>
                        </small>

                    <?php endif; ?>

                </div>

            </div>


            <div class="row g-2">

                <div class="col-md-6">

                    <a
                        href="index.php"
                        class="btn btn-light border btn-cancel"
                    >
                        Cancel
                    </a>

                </div>


                <div class="col-md-6">

                    <button
                        type="submit"
                        class="btn btn-submit"
                    >
                        Update Employee
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>