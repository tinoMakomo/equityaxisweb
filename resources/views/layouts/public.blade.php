<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">

    <link href="{{ asset('images/logos/logo-square.png') }}" rel="icon">

    <title>@yield('title', config('app.name') . ' | Financial Insights at your fingertips.')</title>
    <meta name="description" content="@yield('meta_description', 'Equity Axis is a financial media and research firm focused on Zimbabwe & Africa.')">


    @if (Str::contains(Request::url(), '/post/') && isset($post))
	<link rel="canonical" href="{{ Request::url() }}">

        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:title" content="{{ $post->title }} | Equity Axis" />
        <meta property="og:type" content="article" />
        <meta property="og:description" content="{{ $post->excerpt }}" />
        <meta property="og:image" content="{{ $post->featuredImage() }}" />

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:title" content="{{ $post->title }} | Equity Axis">
        <meta property="twitter:description" content="{{ $post->excerpt }}">
        <meta property="twitter:image" content="{{ $post->featuredImage() }}">
        <meta property="twitter:site" content="@EquityAxis">
        <meta name="keywords" content="{{ implode(', ', $post->tags()) }}">

    @else
	<link rel="canonical" href="{{ Request::url() }}">

        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:title" content="@yield('title', 'Equity Axis | Financial Insights at your fingertips.')" />
        <meta property="og:type" content="website" />
        <meta property="og:description"
            content="@yield('meta_description', 'Equity Axis is a financial media and research firm focused on Zimbabwe & Africa.')" />
        <meta property="og:image" content="{{ asset('images/og-image.png') }}" />

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:title" content="@yield('title', 'Equity Axis | Financial Insights at your fingertips')">
        <meta property="twitter:description"
            content="@yield('meta_description', 'Equity Axis is a financial media and research firm focused on Zimbabwe & Africa.')">
        <meta property="twitter:image" content="{{ asset('images/og-image.png') }}">
        <meta property="twitter:site" content="@EquityAxis">

        <meta name="keywords"
            content="Equity Axis, Finance, Zimbabwe, Research, Media, THE AXiS, Analysis, News, Companies, ZSE, VFEX">
    @endif

    @include('includes.styles')

    @if (config('services.adsense.client'))
        <meta name="google-adsense-account" content="{{ config('services.adsense.client') }}">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ config('services.adsense.client') }}"
            crossorigin="anonymous"></script>
    @endif

    @include('includes.analytics-meta')
</head>

<body>
    <div class="sidebar-backdrop"></div>
    @include('includes.sidebar')
    @include('includes.header-top')
    @include('includes.header')
    @include('includes.header-bottom')
    @isset($showSubCategories)
        @include('includes.header-categories')
    @endisset
    @isset($showBreadcrump)
        @if ($showBreadcrump)
            @include('includes.header-breadcrumb')
        @endif
    @endisset
    <div class="content">
        <div class="container-fluid mt-2">
            @yield('content')
        </div>
    </div>
    @include('includes.footer')
    <button type="button" id="back-to-top" aria-label="Back to top" title="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>
    @include('includes.scripts')
</body>

</html>
