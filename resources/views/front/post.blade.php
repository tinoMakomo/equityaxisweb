@extends('layouts.public')

@section('title', $post->title . ' | Equity Axis' )
@section('meta_description', $post->excerpt)

@section('content')
    <div class="row mt-3">

        <div class="col-md-8 post-type-zero">
            <h2>{{ $post->title }}</h2>
            <h6 class="small mt-3 text-muted mb-3">
                @if ($post->user)
                    By <a href="{{ route('author', [$post->user->id, $post->user->getSlug()]) }}" class="text-primary">{{ $post->user->name }}</a>,
                @else
                    By <span class="text-primary">Equity Axis</span>,
                @endif
                <span class="">{{ \Helper::getFormattedPostDate($post) }}</span>
            </h6>
            <div class="featured my-3" style="background: no-repeat center/cover url({{ $post->featuredImage() }})">
            </div>
            <div class="post-content">
                {!! \Helper::injectInArticleAd($post->body) !!}
            </div>
            <hr>
            @if ($post->tags())
                <div class="post-tags mb-3">
                    <b>Tags</b>
                    @foreach ($post->tags() as $tag)
                        <a href="{{ route('tag', $tag) }}">
                            <span class="tag">{{ $tag }}</span></a>
                    @endforeach
                </div>
            @endif
            <a href="{{ Helper::getAdUrl('in_article') }}">
                <img src="{{ Helper::getAd('in_article') }}" class="img ad w-100 mb-2">
            </a>
        </div>
        <div class="col-md-4">
            <div class="mb-1">
                <span class="btn share-btn me-4">Share</span>
                <a class="btn social-share-btn fab fa-facebook-f"
                    href="https://facebook.com/sharer.php?u={{ Request::url() }}" target="_blank"></a>
                <a class="btn social-share-btn fab fa-twitter"
                    href="https://twitter.com/intent/tweet?text={{ Request::url() }}" target="_blank"></a>
                <a class="btn social-share-btn fab fa-whatsapp" href="whatsapp://send?text={{ Request::url() }}"
                    data-action="share/whatsapp/share" target="_blank"></a>
                <a class="btn social-share-btn fab fa-linkedin-in"
                    href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ $post->title }}"
                    target="_blank"></a>
            </div>
            <div class="subscribe-form">
                <p class="fw-bold">
                    Stay up to date with the latest business, news and insights.
                </p>
                <form method="POST" class="d-flex" action="{{ route('subscribe') }}">
                    @csrf
                    <input type="email" class="px-3" name="email" id="">
                    <input type="submit" value="SUBSCRIBE" class="btn btn-primary">
                </form>
            </div>
            <div class="w-100 sticky-md-top search-sidebar">
                <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a href="{{ Helper::getAdUrl('article_aside') }}">
                                <img src="{{ Helper::getAd('article_aside') }}" class="img ad mb-md-2" style="width: 100%">
                            </a>
                        </div>
                        @if (Helper::hasAd('article_aside_2'))
                            <div class="carousel-item">
                                <a href="{{ Helper::getAdUrl('article_aside_2') }}">
                                    <img src="{{ Helper::getAd('article_aside_2') }}" class="img ad mb-md-2" style="width: 100%">
                                </a>
                            </div>
                        @endif
                        @if (Helper::hasAd('article_aside_3'))
                            <div class="carousel-item">
                                <a href="{{ Helper::getAdUrl('article_aside_3') }}">
                                    <img src="{{ Helper::getAd('article_aside_3') }}" class="img ad mb-md-2" style="width: 100%">
                                </a>
                            </div>
                        @endif
                        @if (Helper::hasAd('article_aside_4'))
                            <div class="carousel-item">
                                <a href="{{ Helper::getAdUrl('article_aside_4') }}">
                                    <img src="{{ Helper::getAd('article_aside_4') }}" class="img ad">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($topPosts->count())
        <div class="row">
            <div class="col-md-12">
                @include('includes.divider')
                <div class="row mt-3">
                    <div class="col-12">
                        <h4>Top Stories</h4>
                    </div>
                </div>
                <div class="row mt-3">
                    @foreach ($topPosts as $relatedPost)
                        <div class="col-md-3 col-6">
                            <x-posts.post-type-three :post="$relatedPost" />
                        </div>
                    @endforeach
                </div>
                {{-- <a href="{{ Helper::getAdUrl('footer') }}">
                    <img src="{{ Helper::getAd('footer') }}" class="img ad w-100 mb-3">
                </a> --}}
            </div>
        </div>
    @endif
@endsection
