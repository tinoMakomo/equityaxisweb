<?php

namespace Tests\Feature\FormRequests;

use App\Models\Post;
use App\Utilities\Helper;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('fast news component works', function () {
    $post = Post::factory()->create();

    $view = $this->blade(
        '<x-posts.post-type-nine :post="$post" />',
        ['post' => $post]
    );

    $view->assertSeeInOrder([Helper::getRouteForPost($post), $post->title]);
});
