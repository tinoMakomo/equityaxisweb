<div class="post-type-nine">
    <div class="row">
        <div class="col-4 mb-2">
            <a href="{{ Helper::getCategoryRouteForPost($post) }}" class="text-primary-darker">
                <div class="featured"
                    style="background: no-repeat center/cover url({{ $post->thumbnailSmall() }})">
                </div>
            </a>
        </div>
        <div class="col-8">
            <h6 class="small"><a href="{{ Helper::getCategoryRouteForPost($post) }}"
                    class="text-primary-darker">{{ $post->getCategory() }}</a></h6>
            <h5><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h5>
            <a class="text-dark mb-1" href="{{ Helper::getRouteForPost($post) }}">
                <p class="line-clamp-2">{{ $post->excerpt }}</p>
            </a>
            <p class="small">{{ \Helper::getFormattedPostDate($post) }}</p>
        </div>
    </div>
</div>
