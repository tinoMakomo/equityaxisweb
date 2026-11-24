<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EA Admin | {{ $pageTitle ?? 'Dashboard' }}</title>
    @yield('styles-top')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/custom.css') }}">
    @livewireStyles
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed
            {{ auth()->user()->preferences->fixed_header_set == 1? 'layout-navbar-fixed':'' }}
            {{ auth()->user()->preferences->dark_mode_set == 1? 'dark-mode':'' }}
        ">
    <div class="wrapper">
        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')
        @yield('content')
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @include('admin.includes.modals')
    @livewireScripts
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
    <script src="{{ asset('admin/dist/js/custom.js') }}"></script>
    @yield('scripts')
</body>

</html>
