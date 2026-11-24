<?php

namespace Tests\Feature\Routes;

use App\Models\Ad;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\UserType;
use App\Utilities\Helper;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    parent::setUp();
    $userType = UserType::factory()->create(['name' => 'Author']);
    $user = User::factory()->hasPreferences(1)->create(['user_type_id' => $userType->id]);
    $this->user = $user;
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
    $post = Post::factory()->create(['user_id' => $this->user]);
    $response = $this->followingRedirects()->get(route('admin_posts.show', $post->id));
    $response->assertOk();
    $response->assertViewIs('admin.posts.show');
});


test('posts show page does not work for not own post', function () {
    $post = Post::factory()->create();
    $response = $this->followingRedirects()->get(route('admin_posts.show', $post->id));
    $response->assertStatus(404);
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


test('author cannot view ads page', function () {
    $response = $this->followingRedirects()->get(route('admin_ads.index'));
    $response->assertStatus(403);
});


test('author cannot view users page', function () {
    $response = $this->followingRedirects()->get(route('admin_users.index'));
    $response->assertStatus(403);
});

test('author cannot view categories', function(){
    $response = $this->get(route('admin_categories.index'));
    $response->assertStatus(403);
});

test('logout works', function () {
    $response = $this->from(route('admin_dashboard'))->followingRedirects()->get(route('logout'));
    $response->assertViewIs('auth.login');
});
