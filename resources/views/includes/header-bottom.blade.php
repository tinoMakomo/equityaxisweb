<nav class="navbar d-none d-md-block navbar-expand-md header-bottom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between w-100">
            <div class="d-flex">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">HOME</a>
                    @foreach ($parentCategories as $parent)
                        @if ($parent->display_in_navbar)
                            @if ($parent->hasChildren())
                                <a class="nav-link dropdown-toggle {{ Str::contains(Request::url(), 'category/' . $parent->id) ? 'active' : '' }}"
                                    href="{{ route('category', [$parent->id, $parent->slug]) }}"
                                    id="{{ $parent->name }}" role="button"
                                    aria-expanded="false">{{ Str::upper($parent->name) }}</a>
                                <div class="dropdown-menu mega-menu" aria-labelledby="world" id="world-dropdown">
                                    <div class="mega-menu-links">
                                        <ul class="list-unstyled">
                                            <li><a class="mb-2 link" href="#">SECTIONS</a></li>
                                            <div class="row">
                                                <div class="col-6">
                                                    <li><a class="link fw-bold"
                                                            href="{{ route('category', [$parent->id, $parent->slug]) }}"><span>{{ $parent->name }}
                                                                Home</span></a></li>
                                                </div>
                                                @foreach ($parent->children as $child)
                                                    @if ($child->display_in_navbar)
                                                        <div class="col-6">
                                                            <li><a class="link"
                                                                    href="{{ route('category', [$child->id, $child->slug]) }}"><span>{{ $child->name }}</span></a>
                                                            </li>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-content">
                                        <ul class="list-unstyled">
                                            <li><a class="mb-2 link" href="#">MOST READ</a></li>
                                            <div class="row">
                                                <div class="col-12">
                                                    @foreach ($parent->getPosts(6) as $post)
                                                        <li><a class="link"
                                                                href="{{ \Helper::getRouteForPost($post) }}"><i
                                                                    class="fa fa-angle-right" aria-hidden="true"></i>
                                                                <span>{{ $post->title }}</span></a></li>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </ul>
                                    </div>
                                </div>
                            @else
                                <a class="nav-link {{ Str::contains(Request::url(), 'category/' . $parent->id) ? 'active' : '' }}"
                                    href="{{ route('category', [$parent->id, $parent->slug]) }}"
                                    id="{{ $parent->name }}" role="button">{{ Str::upper($parent->name) }}</a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="d-flex">
                <a class="nav-link" href="#">Sign In</a>
                <a class="nav-link btn btn-primary" href="{{ route('subscribe') }}">Subscribe</a>
            </div>
        </div>
    </div>
</nav>
