<div class="post-type-four">
    <div class="row">
        <div class="col-md-6">
            <h6><a href="{{ Helper::getCategoryRouteForPost($post) }}" class="small category-badge">{{ $post->getCategory() }}</a></h6>
            <h2><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h2>
            <a class="text-dark" href="{{ Helper::getRouteForPost($post) }}">
                <p class="line-clamp-3">
                    {{ $post->excerpt }}
                </p>
            </a>
            <p class="small text-muted mb-md-0">{{ \Helper::getFormattedPostDate($post) }}</p>
        </div>
        <div class="col-md-6">
            <a href="{{ Helper::getRouteForPost($post) }}">
                <div class="featured">
                    <img src="{{ $post->thumbnailSmall() }}" alt="{{ $post->title }}" loading="lazy" decoding="async">
                </div>
            </a>
        </div>
    </div>
</div>
