<?php

$message = $message ?? "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Employee_App/public/css/style.css">
</head>

<body>

    <div class="login-shell">

        <div class="login-card">

            <div class="brand">
                <div class="brand-mark">E</div>
                <h1 class="brand-title">Employee App</h1>
            </div>

            <div class="login-header">
                <span class="eyebrow">Access portal</span>
                <h3>Sign In</h3>
                <p>Use your email or username to continue.</p>
            </div>

            <?php if ($message !== ""): ?>

                <div class="alert alert-danger">
                    <?= htmlspecialchars($message) ?>
                </div>

            <?php endif; ?>

            <form method="POST" action="/Employee_App/public/login.php">

                <div class="form-group">

                    <label for="login">Email or Username</label>

                    <input
                        type="text"
                        id="login"
                        name="login"
                        class="form-control"
                        placeholder="Enter email or username"
                        required
                        autofocus
                    >

                </div>

                <div class="form-group">

                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter password"
                        required
                    >

                </div>

                <button type="submit" class="btn btn-login">
                    Sign In
                </button>

            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>