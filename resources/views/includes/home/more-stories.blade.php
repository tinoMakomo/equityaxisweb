<div class="row mt-3">
    <div class="col-12">
        <h4>More Stories</h4>
    </div>
</div>
<div class="row mt-3">
    @if ($posts->count() >= 27)
        @foreach ($posts->slice(26, 4) as $post)
            <div class="col-md-3 col-6">
                <x-posts.post-type-three :post="$post" />
            </div>
        @endforeach
    @endif
    @if ($posts->count() >= 31)
        @foreach ($posts->slice(30, 4) as $post)
            <div class="col-md-3 col-6">
                <x-posts.post-type-three :post="$post" />
            </div>
        @endforeach
    @endif
</div>
