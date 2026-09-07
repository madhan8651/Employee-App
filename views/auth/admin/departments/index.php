<?php

require_once __DIR__ . "/../../../../middleware/AuthMiddleware.php";

AuthMiddleware::check();

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
        Departments - Employee Management System
    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Google Font -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- Shared CSS -->

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
                Departments
            </h3>

            <p>
                Manage and view all department records.
            </p>
            

        </div>


        <!-- Top Actions -->

        <div class="top-actions">

            <div class="text-muted small">
                Department Directory
            </div>

            <a
                href="add.php"
                class="btn btn-add"
            >
                + Add Department
            </a>

        </div>


        <!-- Search & Filters -->

        <div class="row g-3 mb-4">


            <!-- Search -->

            <div class="col-lg-8 col-md-12">

                <form id="searchForm">

                    <div class="search-box">

                        <span class="search-icon">
                            🔍
                        </span>

                        <input
                            type="text"
                            id="searchDepartment"
                            class="form-control"
                            placeholder="Search departments..."
                            autocomplete="off"
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


            <!-- Status -->

            <div class="col-lg-3 col-md-8">

                <select
                    id="statusFilter"
                    class="form-select"
                >

                    <option value="">
                        All Status
                    </option>

                    <option value="Active">
                        Active
                    </option>

                    <option value="Inactive">
                        Inactive
                    </option>

                </select>

            </div>


            <!-- Reset -->

            <div class="col-lg-1 col-md-4">

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


        <!-- Department Table -->

<div class="table-wrapper">

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>
                        Department
                    </th>

                    <th>
                        Description
                    </th>

                    <th>
                        Status
                    </th>

                    <th class="text-end">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody id="departmentTableBody">

                <tr>

                    <td
                        colspan="4"
                        class="empty-state"
                    >
                        Loading departments...
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
                id="departmentCount"
            >
                Showing
                <strong>0</strong>
                department(s)
            </div>

        </div>

    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


<script src="../../../../public/js/department.js"></script>


</body>

</html>