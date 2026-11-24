<nav class="navbar d-block navbar-mobile-ad d-md-none py-0 mb-2 sticky-top">
    <h2 class="text-center mb-0">
        @include('includes.header-ad')
    </h2>
</nav>
<nav class="navbar navbar-main navbar-expand-xs navbar-light d-block  sticky-md-top">
    <div class="container-fluid navbar-2">
        <a href="/" class="pb-2 pt-1 pb-2 py-md-0"> <img class="header-logo"
                src="{{ asset('images/logos/logo.png') }}" alt="Equity Axis Sqaure logo">
        </a>
        <div class="d-none d-md-block">
            <h2 class="text-center py-1 mb-0 mx-4">
                @include('includes.header-ad')
            </h2>
        </div>
        <div class="d-flex">
            <div class="navbar-w-40 text-end">
                <a class="text-dark cursor-pointer" data-bs-toggle="collapse"
                    data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                    aria-expanded="false" aria-label="Toggle Search">
                    <i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
            <div class="navbar-w-40 text-end">
                <a class="text-dark cursor-pointer side-bar-toggle">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>

        </div>
    </div>
</nav>
<div class="collapse" id="navbarToggleExternalContent">
    <div class="search-widget">
        <div class="container-fluid">
            <form id="search-form" action="{{ route('search') }}" method="get">
                <input value="{{ $search ?? '' }}" type="search" name="q" required class="search-field"
                    id="searh-field" placeholder="Search the EA">
                <input type="button" value="Search" class="search-btn">
                <a href="#" class="search-close" data-bs-toggle="collapse"
                    data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                    aria-expanded="false" aria-label="Toggle Searcj"></a>
            </form>
        </div>
    </div>
</div>
