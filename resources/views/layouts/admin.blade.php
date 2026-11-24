<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EA Admin | {{ $pageTitle ?? 'Dashboard' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @yield('styles-top')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap">
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/custom.css') }}">
    @livewireStyles
    @yield('styles')
</head>

@php
    $prefs = optional(auth()->user()->preferences);
@endphp

<body class="hold-transition sidebar-mini layout-fixed
            {{ $prefs->fixed_header_set == 1 ? 'layout-navbar-fixed' : '' }}
            {{ $prefs->dark_mode_set == 1 ? 'dark-mode' : '' }}
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
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/custom.js') }}"></script>
    @yield('scripts')
</body>

</html>
