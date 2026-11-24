<div class="row mt-3">
    <div class="col-12">
        <h4>Top Stories</h4>
    </div>
</div>
<div class="row mt-3">
    @if ($posts->count() >= 11)
        @foreach ($posts->slice(10, 4) as $post)
            <div class="col-md-3 col-6">
                <x-posts.post-type-three :post="$post" />
            </div>
        @endforeach
    @endif
</div>
