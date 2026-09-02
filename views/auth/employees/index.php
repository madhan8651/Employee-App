<?php

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../controllers/EmployeeController.php";

AuthMiddleware::check();

$controller = new EmployeeController();


// =========================
// PAGINATION
// =========================

$limit = 5;

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


// If requested page is greater than
// available pages, go to last page

if ($totalPages > 0 && $page > $totalPages) {
    $page = $totalPages;
}


// Calculate offset

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
            width: min(100%, 1200px);
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
            margin-bottom: 1.8rem;
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

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 1.5rem;
        }

        .btn-add {
            border: none;
            border-radius: 12px;
            padding: 0.8rem 1.1rem;

            background: linear-gradient(
                135deg,
                #111827 0%,
                #4f46e5 100%
            );

            color: #fff;
            font-size: 0.9rem;
            font-weight: 700;

            box-shadow:
                0 10px 20px rgba(79, 70, 229, 0.15);
        }

        .btn-add:hover {
            color: #fff;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            min-height: 48px;
            padding-left: 42px;

            border: 1px solid #d1d5db;
            border-radius: 12px;

            font-size: 0.9rem;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: var(--muted);

            z-index: 5;
        }

        .search-box input:focus {
            border-color: rgba(79, 70, 229, 0.85);

            box-shadow:
                0 0 0 0.2rem rgba(79, 70, 229, 0.12);
        }

        .form-select {
            min-height: 48px;

            border: 1px solid #d1d5db;
            border-radius: 12px;

            font-size: 0.9rem;
        }

        .form-select:focus {
            border-color: rgba(79, 70, 229, 0.85);

            box-shadow:
                0 0 0 0.2rem rgba(79, 70, 229, 0.12);
        }

        .btn-reset {
            min-height: 48px;

            border-radius: 12px;

            font-size: 0.9rem;
            font-weight: 600;
        }

        .table-wrapper {
            border: 1px solid var(--panel-border);
            border-radius: 14px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            padding: 15px;

            background-color: #f8f9fb;

            border-bottom: 1px solid #e5e7eb;

            color: #6b7280;

            font-size: 0.75rem;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 0.04em;

            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px 15px;

            border-bottom: 1px solid #f0f1f3;

            font-size: 0.88rem;

            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: #fafbff;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .employee-avatar {
            width: 44px;
            height: 44px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(79, 70, 229, 0.08);

            color: var(--accent);

            font-size: 0.9rem;
            font-weight: 800;

            flex-shrink: 0;
        }

        .employee-name {
            font-weight: 700;
            color: var(--text);
        }

        .employee-id {
            margin-top: 3px;

            color: var(--muted);

            font-size: 0.75rem;
        }

        .department-name {
            font-weight: 600;
        }

        .designation {
            color: #4b5563;
        }

        .email {
            color: #4b5563;
        }

        .phone {
            color: #4b5563;
        }

        .salary {
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;

            padding: 0.45rem 0.75rem;

            border-radius: 999px;

            font-size: 0.72rem;
            font-weight: 700;
        }

        .action-btn {
            width: 36px;
            height: 36px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid #d1d5db;
            border-radius: 10px;

            background: #fff;

            color: #4b5563;

            font-size: 1.1rem;

            text-decoration: none;
        }

        .action-btn:hover {
            background: #f5f7fb;
        }

        .empty-state {
            padding: 60px 20px !important;

            text-align: center;

            color: var(--muted);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-top: 1.5rem;
        }

        .employee-count {
            color: var(--muted);
            font-size: 0.82rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: var(--accent);

            border-radius: 8px;

            margin-left: 4px;

            font-size: 0.8rem;
        }

        .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        @media (max-width: 991.98px) {

            .filter-search {
                width: 100%;
            }

        }

        @media (max-width: 767.98px) {

            body {
                padding: 20px 12px;
            }

            .employee-card {
                padding: 1.2rem;
            }

            .top-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-add {
                width: 100%;
            }

            .page-header h3 {
                font-size: 1.7rem;
            }

            .table-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
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

                </form>

            </div>


            <!-- Department -->

            <div class="col-lg-2 col-md-4">

                <form
                    method="GET"
                    action="index.php"
                >

                    <?php if ($search !== ""): ?>

                        <input
                            type="hidden"
                            name="search"
                            value="<?= htmlspecialchars($search) ?>"
                        >

                    <?php endif; ?>

                    <select
                        name="department_id"
                        class="form-select"
                        onchange="this.form.submit()"
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

                    <?php if ($search !== ""): ?>

                        <input
                            type="hidden"
                            name="search"
                            value="<?= htmlspecialchars($search) ?>"
                        >

                    <?php endif; ?>

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
                        onchange="this.form.submit()"
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

                    <?php if ($search !== ""): ?>

                        <input
                            type="hidden"
                            name="search"
                            value="<?= htmlspecialchars($search) ?>"
                        >

                    <?php endif; ?>

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
                        onchange="this.form.submit()"
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

</body>

</html>