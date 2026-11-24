<?php

namespace Tests\Feature\FormRequests;

use App\Models\Post;
use App\Models\UserType;
use App\Utilities\Helper;
use Illuminate\Support\Str;
use function Pest\Faker\faker;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);


test('post type twi component works', function () {
    $post = Post::factory()->create();

    $view = $this->blade(
        '<x-posts.post-type-two :post="$post" />',
        ['post' => $post]
    );

    $view->assertSeeInOrder([Helper::getRouteForPost($post), $post->title]);
});
