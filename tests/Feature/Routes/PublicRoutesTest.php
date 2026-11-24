<?php

namespace Tests\Feature\Routes;

use App\Models\Post;
use App\Models\Category;
use App\Utilities\Helper;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page works', function () {
    $response = $this->get(route('index'));
    $response->assertOk();
});

test('standalone category page works', function () {
    $category = Category::factory()->create();
    $response = $this->get(Helper::getRouteForCategory($category));
    $response->assertOk();
});

test('child category page works', function () {
    $category = Category::factory()->create(['parent' => Category::factory()->create()]);
    $response = $this->get(Helper::getRouteForCategory($category));
    $response->assertOk();
    $response->assertViewHas('showBreadcrump');
});


test('parent category page works', function () {
    $category = Category::factory()->create();
    Category::factory()->create(['parent' => $category->id]);
    $response = $this->get(Helper::getRouteForCategory($category));
    $response->assertOk();
    $response->assertViewHas('showSubCategories');
});

test('view post page works', function () {
    $post = Post::factory()->create();
    $response = $this->get(Helper::getRouteForPost($post));
    $response->assertOk();
    $response->assertViewHas('post');
});

test('login page works', function () {
    $response = $this->get(route('login'));
    $response->assertOk();
});
