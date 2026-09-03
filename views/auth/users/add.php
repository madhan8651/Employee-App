<?php

require_once __DIR__ . "/../../../controllers/UserController.php";
require_once __DIR__ . "/../../../middleware/CsrfMiddleware.php";
$message = "";
$csrfToken = CsrfMiddleware::generateToken();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!CsrfMiddleware::validateToken($_POST["csrf_token"] ?? "")) {

        $message = "Invalid CSRF token.";

    } else {

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
    <link rel="stylesheet" href="../../../public/css/style.css">
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