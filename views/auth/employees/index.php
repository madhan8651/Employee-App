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
                    style="background-color: #2563EB; border-color: #2563EB; color: #FFFFFF;"
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

/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/

const API_URL =
    "/Employee_App/routes/api.php/employees";


/*
|--------------------------------------------------------------------------
| Current Page
|--------------------------------------------------------------------------
*/

let currentPage =
    <?= $page ?>;


/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

const employeeTableBody =
    document.getElementById(
        "employeeTableBody"
    );

const employeeCount =
    document.getElementById(
        "employeeCount"
    );

const pagination =
    document.getElementById(
        "pagination"
    );

const messageBox =
    document.getElementById(
        "message"
    );

const searchInput =
    document.getElementById(
        "search"
    );

const departmentSelect =
    document.getElementById(
        "department_id"
    );

const statusSelect =
    document.getElementById(
        "status"
    );

const sortSelect =
    document.getElementById(
        "sort"
    );


/*
|--------------------------------------------------------------------------
| SHOW MESSAGE
|--------------------------------------------------------------------------
*/

function showMessage(message, success)
{
    messageBox.innerHTML =
        `
        <div class="alert ${success ? "alert-success" : "alert-danger"}">
            ${message}
        </div>
        `;

    setTimeout(
        function ()
        {
            messageBox.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        },
        100
    );
}


/*
|--------------------------------------------------------------------------
| LOAD EMPLOYEES
|--------------------------------------------------------------------------
*/

