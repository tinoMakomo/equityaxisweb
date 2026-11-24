<div class="post-type-one">
    <a href="{{ Helper::getRouteForPost($post) }}">
        <div class="featured" style="background: no-repeat center/cover url({{ $post->thumbnailSmall() }})">
        </div>
    </a>
    <h4><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h4>
    <span class="text-muted small">{{ \Helper::getFormattedPostDate($post) }}</span>
</div>
