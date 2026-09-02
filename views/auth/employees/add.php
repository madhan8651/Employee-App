<?php

require_once __DIR__ . "/../../../middleware/CsrfMiddleware.php";
require_once __DIR__ . "/../../../controllers/EmployeeController.php";
require_once __DIR__ . "/../../../models/Department.php";
require_once __DIR__ . "/../../../config/database.php";

$csrfToken = CsrfMiddleware::generateToken();

$departmentModel = new Department($pdo);
$departments = $departmentModel->getActiveDepartments();

$message = "";
$result = null;

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

        $controller = new EmployeeController();

        $result = $controller->createEmployee(
            $_POST["employee_id"] ?? "",
            $_POST["first_name"] ?? "",
            $_POST["last_name"] ?? "",
            $_POST["email"] ?? "",
            $_POST["phone"] ?? "",
            $_POST["date_of_birth"] ?? "",
            $_POST["gender"] ?? "",
            $_POST["date_of_joining"] ?? "",
            $_POST["department_id"] ?? "",
            $_POST["designation"] ?? "",
            $_POST["salary"] ?? "",
            $_POST["address"] ?? "",
            $_FILES["profile_photo"] ?? null,
            $_POST["status"] ?? ""
        );

        $message = $result["message"];
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
        Add Employee - Employee Management System
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


        <!-- Brand -->

        <div class="brand">

            <div class="brand-mark">
                E
            </div>

            <h1 class="brand-title">
                Employee App
            </h1>

        </div>


        <!-- Form Header -->

        <div class="form-header">

            <span class="eyebrow">
                Employee Management
            </span>

            <h3>
                Add Employee
            </h3>

            <p>
                Enter the employee details below.
            </p>

        </div>


        <!-- Success / Error Message -->

        <?php if ($message !== ""): ?>

            <?php if ($result["success"]): ?>

                <div class="alert alert-success">
                    <?= htmlspecialchars($message) ?>
                </div>

            <?php else: ?>

                <div class="alert alert-danger">
                    <?= htmlspecialchars($message) ?>
                </div>

            <?php endif; ?>

        <?php endif; ?>


        <!-- Form -->

        <form
            method="POST"
            action=""
            enctype="multipart/form-data"
        >

            <!-- CSRF Token -->

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($csrfToken) ?>"
            >


            <!-- Personal Information -->

            <div class="form-section">

                <div class="section-title">
                    Personal Information
                </div>

                <div class="row">


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="employee_id">
                                Employee ID
                            </label>

                            <input
                                type="text"
                                id="employee_id"
                                name="employee_id"
                                class="form-control"
                                placeholder="Enter employee ID"
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
                                placeholder="Enter first name"
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
                                placeholder="Enter last name"
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
                                placeholder="Enter email"
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
                                placeholder="Enter phone number"
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

                                <option value="Male">
                                    Male
                                </option>

                                <option value="Female">
                                    Female
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>

                    </div>


                </div>

            </div>


            <!-- Employment Information -->

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
                                placeholder="Enter designation"
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
                                placeholder="Enter salary"
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

                                <option value="">
                                    Select status
                                </option>

                                <option value="active">
                                    Active
                                </option>

                                <option value="inactive">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>


                </div>

            </div>


            <!-- Address -->

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
                    ></textarea>

                </div>

            </div>


            <!-- Profile Photo -->

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
                        accept="image/*"
                    >

                </div>

            </div>


            <!-- Submit -->

            <button
                type="submit"
                class="btn btn-submit"
            >
                Create Employee
            </button>


        </form>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>