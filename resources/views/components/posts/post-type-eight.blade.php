<div class="post-type-eight">
    <h4><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h4>
    <a class="text-dark" href="{{ Helper::getRouteForPost($post) }}">
        <p class="mb-1 line-clamp-3">
            {{ $post->excerpt }}
        </p>
    </a>
    <span class="text-muted d-block mb-3 small">{{ \Helper::getFormattedPostDate($post) }}</span>
</div>
