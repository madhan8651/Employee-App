<?php

require_once __DIR__ . "/../../../controllers/UserController.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $controller = new UserController();
    $result = $controller->createUser(
    $_POST["name"] ?? "",
    $_POST["email"] ?? "",
    $_POST["username"] ?? "",
    $_POST["password"] ?? "",
    $_POST["role"] ?? "",
    $_POST["status"] ?? ""
);

$message = $result["message"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <style>

        :root {
            --bg: #f5f7fb;
            --panel: #ffffff;
            --panel-border: #e5e7eb;
            --accent: #4f46e5;
            --text: #111827;
            --muted: #6b7280;
            --shadow: 0 18px 40px rgba(17, 24, 39, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: var(--bg);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: var(--text);
        }

        .user-shell {
            width: min(100%, 700px);
        }

        .user-card {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 2rem 2.25rem;
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

        .user-header {
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

        .user-header h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .user-header p {
            margin: 0.6rem 0 0;
            color: var(--muted);
            font-size: 0.96rem;
        }

        form {
            margin-top: 1.5rem;
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
            height: 52px;
            padding: 0.8rem 0.95rem;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            background: #fff;
            font-size: 0.96rem;
            color: var(--text);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(79, 70, 229, 0.85);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.12);
            outline: none;
        }

        .btn-user {
            width: 100%;
            margin-top: 0.7rem;
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
            letter-spacing: 0.02em;
            box-shadow: 0 12px 22px rgba(79, 70, 229, 0.18);
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .btn-user:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(79, 70, 229, 0.24);
            color: #fff;
        }

        @media (max-width: 575.98px) {

            .user-card {
                padding: 1.5rem 1.1rem;
            }

            .brand-title {
                font-size: 1.6rem;
            }

            .user-header h3 {
                font-size: 1.75rem;
            }

        }

    </style>
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
        <?php if ($message !== ""): ?>

    <div class="alert alert-<?= $result["success"] ? "success" : "danger" ?>">
        <?= htmlspecialchars($message) ?>
    </div>

<?php endif; ?>
        <form method="POST">

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
                        >
                            <option value="">Select role</option>
                            <option value="Admin">Admin</option>
                            <option value="Employee">Employee</option>
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
                        >
                            <option value="">Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                    </div>

                </div>

            </div>

            <button
                type="submit"
                class="btn-user">

                Create User

            </button>

        </form>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>