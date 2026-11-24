<div class="post-type-seven">
    <h6 class="small"><a href="{{ Helper::getCategoryRouteForPost($post) }}"
            class="text-primary-darker">{{ $post->getCategory() }}</a></h6>
    <h5><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h5>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ Helper::getRouteForPost($post) }}">
                <div class="featured" style="background: no-repeat center/cover url({{ $post->thumbnailSmall() }})">
                </div>
            </a>
        </div>
        <div class="col-md-8">
            <a class="text-dark" href="{{ Helper::getRouteForPost($post) }}">
                <p class="line-clamp-3">{{ $post->excerpt }}</p>
            </a>
            <span class="text-muted d-block mb-3 small">{{ \Helper::getFormattedPostDate($post) }}</span>
        </div>
    </div>
</div>
