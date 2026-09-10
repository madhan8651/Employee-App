<?php

require_once __DIR__ . "/../../../middleware/CsrfMiddleware.php";
require_once __DIR__ . "/../../../models/Department.php";
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../middleware/RoleMiddleware.php";

AuthMiddleware::check();
RoleMiddleware::check("Admin");


$csrfToken = CsrfMiddleware::generateToken();

$departmentModel = new Department($pdo);
$departments = $departmentModel->getActiveDepartments();

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
        Edit Employee - Employee Management System
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


<div class="employee-shell form-page">

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
                Edit Employee
            </h3>

            <p>
                Update the employee details below.
            </p>

        </div>


        <!-- Form -->

        <form
            id="editEmployeeForm"
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


            <!-- Employee ID -->

            <input
                type="hidden"
                name="employee_id"
                id="employee_id"
                value="<?= htmlspecialchars($employee_id) ?>"
            >


            <!-- Message -->

            <div id="message"></div>


            <!-- Personal Information -->

            <div class="form-section">

                <div class="section-title">
                    Personal Information
                </div>

                <div class="row">


                    <!-- Employee ID -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="employee_id_display">
                                Employee ID
                            </label>

                            <input
                                type="text"
                                id="employee_id_display"
                                class="form-control"
                                readonly
                            >

                        </div>

                    </div>


                    <!-- First Name -->

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
                            >

                        </div>

                    </div>


                    <!-- Last Name -->

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
                            >

                        </div>

                    </div>


                    <!-- Email -->

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
                            >

                        </div>

                    </div>


                    <!-- Phone -->

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
                            >

                        </div>

                    </div>


                    <!-- Date of Birth -->

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


                    <!-- Gender -->

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


                    <!-- Date of Joining -->

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


                    <!-- Department -->

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


                    <!-- Designation -->

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
                            >

                        </div>

                    </div>


                    <!-- Salary -->

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
                                step="0.01"
                            >

                        </div>

                    </div>


                    <!-- Status -->

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
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small
                        id="currentPhoto"
                        class="text-muted d-block mt-2"
                    ></small>

                </div>

            </div>


            <!-- Buttons -->

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
                        id="updateButton"
                    >
                        Update Employee
                    </button>

                </div>

            </div>


        </form>

    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>
<script>
    const employeeId = <?= json_encode($employee_id) ?>;
</script>
<script src="../../../public/js/employee/employee-edit.js"></script>
</body>

</html>
