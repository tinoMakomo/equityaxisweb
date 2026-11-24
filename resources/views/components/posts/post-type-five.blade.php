<div class="post-type-five">
    <div class="row">
        <div class="col-md-4">
            <a href="{{ Helper::getRouteForPost($post) }}">
                <div class="featured"
                    style="background: no-repeat center/cover url({{ $post->thumbnailSmall() }})">
                </div>
            </a>
        </div>
        <div class="col-md-8">
            <h5><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h5>
            <a class="text-dark" href="{{ Helper::getRouteForPost($post) }}">
                <p class="mb-0 line-clamp-2">
                    {{ $post->excerpt }}
                </p>
            </a>
            <span class="text-muted small mb-3 d-block">{{ \Helper::getFormattedPostDate($post) }}</span>
        </div>
    </div>
</div>
