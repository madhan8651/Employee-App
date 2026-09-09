<?php

session_start();

require_once __DIR__ . "/../../../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../../../middleware/RoleMiddleware.php";
require_once __DIR__ . "/../../../middleware/CsrfMiddleware.php";


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

AuthMiddleware::check();
RoleMiddleware::check("Employee");


/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/

$csrfToken =
    CsrfMiddleware::generateToken();

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
        Employee Profile - Employee Management System
    </title>


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =====================================================
         GOOGLE FONT
    ====================================================== -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         MAIN CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="../../../public/css/style.css"
    >


    <!-- =====================================================
         EMPLOYEE PROFILE CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="../../../public/css/employee-profile.css"
    >

</head>


<body>


<div class="profile-shell">

    <div class="profile-card">


        <!-- =================================================
             BRAND
        ================================================== -->

        <div class="profile-brand">

            <div class="brand-logo">
                E
            </div>

            <div class="brand-text">

                <h2>
                    Employee App
                </h2>

                <p>
                    Employee Management System
                </p>

            </div>

        </div>


        <!-- =================================================
             PAGE HEADER
        ================================================== -->

        <div class="profile-header">

            <span class="eyebrow">
                Employee Portal
            </span>

            <h1>
                My Profile
            </h1>

            <p>
                View your profile information.
            </p>

        </div>


        <!-- =================================================
             MESSAGE
        ================================================== -->

        <div id="message"></div>


        <!-- =================================================
             CSRF TOKEN
        ================================================== -->

        <input
            type="hidden"
            id="csrf_token"
            name="csrf_token"
            value="<?= htmlspecialchars($csrfToken) ?>"
        >


        <!-- =================================================
             PROFILE CONTENT
        ================================================== -->

        <div id="profileContainer">

        </div>


        <!-- =================================================
             PROFILE ACTION
        ================================================== -->
    </div>

</div>


<!-- =========================================================
     BOOTSTRAP JS
========================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


<!-- =========================================================
     EMPLOYEE PROFILE JS
========================================================== -->

<script
    src="../../../public/js/employee-profile.js">
</script>


</body>

</html>