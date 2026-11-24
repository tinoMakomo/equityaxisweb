<div class="post-type-six">
    <div class="boxed">
        <h6 class="small"><a href="{{ Helper::getCategoryRouteForPost($post) }}" class="text-primary-darker">{{ $post->getCategory() }}</a></h6>
        <h5 class="line-clamp-2"><a href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h5>
        <a class="text-dark" href="{{ Helper::getRouteForPost($post) }}">
            <p class="mb-1 line-clamp-3">{{ $post->excerpt }}</p>
        </a>
        <span class="text-muted d-block mb-3 small">{{ \Helper::getFormattedPostDate($post) }}</span>
    </div>
    <a href="{{ Helper::getRouteForPost($post) }}">
        <div class="featured" style="background: no-repeat center/cover url({{ $post->thumbnailSmall() }})">
        </div>
    </a>
</div>
