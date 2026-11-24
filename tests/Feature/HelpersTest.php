<?php

namespace Tests\Feature\Routes;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Utilities\Helper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('get parent categories returns results', function () {
    $categories = Helper::getParentCategories();
    $this->assertEmpty($categories->toArray());
    Category::factory()->create();
    $categories = Helper::getParentCategories();
    $this->assertNotEmpty($categories->toArray());
});


test('get route for post returns correct url', function () {
    $post = Post::factory()->create();
    $route = Helper::getRouteForPost($post);
    $this->assertNotEmpty($route);
    $this->assertEquals($route, route('post', [$post->id, $post->created_at->year, $post->created_at->month, $post->slug]));
});

test('get route for category returns correct url', function () {
    $category = Category::factory()->create();
    $route = Helper::getRouteForCategory($category);
    $this->assertNotEmpty($route);
    $this->assertEquals($route, route('category', [$category->id, $category->slug]));
});

test('get route for category of post returns correct url', function () {
    $post = Post::factory()->hasCategories(1)->create();
    $route = Helper::getCategoryRouteForPost($post);
    $this->assertNotEmpty($route);
    $this->assertEquals($route, route('category', [$post->categories->first()->id, $post->categories->first()->slug]));
});
