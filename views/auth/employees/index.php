<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";

AuthMiddleware::check();

$search = trim($_GET["search"] ?? "");
$department_id = $_GET["department_id"] ?? "";
$status = $_GET["status"] ?? "";
$sort = $_GET["sort"] ?? "";
$page = isset($_GET["page"])
    ? (int) $_GET["page"]
    : 1;

if ($page < 1) {
    $page = 1;
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
        Employees - Employee Management System
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


    <!-- Shared CSS -->

    <link
        rel="stylesheet"
        href="../../../public/css/style.css"
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
                Employee Management
            </span>

            <h3>
                Employees
            </h3>

            <p>
                Manage and view all employee records.
            </p>

        </div>


        <!-- Top Actions -->

        <div class="top-actions">

            <div class="text-muted small">
                Employee Directory
            </div>

            <div class="d-flex gap-2">

                <a
    href="/Employee_App/views/auth/admin/dashboard.php"
    class="btn btn-blue btn-back"
                    style="background-color: #F3F4F6; border-color: #D1D5DB; color: #374151;"
>
    ← Back
</a>

                <a
                    href="add.php"
                    class="btn btn-add"
                >
                    + Add Employee
                </a>

            </div>

        </div>


        <!-- Search & Filters -->

        <div class="row g-3 mb-4">


            <!-- Search -->

            <div class="col-lg-5 col-md-12">

                <form
                    id="searchForm"
                >

                    <div class="search-box">

                        <span class="search-icon">
                            🔍
                        </span>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Search employees..."
                            value="<?= htmlspecialchars($search) ?>"
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn btn-search"
                    >
                        Search
                    </button>

                </form>

            </div>


            <!-- Department -->

            <div class="col-lg-2 col-md-4">

                <select
                    id="department_id"
                    name="department_id"
                    class="form-select"
                >

                    <option value="">
                        All Departments
                    </option>

                    <option
                        value="1"
                        <?= $department_id == "1" ? "selected" : "" ?>
                    >
                        HR
                    </option>

                    <option
                        value="2"
                        <?= $department_id == "2" ? "selected" : "" ?>
                    >
                        IT
                    </option>

                    <option
                        value="3"
                        <?= $department_id == "3" ? "selected" : "" ?>
                    >
                        Finance
                    </option>

                    <option
                        value="4"
                        <?= $department_id == "4" ? "selected" : "" ?>
                    >
                        Sales
                    </option>

                    <option
                        value="5"
                        <?= $department_id == "5" ? "selected" : "" ?>
                    >
                        Marketing
                    </option>

                </select>

            </div>


            <!-- Status -->

            <div class="col-lg-2 col-md-4">

                <select
                    id="status"
                    name="status"
                    class="form-select"
                >

                    <option value="">
                        All Status
                    </option>

                    <option
                        value="Active"
                        <?= $status === "Active" ? "selected" : "" ?>
                    >
                        Active
                    </option>

                    <option
                        value="Inactive"
                        <?= $status === "Inactive" ? "selected" : "" ?>
                    >
                        Inactive
                    </option>

                </select>

            </div>


            <!-- Sort -->

            <div class="col-lg-2 col-md-4">

                <select
                    id="sort"
                    name="sort"
                    class="form-select"
                >

                    <option value="">
                        Sort By
                    </option>

                    <option
                        value="employee_id"
                        <?= $sort === "employee_id" ? "selected" : "" ?>
                    >
                        Employee ID
                    </option>

                    <option
                        value="name"
                        <?= $sort === "name" ? "selected" : "" ?>
                    >
                        Name
                    </option>

                    <option
                        value="salary"
                        <?= $sort === "salary" ? "selected" : "" ?>
                    >
                        Salary
                    </option>

                </select>

            </div>


            <!-- Reset -->

            <div class="col-lg-1 col-md-12">

                <button
                    type="button"
                    class="btn btn-light border btn-reset w-100"
                    id="resetButton"
                >
                    Reset
                </button>

            </div>

        </div>


        <!-- API Message -->

        <div id="message"></div>


        <!-- Employee Table -->

        <div class="table-wrapper">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                Employee
                            </th>

                            <th>
                                Department
                            </th>

                            <th>
                                Designation
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Phone
                            </th>

                            <th>
                                Salary
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody id="employeeTableBody">

                        <tr>

                            <td
                                colspan="8"
                                class="empty-state"
                            >
                                Loading employees...
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Footer -->

        <div class="table-footer">


            <div
                class="employee-count"
                id="employeeCount"
            >
                Showing
                <strong>0</strong>
                employee(s)
            </div>


            <!-- Pagination -->

            <nav>

                <ul
                    class="pagination pagination-sm"
                    id="pagination"
                >
                </ul>

            </nav>


        </div>

    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>
<script>
    let currentPage = <?= $page ?>;   
</script>
<script src="../../../public/js/employee/employee-index.js"></script>
</body>

</html>
