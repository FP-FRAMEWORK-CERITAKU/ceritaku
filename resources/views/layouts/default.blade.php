 <!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: SidebarHead-->

<head>
    @include('layouts.partials.meta')
    @stack('head-meta')

    <title>Ceritaku</title>
    {{--<link rel="apple-touch-icon" href="{{ $siteSetting->photo_favicon }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->photo_favicon }}">--}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    @stack('css-vendor')
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">
    @stack('css-theme')
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.min.css') }}">
    @stack('css-page')
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    @stack('css-custom')
    <!-- END: Custom CSS-->
</head>
<!-- END: SidebarHead-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="">

<!-- BEGIN: Header-->
<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">

        <ul class="nav navbar-nav align-items-center ms-auto">
            {{--<li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a><a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a><a class="dropdown-item" href="#" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
            </li>--}}
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link nav-link-style">
                    <i class="ficon" data-feather="moon"></i>
                </a>
            </li>

            {{--<livewire:components.navbar.notification :wire:key="'components.navbar.notification'" />--}}
            @include('layouts.partials.navbar')
        </ul>
    </div>
</nav>
<!-- END: Header-->


<!-- BEGIN: Main SidebarMenu-->
@include('layouts.partials.sidebar')
<!-- END: Main SidebarMenu-->

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-body">
            @if(!empty($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </div>
    </div>
</div>
<!-- END: Content-->

<!-- BEGIN: Customizer-->
<div class="customizer d-none d-md-block">
    <a class="customizer-toggle d-flex align-items-center justify-content-center" href="#">
        <i class="spinner" data-feather="settings"></i>
    </a>
    <div class="customizer-content">
        <!-- Customizer header -->
        <div class="customizer-header px-2 pt-1 pb-0 position-relative">
            <h4 class="mb-0">Theme Customizer</h4>
            <p class="m-0">Customize & Preview in Real Time</p>

            <a class="customizer-close" href="#"><i data-feather="x"></i></a>
        </div>

        <hr />

        <!-- Styling & Text Direction -->
        <div class="customizer-styling-direction px-2">
            <p class="fw-bold">Skin</p>
            <div class="d-flex">
                <div class="form-check me-1">
                    <input
                        type="radio"
                        id="skinlight"
                        name="skinradio"
                        class="form-check-input layout-name"
                        checked
                        data-layout=""
                    />
                    <label class="form-check-label" for="skinlight">Light</label>
                </div>
                <div class="form-check me-1">
                    <input
                        type="radio"
                        id="skinbordered"
                        name="skinradio"
                        class="form-check-input layout-name"
                        data-layout="bordered-layout"
                    />
                    <label class="form-check-label" for="skinbordered">Bordered</label>
                </div>
                <div class="form-check me-1">
                    <input
                        type="radio"
                        id="skindark"
                        name="skinradio"
                        class="form-check-input layout-name"
                        data-layout="dark-layout"
                    />
                    <label class="form-check-label" for="skindark">Dark</label>
                </div>
                <div class="form-check">
                    <input
                        type="radio"
                        id="skinsemidark"
                        name="skinradio"
                        class="form-check-input layout-name"
                        data-layout="semi-dark-layout"
                    />
                    <label class="form-check-label" for="skinsemidark">Semi Dark</label>
                </div>
            </div>
        </div>

        <hr />

        <!-- Menu -->
        <div class="customizer-menu px-2">
            <div id="customizer-menu-collapsible" class="d-flex">
                <p class="fw-bold me-auto m-0">Menu Collapsed</p>
                <div class="form-check form-check-primary form-switch">
                    <input type="checkbox" class="form-check-input" id="collapse-sidebar-switch" />
                    <label class="form-check-label" for="collapse-sidebar-switch"></label>
                </div>
            </div>
        </div>
        <hr />

        <!-- Layout Width -->
        <div class="customizer-footer px-2">
            <p class="fw-bold">Layout Width</p>
            <div class="d-flex">
                <div class="form-check me-1">
                    <input type="radio" id="layout-width-full" name="layoutWidth" class="form-check-input" checked />
                    <label class="form-check-label" for="layout-width-full">Full Width</label>
                </div>
                <div class="form-check me-1">
                    <input type="radio" id="layout-width-boxed" name="layoutWidth" class="form-check-input" />
                    <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                </div>
            </div>
        </div>
        <hr />

        <!-- Navbar -->
        <div class="customizer-navbar px-2">
            <div id="customizer-navbar-colors">
                <p class="fw-bold">Navbar Color</p>
                <ul class="list-inline unstyled-list">
                    <li class="color-box bg-white border selected" data-navbar-default=""></li>
                    <li class="color-box bg-primary" data-navbar-color="bg-primary"></li>
                    <li class="color-box bg-secondary" data-navbar-color="bg-secondary"></li>
                    <li class="color-box bg-success" data-navbar-color="bg-success"></li>
                    <li class="color-box bg-danger" data-navbar-color="bg-danger"></li>
                    <li class="color-box bg-info" data-navbar-color="bg-info"></li>
                    <li class="color-box bg-warning" data-navbar-color="bg-warning"></li>
                    <li class="color-box bg-dark" data-navbar-color="bg-dark"></li>
                </ul>
            </div>

            <p class="navbar-type-text fw-bold">Navbar Type</p>
            <div class="d-flex">
                <div class="form-check me-1">
                    <input type="radio" id="nav-type-floating" name="navType" class="form-check-input" checked />
                    <label class="form-check-label" for="nav-type-floating">Floating</label>
                </div>
                <div class="form-check me-1">
                    <input type="radio" id="nav-type-sticky" name="navType" class="form-check-input" />
                    <label class="form-check-label" for="nav-type-sticky">Sticky</label>
                </div>
                <div class="form-check me-1">
                    <input type="radio" id="nav-type-static" name="navType" class="form-check-input" />
                    <label class="form-check-label" for="nav-type-static">Static</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="nav-type-hidden" name="navType" class="form-check-input" />
                    <label class="form-check-label" for="nav-type-hidden">Hidden</label>
                </div>
            </div>
        </div>
        <hr />

        <!-- Footer -->
        <div class="customizer-footer px-2">
            <p class="fw-bold">Footer Type</p>
            <div class="d-flex">
                <div class="form-check me-1">
                    <input type="radio" id="footer-type-sticky" name="footerType" class="form-check-input" />
                    <label class="form-check-label" for="footer-type-sticky">Sticky</label>
                </div>
                <div class="form-check me-1">
                    <input type="radio" id="footer-type-static" name="footerType" class="form-check-input" checked />
                    <label class="form-check-label" for="footer-type-static">Static</label>
                </div>
                <div class="form-check me-1">
                    <input type="radio" id="footer-type-hidden" name="footerType" class="form-check-input" />
                    <label class="form-check-label" for="footer-type-hidden">Hidden</label>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End: Customizer-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    @include('layouts.partials.footer')
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
@stack('js-vendor')
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
@stack('js-page-vendor')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
@stack('js-theme')
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
@stack('js-page')
<script>
    const __debounce = (callback, wait) => {
        let timeoutId = null;
        return (...args) => {
            window.clearTimeout(timeoutId);
            timeoutId = window.setTimeout(() => {
                callback.apply(null, args);
            }, wait);
        };
    };

    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
