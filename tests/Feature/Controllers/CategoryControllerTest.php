<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\UserType;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Admin\CategoryController;
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
    $controller = new CategoryController();

    $view = $controller->index();
    $this->expect($view->getName())->toBe('admin.categories.index');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->toHtml())->toContain("Categories List");
});

it('can show the show view', function () {
    $controller = new CategoryController();
    $category = Category::factory()->create();

    $view = $controller->show($category->id);
    $this->expect($view->getName())->toBe('admin.categories.show');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->getData())->toHaveKey("category");
});


it('can store the category', function () {
    $controller = new CategoryController();
    $category = Category::factory()->make();


    $request = new StoreCategoryRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($category->toArray()));

    $response = $controller->store($request);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_categories.index'), $response->headers->get('Location'));
});

it('can update the category', function () {
    $controller = new CategoryController();
    $category = Category::factory()->create();

    $request = new UpdateCategoryRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($category->toArray()));

    $response = $controller->update($request, $category->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_categories.index'), $response->headers->get('Location'));
});



it('can destroy the category', function () {
    $controller = new CategoryController();
    $category = Category::factory()->create();

    $response = $controller->destroy($category->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_categories.index'), $response->headers->get('Location'));
});
