@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @isset($stats)
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ number_format($stats['published_posts'] ?? 0) }}</h3>
                                    <p>Published Posts</p>
                                </div>
                                <div class="icon"><i class="fas fa-newspaper"></i></div>
                                <a href="{{ route('admin_posts.index') }}" class="small-box-footer">
                                    Manage Posts <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ number_format($stats['draft_posts'] ?? 0) }}</h3>
                                    <p>Draft Posts</p>
                                </div>
                                <div class="icon"><i class="fas fa-edit"></i></div>
                                <a href="{{ route('admin_posts.create') }}" class="small-box-footer">
                                    Create Post <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ number_format($stats['categories'] ?? 0) }}</h3>
                                    <p>Categories</p>
                                </div>
                                <div class="icon"><i class="fas fa-boxes"></i></div>
                                <a href="{{ route('admin_categories.index') }}" class="small-box-footer">
                                    View Categories <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ number_format($stats['subscribers'] ?? 0) }}</h3>
                                    <p>Subscribers</p>
                                </div>
                                <div class="icon"><i class="fas fa-users"></i></div>
                                <a href="{{ route('admin_subscribers.index') }}" class="small-box-footer">
                                    View Subscribers <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endisset

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Site Analytics</h3>
                    </div>
                    <div class="card-body p-0">
                        <iframe
                            src="https://analytics.equityaxis.net/index.php?module=Widgetize&action=iframe&moduleToWidgetize=Dashboard&actionToWidgetize=index&idSite=1&period=day&date=yesterday&token_auth=3750cb50e15db96249f22b7cc2d58eba"
                            loading="lazy"
                            frameborder="0"
                            style="width: 100%; height: calc(100vh - 300px); min-height: 480px;"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
