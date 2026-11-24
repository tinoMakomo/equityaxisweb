<?php

namespace Tests\Feature\FormRequests;

use App\Models\Post;
use App\Utilities\Helper;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('post type eight component works', function () {
    $post = Post::factory()->create();

    $view = $this->blade(
        '<x-posts.post-type-eight :post="$post" />',
        ['post' => $post]
    );

    $view->assertSeeInOrder([Helper::getRouteForPost($post), Str::limit($post->title, 60)]);
});
