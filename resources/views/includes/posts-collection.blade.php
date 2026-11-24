<div class="row mt-3">
    <div class="col-md-8">
        @foreach ($posts as $post)
            <x-posts.post-type-nine :post="$post" />
            @if ($loop->iteration % 4 === 0 && !$loop->last)
                @include('includes.adsense-unit', ['type' => 'in-feed'])
            @endif
        @endforeach

        <div class="my-5">
            {{ $posts->links() }}
        </div>

    </div>
    <div class="col-md-4">
        <div class="w-100 sticky-md-top search-sidebar">
            <div class="thick-divider mb-1"></div>
            <a href="{{ Helper::getAdUrl('article_aside') }}">
                <img src="{{ Helper::getAd('article_aside') }}" alt="Advertisement" loading="lazy" decoding="async" class="img ad mb-3 w-100">
            </a>
        </div>
    </div>
</div>

@if ($topPosts->count())
    <div class="row mt-3">
        <div class="col-md-12">
            {{-- <a href="{{ Helper::getAdUrl('footer') }}">
                <img src="{{ Helper::getAd('footer') }}" class="img ad mb-3 w-100">
            </a> --}}
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
        </div>
    </div>
@endif
