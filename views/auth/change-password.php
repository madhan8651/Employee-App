<?php

require_once __DIR__ . "/../../middleware/CsrfMiddleware.php";

$csrfToken = CsrfMiddleware::generateToken();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Password - Employee Management System</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >
    <link
    rel="stylesheet"
    href="../../public/css/style.css"
>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

</head>

<body>

<div class="change-password-shell">

    <div class="change-password-card">

        <div class="brand">

            <div class="brand-mark">
                E
            </div>

            <h1 class="brand-title">
                Employee App
            </h1>

        </div>


        <div class="change-password-header">

            <span class="eyebrow">
                Account Security
            </span>

            <h3>
                Change Password
            </h3>

            <p>
                Update your password securely.
            </p>

        </div>
<?php if ($message !== ""): ?>

    <?php if ($message === "Password changed successfully"): ?>

        <div class="alert alert-success">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php else: ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>

<?php endif; ?>

        <form
            method="POST"
            action="/Employee_App/public/change-password.php"
        >
        <input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars($csrfToken) ?>"
>

            <div class="form-group">

                <label for="current_password">
                    Current Password
                </label>

                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    class="form-control"
                    placeholder="Enter current password"
                    required
                >

            </div>


            <div class="form-group">

                <label for="new_password">
                    New Password
                </label>

                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    class="form-control"
                    placeholder="Enter new password"
                    required
                >

            </div>


            <div class="form-group">

                <label for="confirm_password">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    class="form-control"
                    placeholder="Confirm new password"
                    required
                >

            </div>


            <button
    type="submit"
    class="btn-change-password">

                Change Password

            </button>

        </form>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>