<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserType;
use function Pest\Faker\faker;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;


uses(RefreshDatabase::class);



beforeEach(function () {
    parent::setUp();
    $userType = UserType::factory()->create(['name' => 'Admin']);
    $user = User::factory()->hasPreferences(1)->create(['user_type_id' => $userType->id]);
    $this->actingAs($user);
});

it('can index resources', function () {
    $controller = new PostController();

    $view = $controller->index();
    $this->expect($view->getName())->toBe('admin.posts.index');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->toHtml())->toContain("Posts List");
});

it('can show the show view', function () {
    $controller = new PostController();
    $post = Post::factory()->create();

    $view = $controller->show($post->id);
    $this->expect($view->getName())->toBe('admin.posts.show');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->getData())->toHaveKey("post");
});


it('can store the post', function () {
    $controller = new PostController();
    $post = Post::factory()->make();
    $post->tags = faker()->words(3);

    $request = new StorePostRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($post->toArray()));

    $response = $controller->store($request);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_posts.index'), $response->headers->get('Location'));
});

it('can update the post', function () {
    $controller = new PostController();
    $post = Post::factory()->create();
    $post->tags = faker()->words(3);

    $request = new UpdatePostRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($post->toArray()));

    $response = $controller->update($request, $post->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_posts.index'), $response->headers->get('Location'));
});



it('can destroy the post', function () {
    $controller = new PostController();
    $post = Post::factory()->create();

    $response = $controller->destroy($post->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_posts.index'), $response->headers->get('Location'));
});
