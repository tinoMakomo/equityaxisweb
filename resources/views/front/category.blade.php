@extends('layouts.public')

@section('title', $category->name)
@section('meta_description', 'Equity Axis coverage on ' . $category->name)

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <h2>{{ $category->name }}</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-8">
            @if ($posts->count() >= 1)
                <x-posts.post-type-four :post="$posts->get(0)" />
            @endif
            <div class="row mt-3">
                @if ($posts->count() >= 2)
                    @foreach ($posts->slice(1, 2) as $post)
                        <div class="col-md-6 col-6">
                            <div class="thick-divider mb-1"></div>
                            <x-posts.post-type-six :post="$post" />
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="row mt-1">
                @if ($posts->count() >= 4)
                    @foreach ($posts->slice(3, 4) as $post)
                        <div class="col-md-6 col-6">
                            <x-posts.post-type-seven :post="$post" />
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-4">
            @if ($posts->count() >= 8)
                <div class="row">
                    @foreach ($posts->slice(7, 4) as $post)
                        <div class="col-md-12 col-6">
                            <x-posts.post-type-five :post="$post" />
                        </div>
                    @endforeach
                </div>
            @endif

            <a href="{{ Helper::getAdUrl('article_aside') }}">
                <img src="{{ Helper::getAd('article_aside') }}" class="img ad mb-md-2" style="width: 100%">
            </a>

        </div>
    </div>
    <div class="row mt-3">
        @if ($posts->count() >= 12)
            @foreach ($posts->slice(11, 8) as $post)
                <div class="col-md-3 col-6">
                    <x-posts.post-type-three :post="$post" />
                </div>
            @endforeach
        @endif
    </div>

    <div class="row mt-3">
        <div class="col-12">
            {{ $posts->links() }}
        </div>
    </div>

@endsection
