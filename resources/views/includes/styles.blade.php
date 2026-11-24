<link rel="stylesheet" href="{{ asset('vendor/owlcarousel/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/owlcarousel/assets/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') . '?v=' . config('app.css_update') }}">

@if (\Helper::isArchive())
    <style>
        :root {
            --ss-primary: #6d4d26;
            --ss-primary-darker: #462701;
        }

        .footer-bottom {
            background: linear-gradient(180deg, var(--ss-primary) 0%, rgb(131 98 42) 52%, rgb(99 61 4) 80%, var(--ss-primary-darker) 100%);
        }
    </style>
@endif
