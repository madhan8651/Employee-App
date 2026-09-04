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
    <link rel="stylesheet" href="../../../public/css/style.css">

</head>


<body>

<div class="employee-shell form-page">

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