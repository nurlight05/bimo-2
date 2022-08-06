<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="admin-themes-lab">
    <meta name="author" content="themes-lab">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <title>@yield('title')</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/ui.css') }}" rel="stylesheet">
    
    {{-- <link href="{{ asset('assets/plugins/metrojs/metrojs.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/maps-amcharts/ammap/ammap.min.css') }}" rel="stylesheet"> --}}
    @livewireStyles
    @stack('styles')
    
    <script src="{{ asset('assets/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>

<body class="fixed-topbar fixed-sidebar theme-sdtl color-default">
    @stack('modals')
    <section>
        @include('includes.sidebar')
        <div class="main-content">
            @include('includes.topbar-menu')
            <div class="page-content page-thin">
                @include('includes.header')
                @yield('content')
                @include('includes.footer')
            </div>
        </div>
    </section>
    @include('includes.search')
    <div class="loader-overlay">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>

    <script src="{{ asset('assets/plugins/jquery/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui-1.11.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/gsap/main-gsap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-cookies/jquery.cookies.min.js') }}"></script>
    <!-- Jquery Cookies, for theme -->
    <script src="{{ asset('assets/plugins/jquery-block-ui/jquery.blockUI.min.js') }}"></script>
    <!-- simulate synchronous behavior when using AJAX -->
    <script src="{{ asset('assets/plugins/translate/jqueryTranslator.min.js') }}"></script>
    <!-- Translate Plugin with JSON data -->
    <script src="{{ asset('assets/plugins/bootbox/bootbox.min.js') }}"></script>
    <!-- Modal with Validation -->
    <script src="{{ asset('assets/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script> <!-- Custom Scrollbar sidebar -->
    <script src="{{ asset('assets/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js') }}"></script> <!-- Show Dropdown on Mouseover -->
    <script src="{{ asset('assets/plugins/charts-sparkline/sparkline.min.js') }}"></script>
    <!-- Charts Sparkline -->
    <script src="{{ asset('assets/plugins/retina/retina.min.js') }}"></script>
    <!-- Retina Display -->
    {{-- <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> --}}
    <!-- Select Inputs -->
    <script src="{{ asset('assets/plugins/icheck/icheck.min.js') }}"></script>
    <!-- Checkbox & Radio Inputs -->
    <script src="{{ asset('assets/plugins/backstretch/backstretch.min.js') }}"></script>
    <!-- Background Image -->
    <script src="{{ asset('assets/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script> <!-- Animated Progress Bar -->
    <script src="{{ asset('assets/js/builder.js') }}"></script> <!-- Theme Builder -->
    <script src="{{ asset('assets/js/sidebar_hover.js') }}"></script> <!-- Sidebar on Hover -->
    <script src="{{ asset('assets/js/application.js') }}"></script>
    <!-- Main Application Script -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- Main Plugin Initialization Script -->
    <script src="{{ asset('assets/js/widgets/notes.js') }}"></script> <!-- Notes Widget -->
    <script src="{{ asset('assets/js/quickview.js') }}"></script> <!-- Chat Script -->
    <script src="{{ asset('assets/js/pages/search.js') }}"></script> <!-- Search Script -->
    <!-- BEGIN PAGE SCRIPT -->
    {{-- <script src="{{ asset('assets/plugins/noty/jquery.noty.packaged.min.js') }}"></script> --}}
    <!-- Notifications -->
    {{-- <script src="{{ asset('assets/plugins/bootstrap-editable/js/bootstrap-editable.min.js') }}"></script> <!-- Inline Edition X-editable -->
    <script src="{{ asset('assets/plugins/bootstrap-context-menu/bootstrap-contextmenu.min.js') }}"></script> <!-- Context Menu -->
    <script src="{{ asset('assets/plugins/multidatepicker/multidatespicker.min.js') }}"></script> <!-- Multi dates Picker -->
    <script src="{{ asset('assets/js/widgets/todo_list.js') }}"></script>
    <script src="{{ asset('assets/plugins/metrojs/metrojs.min.js') }}"></script> --}}
    <!-- Flipping Panel -->
    {{-- <script src="{{ asset('assets/plugins/charts-chartjs/Chart.min.js') }}"></script> --}}
    <!-- ChartJS Chart -->
    {{-- <script src="{{ asset('assets/plugins/charts-highstock/js/highstock.min.js') }}"></script> --}}
    <!-- financial Charts -->
    {{-- <script src="{{ asset('assets/plugins/charts-highstock/js/modules/exporting.min.js') }}"></script> <!-- Financial Charts Export Tool --> --}}
    {{-- <script src="{{ asset('assets/plugins/maps-amcharts/ammap/ammap.min.js') }}"></script> --}}
    <!-- Vector Map -->
    {{-- <script src="{{ asset('assets/plugins/maps-amcharts/ammap/maps/js/worldLow.min.js') }}"></script> <!-- Vector World Map  --> --}}
    {{-- <script src="{{ asset('assets/plugins/maps-amcharts/ammap/themes/black.min.js') }}"></script> <!-- Vector Map Black Theme --> --}}
    {{-- <script src="{{ asset('assets/plugins/skycons/skycons.min.js') }}"></script> --}}
    <!-- Animated Weather Icons -->
    {{-- <script src="{{ asset('assets/plugins/simple-weather/jquery.simpleWeather.js') }}"></script> --}}
    <!-- Weather Plugin -->
    {{-- <script src="{{ asset('assets/js/widgets/widget_weather.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/cke-editor/ckeditor.js') }}"></script> <!-- Advanced HTML Editor --> --}}
    {{-- <script src="{{ asset('assets/plugins/cke-editor/adapters/adapters.min.js') }}"></script> --}}
    
    @livewireScripts
    @stack('scripts')
</body>

</html>