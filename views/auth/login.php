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
    <style>
        :root {
            --bg: #f5f7fb;
            --panel: #ffffff;
            --panel-border: #e5e7eb;
            --primary: #1f2937;
            --primary-soft: #e5e7eb;
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

        .login-shell {
            width: min(100%, 440px);
        }

        .login-card {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 2rem 1.75rem;
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
            background: linear-gradient(135deg, #111827 0%, #4f46e5 100%);
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .brand-title {
            font-size: 1.8rem;
            margin: 0;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--text);
        }

        .login-header {
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

        .login-header h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--text);
        }

        .login-header p {
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
            color: var(--text);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            height: 52px;
            padding: 0.8rem 0.95rem;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            background: #fff;
            font-size: 0.96rem;
            color: var(--text);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: rgba(79, 70, 229, 0.85);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.12);
            outline: none;
        }

        .btn-login {
            width: 100%;
            margin-top: 0.7rem;
            border: none;
            border-radius: 12px;
            padding: 0.9rem 1rem;
            background: linear-gradient(135deg, #111827 0%, #4f46e5 100%);
            color: #fff;
            font-size: 0.98rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 12px 22px rgba(79, 70, 229, 0.18);
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(79, 70, 229, 0.24);
            color: #fff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        @media (max-width: 575.98px) {
            .login-card {
                padding: 1.5rem 1.1rem;
            }

            .brand-title {
                font-size: 1.6rem;
            }

            .login-header h3 {
                font-size: 1.75rem;
            }
        }
    </style>
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

            <form method="POST" action="../../public/login.php">
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

                <button type="submit" class="btn btn-login">Sign In</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>