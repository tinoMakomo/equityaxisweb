<?php

namespace Tests\Feature\Routes;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

uses(RefreshDatabase::class);

it('has valid relationships', function () {
    $m = new Post();

    $relation = $m->user();
    $this->assertInstanceOf(BelongsTo::class, $relation);

    $relation = $m->categories();
    $this->assertInstanceOf(BelongsToMany::class, $relation);
});


test('tags method returns valid tags', function () {
    $post = Post::factory()->create();
    $tags = $post->tags();
    $this->assertEquals(explode(";;", $post->tags), $tags);
});


test('get category returns results', function () {
    $post = Post::factory()->create();
    $category = $post->getCategory();
    $this->assertEquals("Uncategorized", $category);

    $post = Post::factory()->hasCategories(1)->create();
    $category = $post->getCategory();
    $this->assertNotEquals("Uncategorized", $category);
});



test('get status returns results', function () {
    $post = Post::factory()->create();
    $status = $post->getStatus();
    $this->assertEquals("Published", $status);

    $post = Post::factory()->create(['status'=> 'unpublished']);
    $status = $post->getStatus();
    $this->assertEquals("Unpublished", $status);
});


test('get excerpt returns results', function () {
    $post = Post::factory()->create();
    $excerpt = $post->excerpt();
    $this->assertEquals(Str::limit(strip_tags($post->excerpt), 120), $excerpt);
});
