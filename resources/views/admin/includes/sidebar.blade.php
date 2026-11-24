<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin_dashboard') }}" class="brand-link">
        <img src="{{ asset('images/logos/logo-square-white.png') }}" alt="EA Logo" class="brand-logo">
        <span class="brand-text font-weight-light">Equity Axis</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fa fa-user"></i>
            </div>
            <div class="info">
                <a href="{{ route('admin_profile') }}" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar {{ optional(auth()->user()->preferences)->flat_nav_bar_set == 1 ? 'nav-flat' : '' }} flex-column nav-child-indent"
                data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin_dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/admin_posts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/admin_posts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Posts
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin_posts.create') }}" class="nav-link {{ Request::is('admin/admin_posts/create') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Create Post</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin_posts.index') }}" class="nav-link {{ Request::is('admin/admin_posts') ? 'active' : '' }}">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Posts List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                    <li class="nav-item {{ Request::is('admin/admin_categories*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('admin/admin_categories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>
                                Categories
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin_categories.create') }}" class="nav-link {{ Request::is('admin/admin_categories/create') ? 'active' : '' }}">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>Create Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin_categories.index') }}" class="nav-link {{ Request::is('admin/admin_categories') ? 'active' : '' }}">
                                    <i class="fa fa-list nav-icon"></i>
                                    <p>Categories List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if (auth()->user()->isAdmin())
                        <li class="nav-item {{ Request::is('admin/admin_ads*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('admin/admin_ads*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Ads
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin_ads.create') }}" class="nav-link {{ Request::is('admin/admin_ads/create') ? 'active' : '' }}">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>Create Ad</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin_ads.index') }}" class="nav-link {{ Request::is('admin/admin_ads') ? 'active' : '' }}">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Ads List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ Request::is('admin/admin_users*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('admin/admin_users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Users
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin_users.create') }}" class="nav-link {{ Request::is('admin/admin_users/create') ? 'active' : '' }}">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>Create User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin_users.index') }}" class="nav-link {{ Request::is('admin/admin_users') ? 'active' : '' }}">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Users List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin_subscribers.index') }}"
                                class="nav-link {{ Request::is('admin/admin_subscribers*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope-open-text"></i>
                                <p>Subscribers</p>
                            </a>
                        </li>
                    @endif
                @endif

                <li class="nav-header">MISCELLANEOUS</li>
                <li class="nav-item">
                    <a href="{{ route('admin_preferences') }}" class="nav-link {{ Request::is('admin/preferences') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Preferences</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin_profile') }}" class="nav-link {{ Request::is('admin/profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://analytics.equityaxis.net" target="_blank" rel="noopener noreferrer" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Analytics</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#logout-modal" class="nav-link">
                        <i class="nav-icon fa fa-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
