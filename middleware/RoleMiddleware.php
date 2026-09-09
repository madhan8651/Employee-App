<?php

class RoleMiddleware
{
    public static function check($requiredRole)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // User is not authenticated
        if (!isset($_SESSION["role"])) {
            header("Location: ../auth/login.php");
            exit;
        }

        $currentRole = $_SESSION["role"];

        // Authorization failed
        if ($currentRole !== $requiredRole) {
            http_response_code(403);

            self::showForbiddenPage();

            exit;
        }

        return true;
    }


    private static function showForbiddenPage()
    {
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>

            <meta charset="UTF-8">

            <meta
                name="viewport"
                content="width=device-width, initial-scale=1.0"
            >

            <title>403 | Access Forbidden</title>


            <!-- Google Font -->

            <link
                rel="preconnect"
                href="https://fonts.googleapis.com"
            >

            <link
                href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
                rel="stylesheet"
            >


            <style>

                * {
                    box-sizing: border-box;
                }


                html,
                body {
                    margin: 0;
                    width: 100%;
                    min-height: 100%;
                }


                body {

                    min-height: 100vh;

                    display: flex;
                    align-items: center;
                    justify-content: center;

                    padding: 24px;

                    font-family: "Inter", sans-serif;

                    background:
                        linear-gradient(
                            135deg,
                            #f5f4f8 0%,
                            #eeedf3 100%
                        );

                    color: #24222a;
                }


                /* --------------------------------
                   MAIN
                -------------------------------- */

                .forbidden-page {

                    width: 100%;
                    max-width: 560px;

                }


                /* --------------------------------
                   CARD
                -------------------------------- */

                .forbidden-card {

                    position: relative;

                    background: #ffffff;

                    border: 1px solid #e5e2ea;

                    border-radius: 16px;

                    box-shadow:
                        0 20px 50px rgba(31, 27, 45, 0.10);

                    overflow: hidden;
                }


                /* --------------------------------
                   TOP LINE
                -------------------------------- */

                .forbidden-top-line {

                    height: 4px;

                    background:
                        linear-gradient(
                            90deg,
                            #272361,
                            #4a42df
                        );
                }


                /* --------------------------------
                   CONTENT
                -------------------------------- */

                .forbidden-content {

                    padding: 44px 46px 38px;

                    text-align: center;
                }


                /* --------------------------------
                   ICON
                -------------------------------- */

                .forbidden-icon {

                    width: 64px;
                    height: 64px;

                    margin: 0 auto 22px;

                    display: flex;
                    align-items: center;
                    justify-content: center;

                    border-radius: 50%;

                    background: #f4f2ff;

                    border: 1px solid #e5e1ff;

                    color: #4a42df;

                    font-size: 27px;
                    font-weight: 700;
                }


                /* --------------------------------
                   SECURITY LABEL
                -------------------------------- */

                .security-label {

                    display: inline-flex;

                    align-items: center;
                    justify-content: center;

                    gap: 8px;

                    margin-bottom: 18px;

                    padding: 7px 12px;

                    border-radius: 20px;

                    background: #f8f7fa;

                    border: 1px solid #e8e5ec;

                    color: #77727f;

                    font-size: 10px;

                    font-weight: 700;

                    letter-spacing: 1.4px;
                }


                .security-dot {

                    width: 6px;
                    height: 6px;

                    border-radius: 50%;

                    background: #c0392b;
                }


                /* --------------------------------
                   ERROR CODE
                -------------------------------- */

                .error-code {

                    margin: 0;

                    font-size: 86px;

                    line-height: 0.95;

                    font-weight: 800;

                    letter-spacing: -5px;

                    color: #292633;
                }


                /* --------------------------------
                   TITLE
                -------------------------------- */

                .error-title {

                    margin: 12px 0 0;

                    font-size: 25px;

                    line-height: 1.3;

                    font-weight: 700;

                    letter-spacing: -0.4px;

                    color: #25222d;
                }


                /* --------------------------------
                   DESCRIPTION
                -------------------------------- */

                .error-description {

                    max-width: 440px;

                    margin: 15px auto 0;

                    font-size: 14px;

                    line-height: 1.7;

                    color: #77727f;
                }


                /* --------------------------------
                   NOTICE
                -------------------------------- */

                .access-notice {

                    margin: 28px 0;

                    padding: 15px 18px;

                    border: 1px solid #eee9d9;

                    border-left: 3px solid #c58b22;

                    border-radius: 8px;

                    background: #fffcf4;

                    color: #66583d;

                    font-size: 12px;

                    line-height: 1.6;

                    text-align: left;
                }


                .access-notice strong {

                    display: block;

                    margin-bottom: 3px;

                    color: #51452f;

                    font-size: 12px;
                }


                /* --------------------------------
                   BUTTONS
                -------------------------------- */

                .forbidden-actions {

                    display: flex;

                    justify-content: center;

                    margin-top: 4px;
                }


                .return-button {

                    display: inline-flex;

                    align-items: center;
                    justify-content: center;

                    min-height: 42px;

                    padding: 0 22px;

                    border: 1px solid #29245f;

                    border-radius: 8px;

                    background:
                        linear-gradient(
                            135deg,
                            #29245f,
                            #4a42df
                        );

                    color: #ffffff;

                    font-size: 12px;

                    font-weight: 700;

                    letter-spacing: 0.4px;

                    text-decoration: none;

                    box-shadow:
                        0 7px 18px rgba(74, 66, 223, 0.18);

                    transition:
                        transform 0.2s ease,
                        box-shadow 0.2s ease;
                }


                .return-button:hover {

                    color: #ffffff;

                    transform: translateY(-1px);

                    box-shadow:
                        0 10px 22px rgba(74, 66, 223, 0.24);
                }


                /* --------------------------------
                   FOOTER
                -------------------------------- */

                .security-footer {

                    display: flex;

                    justify-content: center;

                    gap: 10px;

                    margin-top: 30px;

                    padding-top: 18px;

                    border-top: 1px solid #eeeaf1;

                    color: #a09ba6;

                    font-size: 9px;

                    font-weight: 600;

                    letter-spacing: 1px;
                }


                .security-footer .separator {

                    color: #d0ccd4;
                }


                /* --------------------------------
                   MOBILE
                -------------------------------- */

                @media (max-width: 600px) {

                    body {
                        padding: 16px;
                    }


                    .forbidden-content {
                        padding: 35px 24px 30px;
                    }


                    .forbidden-icon {
                        width: 58px;
                        height: 58px;

                        font-size: 24px;
                    }


                    .error-code {
                        font-size: 70px;

                        letter-spacing: -4px;
                    }


                    .error-title {
                        font-size: 22px;
                    }


                    .error-description {
                        font-size: 13px;
                    }


                    .return-button {
                        width: 100%;
                    }


                    .security-footer {
                        flex-direction: column;

                        gap: 5px;
                    }


                    .security-footer .separator {
                        display: none;
                    }

                }

            </style>

        </head>


        <body>


            <main class="forbidden-page">

                <section class="forbidden-card">


                    <div class="forbidden-top-line"></div>


                    <div class="forbidden-content">


                        <!-- Security Icon -->

                        <div class="forbidden-icon">
                            !
                        </div>


                        <!-- Security Label -->

                        <div class="security-label">

                            <span class="security-dot"></span>

                            SECURITY NOTICE

                        </div>


                        <!-- Error -->

                        <h1 class="error-code">
                            403
                        </h1>


                        <h2 class="error-title">
                            Access Forbidden
                        </h2>


                        <p class="error-description">

                            You are not authorized to access this page.
                            Please return to your authorized area.

                        </p>


                        <!-- Notice -->

                        <div class="access-notice">

                            <strong>
                                Restricted Access
                            </strong>

                            This area is restricted. If you believe you
                            should have access to this page, please contact
                            your administrator.

                        </div>


                        <!-- Action -->

                        <div class="forbidden-actions">

                            <a
                                href="/Employee_App/views/auth/employees/profile.php"
                                class="return-button"
                            >
                                RETURN TO MY PROFILE
                            </a>

                        </div>


                        <!-- Footer -->

                        <div class="security-footer">

                            <span>
                                HTTP 403
                            </span>

                            <span class="separator">
                                •
                            </span>

                            <span>
                                ACCESS DENIED
                            </span>

                        </div>


                    </div>

                </section>

            </main>


        </body>

        </html>

        <?php
    }
}