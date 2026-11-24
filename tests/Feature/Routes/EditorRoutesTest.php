<?php

namespace Tests\Feature\Routes;

use App\Models\Ad;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    parent::setUp();
    $userType = UserType::factory()->create(['name' => 'Editor']);
    $user = User::factory()->hasPreferences(1)->create(['user_type_id' => $userType->id]);
    $this->actingAs($user);
    $this->user = $user;
});

test('dashboard page works', function () {
    $response = $this->followingRedirects()->get(route('admin_dashboard'));
    $response->assertOk();
    $response->assertViewIs('admin.index');
});

test('posts index page works', function () {
    $response = $this->followingRedirects()->get(route('admin_posts.index'));
    $response->assertOk();
    $response->assertViewIs('admin.posts.index');
});

test('posts create page works', function () {
    $response = $this->followingRedirects()->get(route('admin_posts.create'));
    $response->assertOk();
    $response->assertViewIs('admin.posts.create');
});

test('posts show page works', function () {
    $post = Post::factory()->create();
    $response = $this->followingRedirects()->get(route('admin_posts.show', $post->id));
    $response->assertOk();
    $response->assertViewIs('admin.posts.show');
});


test('profile page works', function () {
    $response = $this->followingRedirects()->get(route('admin_profile'));

    $response->assertViewIs('admin.users.profile');
});

test('preferences page works', function () {
    $response = $this->followingRedirects()->get(route('admin_preferences'));
    $response->assertOk();
    $response->assertViewIs('admin.users.preferences');
});

test('categories index page works', function () {
    $response = $this->followingRedirects()->get(route('admin_categories.index'));
    $response->assertOk();
    $response->assertViewIs('admin.categories.index');
});

test('categories create page works', function () {
    $response = $this->followingRedirects()->get(route('admin_categories.create'));
    $response->assertOk();
    $response->assertViewIs('admin.categories.create');
});

test('categories show page works', function () {
    $category = Category::factory()->create();
    $response = $this->followingRedirects()->get(route('admin_categories.show', $category->id));
    $response->assertOk();
    $response->assertViewIs('admin.categories.show');
});


test('author cannot view users page', function () {
    $response = $this->followingRedirects()->get(route('admin_users.index'));
    $response->assertStatus(403);
});

test('author cannot view ads', function(){
    $response = $this->get(route('admin_ads.index'));
    $response->assertStatus(403);
});

test('logout works', function () {
    $response = $this->from(route('admin_dashboard'))->followingRedirects()->get(route('logout'));
    $response->assertViewIs('auth.login');
});
