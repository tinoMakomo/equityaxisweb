<div class="hero">
    {{-- display on desktop --}}
    <div class="hero-column-one desktop">
        @if ($posts->count() >= 1)
            <x-posts.post-type-one :post="$posts->get(0)" />
        @endif
        @if ($posts->count() >= 2)
            <x-posts.post-type-one :post="$posts->get(1)" />
        @endif
    </div>
    <div class="hero-column-two">
        @if ($posts->count() >= 1)
            <x-posts.post-type-two :post="$editorsPick ?? $posts->get(0)" />
        @endif
    </div>
    <div class="hero-column-three">
        <div class="fast-news">
            <h4>Fast News</h4>
            @if ($posts->count() >= 3)
                @foreach ($posts->slice(2, 8) as $post)
                    <x-posts.fast-news :post="$post" />
                @endforeach
            @endif
        </div>
    </div>

    {{-- display on mobile --}}
    <div class="hero-column-one mt-5 mobile">
        <div class="row">
            @if ($posts->count() >= 1)
                <div class="col-6">
                    <x-posts.post-type-one :post="$posts->get(0)" />
                </div>
            @endif
            @if ($posts->count() >= 2)
                <div class="col-6">
                    <x-posts.post-type-one :post="$posts->get(1)" />
                </div>
            @endif
        </div>
    </div>
</div>
