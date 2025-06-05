<meta name="author" content="Grapho" />
<!-- Favicon -->
<link rel="icon" href="{{ isset($siteSetting) ? asset($siteSetting->site_icon) : asset('/') }}frontend/employer/images/Logo icon.png" type="image/x-icon" />
<!-- Google Font: Geist -->
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap"
      rel="stylesheet" />
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Toastr Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Sweet Alert -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet" />

<!-- Your Custom CSS -->
<link rel="stylesheet" href="{{ asset('/') }}frontend/employer/style.css" />

@yield('style')
@stack('style')
