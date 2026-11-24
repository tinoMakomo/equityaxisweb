<div class="post-type-two">
    <a href="{{ Helper::getRouteForPost($post) }}">
        <div class="featured" style="background:no-repeat center/cover url({{ $post->featuredImage() }})"></div>
    </a>
    <div class="title">
        <h5>Editor's Pick</h5>
        <h3><a class="line-clamp-2" href="{{ Helper::getRouteForPost($post) }}">{{ $post->title }}</a></h3>
        <span class="text-muted text-center small mb-3 d-block">{{ \Helper::getFormattedPostDate($post) }}</span>
    </div>
</div>
