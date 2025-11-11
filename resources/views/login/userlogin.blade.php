<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glassmorphism User Login</title>
    <link rel="stylesheet" href="{{ asset('css/userlogin.css') }}">
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>USER LOGIN</h2>
                <p>Access your user dashboard</p>
            </div>
            
            <form class="login-form" id="userLoginForm" novalidate>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required autocomplete="email">
                        <label for="email">Email Address</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="userid" name="userid" required autocomplete="off">
                        <label for="userid">User ID</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="useridError"></span>
                </div>

                <div class="form-options">
                    <label class="remember-wrapper">
                        <input type="checkbox" id="rememberUser" name="rememberUser">
                        <span class="checkbox-label">
                            <span class="checkmark"></span>
                            Remember me
                        </span>
                    </label>
                </div>

                <button type="submit" class="login-btn btn">
                    <span class="btn-text">Login In</span>
                    <span class="btn-loader"></span>
                </button>
            </form>

        </div>
    </div>

    <script src="{{ asset('js/userlogin.js') }}"></script>
</body>
</html>