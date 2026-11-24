<div class="post-type-three">
    <a href="{{ Helper::getRouteForPost($post) }}">
        <div class="featured" style="background: no-repeat center/cover url({{ $post->thumbnailSmall() }})">
        </div>
    </a>
    <h4><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h4>
    <a class="text-dark" href="{{ Helper::getRouteForPost($post) }}">
        <p class="line-clamp-3">
            {{ $post->excerpt }}
        </p>
    </a>
    <span class="text-muted small">{{ \Helper::getFormattedPostDate($post) }}</span>
</div>
