<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name">
    <title>Grapho</title>

    <!-- Favicon -->
    <link rel="icon" href="images/Logo icon.png" type="image/x-icon">

    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (Login Style) -->
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card loginCard">
    <!-- Company Logo -->
    <img src="{{ asset('/') }}frontend/employee/images/authentication images/Compnay logo.png" alt="Company Logo">

    <!-- Call to Action -->
    <p>Hiring or looking for opportunities?</p>

    <!-- Buttons for Log In and Create Account -->
    <a href="{{ route('auth.set-login-role') }}"><button class="btn login">Log in</button></a>
    <a href="{{ route('auth.set-registration-role') }}"><button class="btn createAccount">Create account</button></a>
</div>

<!-- Bootstrap 5 JS and Popper.js (Bootstrap 5 no longer needs jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>
