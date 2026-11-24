<?php

namespace Tests\Feature\Routes;

use App\Models\Ad;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    parent::setUp();
    $userType = UserType::factory()->create(['name' => 'Admin']);
    $user = User::factory()->hasPreferences(1)->create(['user_type_id' => $userType->id]);
    $this->actingAs($user);
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


test('ads index page works', function () {
    $response = $this->followingRedirects()->get(route('admin_ads.index'));
    $response->assertOk();
    $response->assertViewIs('admin.ads.index');
});

test('ads create page works', function () {
    $response = $this->followingRedirects()->get(route('admin_ads.create'));
    $response->assertOk();
    $response->assertViewIs('admin.ads.create');
});

test('ads show page works', function () {
    $ad = Ad::factory()->create();
    $response = $this->followingRedirects()->get(route('admin_ads.show', $ad->id));
    $response->assertOk();
    $response->assertViewIs('admin.ads.show');
});

test('users index page works', function () {
    $response = $this->followingRedirects()->get(route('admin_users.index'));
    $response->assertOk();
    $response->assertViewIs('admin.users.index');
});

test('users create page works', function () {
    $response = $this->followingRedirects()->get(route('admin_users.create'));
    $response->assertOk();
    $response->assertViewIs('admin.users.create');
});

test('users show page works', function () {
    $user = User::factory()->create();
    $response = $this->followingRedirects()->get(route('admin_users.show', $user->id));
    $response->assertOk();
    $response->assertViewIs('admin.users.show');
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

test('logout works', function () {
    $response = $this->from(route('admin_dashboard'))->followingRedirects()->get(route('logout'));
    $response->assertViewIs('auth.login');
});
