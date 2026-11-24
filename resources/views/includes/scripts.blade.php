<script defer src="{{ asset('vendor/jquery/jquery-3.6.0.min.js') }}"></script>
<script defer src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<script defer src="{{ asset('js/script.js') . '?v=' . (config('app.js_update') ?: @filemtime(public_path('js/script.js'))) }}"></script>
