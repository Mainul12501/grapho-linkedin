<meta name="author" content="Grapho" />
<!-- Favicon -->
<link rel="icon" href="{{ isset($siteSetting) ? asset($siteSetting->site_icon) : asset('/frontend/employer/images/Logo icon.png') }}" type="image/x-icon" />
<!-- Google Font: Geist -->
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap"
      rel="stylesheet" />
<!-- Bootstrap CSS -->
{{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />--}}
<link rel="stylesheet" href="{{ asset('/') }}common-assets/css/bootstrap-5.3.6.min.css" />

<!-- Toastr Css -->
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
<link rel="stylesheet" href="{{ asset('/') }}common-assets/css/toastr-2.1.3.min.css" />
<!-- Sweet Alert -->
{{--<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet" />--}}
<link rel="stylesheet" href="{{ asset('/') }}common-assets/css/sweetalert2-11.7.3.min.css" />

<!-- Helper CSS -->
<link rel="stylesheet" href="{{ asset('/') }}common-assets/css/helper.min.css" />

<!-- Your Custom CSS -->
<link rel="stylesheet" href="{{ asset('/') }}frontend/employer/style.css" />

{{--    font--}}
<style>
    h1,h2,h3,h4,h5,h6 {
        font-family: "Geist", sans-serif;
        font-optical-sizing: auto;
        font-weight: 600;
        font-size: 16px;
    }
    p,span,label,span,button {
        font-family: "Geist", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-size: 13px;
    }
    @media screen and (max-width: 768px) {
        body {padding-bottom: 85px!important;}
    }
</style>

{{--    drawer mobile menu--}}
<style>
    /* Bottom Navigation */
    .employer-mobile-menu .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #ffffff;
        display: flex;
        justify-content: space-around;
        padding: 8px 0;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        border-top: 1px solid #e0e0e0;
    }

    .employer-mobile-menu .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        color: #666;
        text-decoration: none;
        font-size: 11px;
        padding: 8px 12px;
        transition: all 0.3s ease;
        position: relative;
    }

    .employer-mobile-menu .nav-link img {
        height: 22px;
        width: 22px;
        object-fit: contain;
        opacity: 0.6;
        transition: opacity 0.3s ease;
    }

    .employer-mobile-menu .nav-link.active {
        color: #FFC107;
        font-weight: 600;
    }

    .employer-mobile-menu .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 3px;
        background: #FFC107;
        border-radius: 3px 3px 0 0;
    }

    .employer-mobile-menu .nav-link.active img {
        opacity: 1;
    }

    /* Drawer Overlay */
    .employer-mobile-menu .drawer-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1040;
        backdrop-filter: blur(2px);
    }

    .employer-mobile-menu .drawer-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* Side Drawer */
    .employer-mobile-menu .side-drawer {
        position: fixed;
        top: 0;
        right: -100%;
        width: 250px;
        max-width: 85vw;
        height: 100vh;
        background: #ffffff;
        box-shadow: -5px 0 25px rgba(0,0,0,0.2);
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1050;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .employer-mobile-menu .side-drawer.show {
        right: 0;
    }

    /* Drawer Header */
    .employer-mobile-menu .drawer-header {
        padding: 24px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .employer-mobile-menu .drawer-title {
        color: #ffffff;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    .employer-mobile-menu .drawer-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #ffffff;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .employer-mobile-menu .drawer-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    /* Drawer Menu */
    .employer-mobile-menu .drawer-menu {
        padding: 12px 0;
        flex: 1;
    }

    .employer-mobile-menu .drawer-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 24px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .employer-mobile-menu .drawer-item:hover {
        background: #f8f9fa;
        border-left-color: #FFC107;
        color: #FFC107;
    }

    .employer-mobile-menu .drawer-item i {
        width: 24px;
        font-size: 18px;
        text-align: center;
        color: #667eea;
    }

    .employer-mobile-menu .drawer-item:hover i {
        color: #FFC107;
    }

    .employer-mobile-menu .drawer-divider {
        height: 1px;
        background: #e0e0e0;
        margin: 12px 24px;
    }

    .employer-mobile-menu .drawer-item.logout {
        color: #d32f2f;
    }

    .employer-mobile-menu .drawer-item.logout i {
        color: #d32f2f;
    }
</style>

@yield('style')
@stack('style')
