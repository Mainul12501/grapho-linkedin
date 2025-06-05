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
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (Login Style) -->
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card shadow signupCard">
    <a href="login.html"><img  src="{{ asset('/') }}frontend/employee/images/authentication images/Compnay logo.png" alt="" class="signupLogo w-25"></a>
    <h4>Sign up today</h4>
    <p>Hiring talents for your company? or Looking for opportunities?</p>

    <div class="userCard">
        <span class="">Sign up as-</span>
        <div>
            <a href="{{ route('auth.user-registration-page', ['user' => 'Employer']) }}" class="userSelectOption mb-3">
                <div class="row d-flex align-items-center w-100">
                    <div class="col-2  iconWrapper">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/employeeIcon.png" alt="" class="userSelectOptionIcon">
                    </div>
                    <div class="col-9">
                        <h5>Employer</h5>
                        <p>Looking to scale your team.</p>
                    </div>
                    <div class="col-1">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/arrow-right 1.png" alt="" class="arrowIcon">
                    </div>
                </div>
            </a>

            <a href="{{ route('auth.user-registration-page', ['user' => 'Employee']) }}" class="userSelectOption">
                <div class="row d-flex align-items-center w-100">
                    <div class="col-2  iconWrapper">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/jobSeekerIcon.png" alt="" class="userSelectOptionIcon">
                    </div>
                    <div class="col-9">
                        <h5>Job-seeker</h5>
                        <p>Looking for job opportunities.</p>
                    </div>
                    <div class="col-1">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/arrow-right 1.png" alt="" class="arrowIcon">
                    </div>
                </div>
            </a>
        </div>
        <div class="mt-4">
            <span class="">Already have an account? <a href="login.html" class="fw-bold text-dark text-decoration-none">Log in</a></span>
        </div>

    </div>

</div>

<!-- Bootstrap 5 JS and Popper.js (Bootstrap 5 no longer needs jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>
