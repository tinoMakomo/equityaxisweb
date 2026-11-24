<div class="row mt-3">
    <div class="col-12">
        <h4>Trending Stories</h4>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-8">
        @if ($posts->count() >= 15)
            <x-posts.post-type-four :post="$posts->get(14)" />
        @endif
        <div class="row mt-3">
            @if ($posts->count() >= 16)
                @foreach ($posts->slice(15, 2) as $post)
                    <div class="col-md-6 col-6">
                        <div class="thick-divider mb-1"></div>
                        <x-posts.post-type-six :post="$post" />
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row mt-1">
            @if ($posts->count() >= 18)
                @foreach ($posts->slice(17, 6) as $post)
                    <div class="col-md-6 col-6">
                        <x-posts.post-type-seven :post="$post" />
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-md-4">
        @if ($posts->count() >= 24)
            <div class="row">
                @foreach ($posts->slice(23, 3) as $post)
                    <div class="col-md-12 col-6">
                        <x-posts.post-type-five :post="$post" />
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ Helper::getAdUrl('article_aside') }}">
            <img src="{{ Helper::getAd('article_aside') }}" class="img ad mb-3 w-100">
        </a>
    </div>
</div>
