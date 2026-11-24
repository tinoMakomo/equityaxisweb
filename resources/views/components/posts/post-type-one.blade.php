<div class="post-type-one">
    <a href="{{ Helper::getRouteForPost($post) }}">
        <div class="featured">
            <img src="{{ $post->thumbnailSmall() }}" alt="{{ $post->title }}" loading="lazy" decoding="async">
        </div>
    </a>
    <h4><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h4>
    <span class="text-muted small">{{ \Helper::getFormattedPostDate($post) }}</span>
</div>
