<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../controllers/EmployeeController.php";

AuthMiddleware::check();

$controller = new EmployeeController();


// =========================
// PAGINATION
// =========================

$limit = 4;

$page = isset($_GET["page"])
    ? (int) $_GET["page"]
    : 1;

if ($page < 1) {
    $page = 1;
}


// =========================
// FILTERS
// =========================

$search = trim($_GET["search"] ?? "");
$department_id = $_GET["department_id"] ?? "";
$status = $_GET["status"] ?? "";
$sort = $_GET["sort"] ?? "";


// =========================
// TOTAL EMPLOYEES
// =========================

$totalEmployees = $controller->countFilteredEmployees(
    $search,
    $department_id,
    $status
);


// =========================
// TOTAL PAGES
// =========================

$totalPages = (int) ceil(
    $totalEmployees / $limit
);

if ($totalPages > 0 && $page > $totalPages) {
    $page = $totalPages;
}


// =========================
// OFFSET
// =========================

$offset = ($page - 1) * $limit;


// =========================
// GET EMPLOYEES
// =========================

$employees = $controller->getFilteredEmployees(
    $search,
    $department_id,
    $status,
    $sort,
    $limit,
    $offset
);

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

            <a
                href="add.php"
                class="btn btn-add"
            >
                + Add Employee
            </a>

        </div>


        <!-- Search & Filters -->

        <div class="row g-3 mb-4">


            <!-- Search -->

            <div class="col-lg-5 col-md-12">

                <form
                    method="GET"
                    action="index.php"
                >

                    <div class="search-box">

                        <span class="search-icon">
                            🔍
                        </span>

                        <input
                            type="text"
                            name="search"
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

                <form
                    method="GET"
                    action="index.php"
                >

                    <input
                        type="hidden"
                        name="search"
                        value="<?= htmlspecialchars($search) ?>"
                    ?>


                    <select
                        name="department_id"
                        class="form-select"
                        onchange="updateFilterSearch(this.form); this.form.submit()"
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

                </form>

            </div>


            <!-- Status -->

            <div class="col-lg-2 col-md-4">

                <form
                    method="GET"
                    action="index.php"
                >

                    <input
                        type="hidden"
                        name="search"
                        id="statusSearch"
                        value="<?= htmlspecialchars($search) ?>"
                    ?>


                    <?php if ($department_id !== ""): ?>

                        <input
                            type="hidden"
                            name="department_id"
                            value="<?= htmlspecialchars($department_id) ?>"
                        >

                    <?php endif; ?>


                    <select
                        name="status"
                        class="form-select"
                        onchange="updateFilterSearch(this.form); this.form.submit()"
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

                </form>

            </div>


            <!-- Sort -->

            <div class="col-lg-2 col-md-4">

                <form
                    method="GET"
                    action="index.php"
                >

                    <input
                        type="hidden"
                        name="search"
                        value="<?= htmlspecialchars($search) ?>"
                    ?>


                    <?php if ($department_id !== ""): ?>

                        <input
                            type="hidden"
                            name="department_id"
                            value="<?= htmlspecialchars($department_id) ?>"
                        >

                    <?php endif; ?>


                    <?php if ($status !== ""): ?>

                        <input
                            type="hidden"
                            name="status"
                            value="<?= htmlspecialchars($status) ?>"
                        >

                    <?php endif; ?>


                    <select
                        name="sort"
                        class="form-select"
                        onchange="updateFilterSearch(this.form); this.form.submit()"
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

                </form>

            </div>


            <!-- Reset -->

            <div class="col-lg-1 col-md-12">

                <button
                    type="button"
                    class="btn btn-light border btn-reset w-100"
                    onclick="window.location.href='index.php';"
                >
                    Reset
                </button>

            </div>

        </div>


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


                    <tbody>

                    <?php if (empty($employees)): ?>

                        <tr>

                            <td
                                colspan="8"
                                class="empty-state"
                            >
                                No employees found.
                            </td>

                        </tr>

                    <?php else: ?>


                        <?php foreach ($employees as $employee): ?>

                            <tr>


                                <!-- Employee -->

                                <td>

                                    <div class="employee-info">

                                        <div class="employee-avatar">

                                            <?= strtoupper(
                                                substr(
                                                    $employee["first_name"],
                                                    0,
                                                    1
                                                )
                                            ) ?>

                                        </div>


                                        <div>

                                            <div class="employee-name">

                                                <?= htmlspecialchars(
                                                    $employee["first_name"]
                                                    . " "
                                                    . $employee["last_name"]
                                                ) ?>

                                            </div>


                                            <div class="employee-id">

                                                <?= htmlspecialchars(
                                                    $employee["employee_id"]
                                                ) ?>

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <!-- Department -->

                                <td>

                                    <span class="department-name">

                                        <?= htmlspecialchars(
                                            $employee["department_name"]
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Designation -->

                                <td>

                                    <span class="designation">

                                        <?= htmlspecialchars(
                                            $employee["designation"]
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Email -->

                                <td>

                                    <span class="email">

                                        <?= htmlspecialchars(
                                            $employee["email"]
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Phone -->

                                <td>

                                    <span class="phone">

                                        <?= htmlspecialchars(
                                            $employee["phone"]
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Salary -->

                                <td>

                                    <span class="salary">

                                        ₹<?= htmlspecialchars(
                                            $employee["salary"]
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Status -->

                                <td>

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

                                </td>


                                <!-- Actions -->

                                <td class="text-end">

                                    <a
                                        href="view.php?employee_id=<?= urlencode($employee["employee_id"]) ?>"
                                        class="action-btn me-1"
                                        title="View Employee"
                                    >
                                        👁
                                    </a>


                                    <a
                                        href="edit.php?employee_id=<?= urlencode($employee["employee_id"]) ?>"
                                        class="action-btn"
                                        title="Edit Employee"
                                    >
                                        ✎
                                    </a>


                                    <a
                                        href="deactivate.php?employee_id=<?= urlencode($employee["employee_id"]) ?>"
                                        class="action-btn"
                                        title="Deactivate Employee"
                                        onclick="return confirm('Are you sure you want to deactivate this employee?');"
                                    >
                                        ⏸
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>


                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Footer -->

        <div class="table-footer">


            <div class="employee-count">

                Showing

                <strong>
                    <?= count($employees) ?>
                </strong>

                employee(s)

            </div>


            <!-- Pagination -->

            <?php if ($totalPages > 0): ?>

                <nav>

                    <ul class="pagination pagination-sm">


                        <!-- Previous -->

                        <li
                            class="page-item <?= $page <= 1 ? 'disabled' : '' ?>"
                        >

                            <?php if ($page > 1): ?>

                                <a
                                    class="page-link"
                                    href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&department_id=<?= urlencode($department_id) ?>&status=<?= urlencode($status) ?>&sort=<?= urlencode($sort) ?>"
                                >
                                    Previous
                                </a>

                            <?php else: ?>

                                <span class="page-link">
                                    Previous
                                </span>

                            <?php endif; ?>

                        </li>


                        <!-- Page Numbers -->

                        <?php for (
                            $i = 1;
                            $i <= $totalPages;
                            $i++
                        ): ?>

                            <li
                                class="page-item <?= $i == $page ? 'active' : '' ?>"
                            >

                                <a
                                    class="page-link"
                                    href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&department_id=<?= urlencode($department_id) ?>&status=<?= urlencode($status) ?>&sort=<?= urlencode($sort) ?>"
                                >
                                    <?= $i ?>
                                </a>

                            </li>

                        <?php endfor; ?>


                        <!-- Next -->

                        <li
                            class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>"
                        >

                            <?php if ($page < $totalPages): ?>

                                <a
                                    class="page-link"
                                    href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&department_id=<?= urlencode($department_id) ?>&status=<?= urlencode($status) ?>&sort=<?= urlencode($sort) ?>"
                                >
                                    Next
                                </a>

                            <?php else: ?>

                                <span class="page-link">
                                    Next
                                </span>

                            <?php endif; ?>

                        </li>

                    </ul>

                </nav>

            <?php endif; ?>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

<script src="../../../public/js/script.js"></script>

</body>

</html>