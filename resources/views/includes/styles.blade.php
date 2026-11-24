<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&display=swap">
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') . '?v=' . config('app.css_update') . '.' . @filemtime(public_path('css/style.css')) }}">
<style>
    .featured { position: relative; overflow: hidden; }
    .featured > img { width: 100%; height: 100%; object-fit: cover; display: block; }
</style>

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
