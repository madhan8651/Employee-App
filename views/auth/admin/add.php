<?php

require_once __DIR__ . "/../../../middleware/CsrfMiddleware.php";
require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../middleware/RoleMiddleware.php";

AuthMiddleware::check();
RoleMiddleware::check("Admin");

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

    <title>Add User - Employee Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="../../../public/css/style.css"
    >

</head>

<body>

<div class="user-shell">

    <div class="user-card">

        <div class="brand">

            <div class="brand-mark">
                E
            </div>

            <h1 class="brand-title">
                Employee App
            </h1>

        </div>

        <div class="user-header">

            <span class="eyebrow">
                User Management
            </span>

            <h3>
                Add User
            </h3>

            <p>
                Create a new application user.
            </p>

        </div>

        <!-- API response message -->
        <div
            id="message"
            class="mb-3"
        ></div>

        <form
            id="userForm"
            enctype="multipart/form-data"
        >

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($csrfToken) ?>"
            >

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="name">
                            Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="Enter name"
                            required
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
                            required
                        >

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="username">
                            Username
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control"
                            placeholder="Enter username"
                            required
                        >

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter password"
                            required
                        >

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="role">
                            Role
                        </label>

                        <select
                            id="role"
                            name="role"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select role
                            </option>

                            <option value="Admin">
                                Admin
                            </option>

                            <option value="Employee">
                                Employee
                            </option>

                        </select>

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
                            required
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
            <div
                class="d-flex justify-content-center align-items-center gap-2"
            >
                <a
                    href="/Employee_App/views/auth/admin/dashboard.php"
                    class="btn-user"
                    style="display: inline-flex; justify-content: center; align-items: center; min-width: 110px; height: 42px; text-decoration: none;"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="btn-user"
                    style="min-width: 110px; height: 42px;"
                >
                    Create User
                </button>
            </div>

        </form>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>
<script src="../../../public/js/admin/admin-add user.js"></script>
</body>

</html>
