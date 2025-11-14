<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glassmorphism Login Form</title>
    <link rel="stylesheet" href="{{ asset('css/adminlogin.css') }}">
</head>
<body>

    <div class="login-container">
        <div class="login-card">

            <!-- ⭐ Logo Block ⭐ -->
            <div class="text-center" style="margin-bottom: 10px;">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Logo" 
                     style="width:60px; height:60px; border-radius:50%;">
            </div>

            <div class="login-header">
                <h2>ADMIN LOGIN</h2>
                <p>Log in to your account</p>
            </div>
            
            <form class="login-form" id="loginForm" novalidate>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required autocomplete="email">
                        <label for="email">Email Address</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <span class="eye-icon"></span>
                        </button>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-options">
                    <label class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember">
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

    <script src="{{ asset('js/adminlogin.js') }}"></script>

</body>
</html>
