<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Employee Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm">

        <div class="card-body p-5">

            <h1 class="mb-3">
                Employee Management System
            </h1>

            <h4 class="text-primary">
                Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>
            </h4>

            <p class="text-muted">
                Role: <?= htmlspecialchars($_SESSION["role"]) ?>
            </p>

            <hr>

            <h5>
                Dashboard
            </h5>

            <p>
                You have successfully logged in.
            </p>

            <a
                href="logout.php"
                class="btn btn-danger">

                Logout

            </a>
            <a href="change-password.php" class="btn btn-primary">
    Change Password
</a>

        </div>

    </div>

</div>

</body>

</html>