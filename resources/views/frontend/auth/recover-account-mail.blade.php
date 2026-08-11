<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Recovery</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto my-5 p-4 border">
                <h2 class="mb-4">Account Recovery</h2>
                <p>Dear {{ $user->name ?? 'User' }},</p>
                <p>We received a request to recover your account. If it was you, please recover with the following code:</p>
                <p class="text-center border-1 px-4 py-3">{{ $otp }}</p>
                <p>If you did not request this, please ignore this email.</p>
                <p>Best regards,<br>Like Wise Bd</p>
            </div>
        </div>
    </div>
</section>

</body>
</html>