async function loadEmployees()
{

    employeeTableBody.innerHTML =
        `
        <tr>
            <td
                colspan="8"
                class="empty-state"
            >
                Loading employees...
            </td>
        </tr>
        `;


    const params =
        new URLSearchParams();


    const search =
        searchInput.value.trim();

    const departmentId =
        departmentSelect.value;

    const status =
        statusSelect.value;

    const sort =
        sortSelect.value;


    if (search !== "") {
        params.append(
            "search",
            search
        );
    }


    if (departmentId !== "") {
        params.append(
            "department_id",
            departmentId
        );
    }


    if (status !== "") {
        params.append(
            "status",
            status
        );
    }


    if (sort !== "") {
        params.append(
            "sort",
            sort
        );
    }


    params.append(
        "page",
        currentPage
    );


    try {

        const response =
            await fetch(
                API_URL +
                "?" +
                params.toString(),
                {
                    method: "GET",
                    credentials: "same-origin"
                }
            );


        const result =
            await response.json();


        if (!response.ok) {

            throw new Error(
                result.message ||
                "Failed to load employees."
            );
        }


        const employees =
            result.data || [];

        const pageData =
            result.pagination || {};


        /*
        |--------------------------------------------------------------------------
        | DISPLAY EMPLOYEES
        |--------------------------------------------------------------------------
        */

        employeeTableBody.innerHTML = "";


        if (employees.length === 0) {

            employeeTableBody.innerHTML =
                `
                <tr>
                    <td
                        colspan="8"
                        class="empty-state"
                    >
                        No employees found.
                    </td>
                </tr>
                `;

        } else {

            employees.forEach(
                function (employee)
                {

                    const row =
                        document.createElement("tr");


                    const firstInitial =
                        (
                            employee.first_name ||
                            ""
                        )
                        .charAt(0)
                        .toUpperCase();


                    const fullName =
                        (
                            employee.first_name ||
                            ""
                        ) +
                        " " +
                        (
                            employee.last_name ||
                            ""
                        );


                    const status =
                        (
                            employee.status ||
                            ""
                        )
                        .toLowerCase();


                    const statusHtml =
                        status === "active"

                        ?

                        `
                        <span
                            class="badge bg-success-subtle text-success status-badge"
                        >
                            Active
                        </span>
                        `

                        :

                        `
                        <span
                            class="badge bg-secondary-subtle text-secondary status-badge"
                        >
                            Inactive
                        </span>
                        `;


                    row.innerHTML =
                        `
                        <td>

                            <div class="employee-info">

                                <div class="employee-avatar">
                                    ${firstInitial}
                                </div>

                                <div>

                                    <div class="employee-name">
                                        ${escapeHtml(fullName)}
                                    </div>

                                    <div class="employee-id">
                                        ${escapeHtml(employee.employee_id || "")}
                                    </div>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="department-name">
                                ${escapeHtml(employee.department_name || "")}
                            </span>

                        </td>


                        <td>

                            <span class="designation">
                                ${escapeHtml(employee.designation || "")}
                            </span>

                        </td>


                        <td>

                            <span class="email">
                                ${escapeHtml(employee.email || "")}
                            </span>

                        </td>


                        <td>

                            <span class="phone">
                                ${escapeHtml(employee.phone || "")}
                            </span>

                        </td>


                        <td>

                            <span class="salary">
                                ₹${escapeHtml(employee.salary || "")}
                            </span>

                        </td>


                        <td>
                            ${statusHtml}
                        </td>


                        <td class="text-end">

                            <a
                                href="view.php?employee_id=${encodeURIComponent(employee.employee_id)}"
                                class="action-btn me-1"
                                title="View Employee"
                            >
                                👁
                            </a>


                            <a
                                href="edit.php?employee_id=${encodeURIComponent(employee.employee_id)}"
                                class="action-btn"
                                title="Edit Employee"
                            >
                                ✎
                            </a>


                            <a
                                href="deactivate.php?employee_id=${encodeURIComponent(employee.employee_id)}"
                                class="action-btn"
                                title="Deactivate Employee"
                                onclick="return confirm('Are you sure you want to deactivate this employee?');"
                            >
                                ⏸
                            </a>

                        </td>
                        `;


                    employeeTableBody.appendChild(
                        row
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE COUNT
        |--------------------------------------------------------------------------
        */

        employeeCount.innerHTML =
            `
            Showing
            <strong>
                ${employees.length}
            </strong>
            employee(s)
            `;


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        createPagination(
            pageData.current_page || 1,
            pageData.total_pages || 0
        );


    } catch (error) {

        employeeTableBody.innerHTML =
            `
            <tr>
                <td
                    colspan="8"
                    class="empty-state"
                >
                    Unable to load employees.
                </td>
            </tr>
            `;


        showMessage(
            error.message ||
            "Unable to connect to Employee API.",
            false
        );
    }
}


/*
|--------------------------------------------------------------------------
| CREATE PAGINATION
|--------------------------------------------------------------------------
*/

function createPagination(
    page,
    totalPages
)
{
    pagination.innerHTML = "";


    if (totalPages <= 0) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIOUS
    |--------------------------------------------------------------------------
    */

    const previous =
        document.createElement("li");

    previous.className =
        "page-item " +
        (
            page <= 1
                ? "disabled"
                : ""
        );


    if (page > 1) {

        previous.innerHTML =
            `
            <a
                href="#"
                class="page-link"
            >
                Previous
            </a>
            `;


        previous.querySelector("a")
            .addEventListener(
                "click",
                function (event)
                {

                    event.preventDefault();

                    currentPage =
                        page - 1;

                    loadEmployees();
                }
            );

    } else {

        previous.innerHTML =
            `
            <span class="page-link">
                Previous
            </span>
            `;
    }


    pagination.appendChild(
        previous
    );


    /*
    |--------------------------------------------------------------------------
    | PAGE NUMBERS
    |--------------------------------------------------------------------------
    */

    for (
        let i = 1;
        i <= totalPages;
        i++
    ) {

        const pageItem =
            document.createElement("li");


        pageItem.className =
            "page-item " +
            (
                i === page
                    ? "active"
                    : ""
            );


        pageItem.innerHTML =
            `
            <a
                href="#"
                class="page-link"
            >
                ${i}
            </a>
            `;


        pageItem.querySelector("a")
            .addEventListener(
                "click",
                function (event)
                {

                    event.preventDefault();

                    currentPage = i;

                    loadEmployees();
                }
            );


        pagination.appendChild(
            pageItem
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NEXT
    |--------------------------------------------------------------------------
    */

    const next =
        document.createElement("li");


    next.className =
        "page-item " +
        (
            page >= totalPages
                ? "disabled"
                : ""
        );


    if (page < totalPages) {

        next.innerHTML =
            `
            <a
                href="#"
                class="page-link"
            >
                Next
            </a>
            `;


        next.querySelector("a")
            .addEventListener(
                "click",
                function (event)
                {

                    event.preventDefault();

                    currentPage =
                        page + 1;

                    loadEmployees();
                }
            );

    } else {

        next.innerHTML =
            `
            <span class="page-link">
                Next
            </span>
            `;
    }


    pagination.appendChild(
        next
    );
}


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

document.getElementById(
    "searchForm"
).addEventListener(
    "submit",
    function (event)
    {

        event.preventDefault();

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| DEPARTMENT FILTER
|--------------------------------------------------------------------------
*/

departmentSelect.addEventListener(
    "change",
    function ()
    {

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| STATUS FILTER
|--------------------------------------------------------------------------
*/

statusSelect.addEventListener(
    "change",
    function ()
    {

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| SORT
|--------------------------------------------------------------------------
*/

sortSelect.addEventListener(
    "change",
    function ()
    {

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| RESET
|--------------------------------------------------------------------------
*/

document.getElementById(
    "resetButton"
).addEventListener(
    "click",
    function ()
    {

        searchInput.value = "";

        departmentSelect.value = "";

        statusSelect.value = "";

        sortSelect.value = "";

        currentPage = 1;

        messageBox.innerHTML = "";

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| HTML ESCAPE
|--------------------------------------------------------------------------
*/

function escapeHtml(value)
{
    return String(value)
        .replace(
            /&/g,
            "&amp;"
        )
        .replace(
            /</g,
            "&lt;"
        )
        .replace(
            />/g,
            "&gt;"
        )
        .replace(
            /"/g,
            "&quot;"
        )
        .replace(
            /'/g,
            "&#039;"
        );
}


/*
|--------------------------------------------------------------------------
| INITIAL LOAD
|--------------------------------------------------------------------------
*/

loadEmployees();

</script>


</body>

</html>