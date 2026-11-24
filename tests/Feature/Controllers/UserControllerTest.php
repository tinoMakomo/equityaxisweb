<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Admin\UserController;
use App\Http\Requests\ChangeUserPasswordRequest;
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
    $controller = new UserController();

    $view = $controller->index();
    $this->expect($view->getName())->toBe('admin.users.index');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->toHtml())->toContain("Users List");
});

it('can show the show view', function () {
    $controller = new UserController();
    $user = User::factory()->hasPreferences(1)->create();

    $view = $controller->show($user->id);
    $this->expect($view->getName())->toBe('admin.users.show');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->getData())->toHaveKey("user");
});


it('can store the user', function () {
    $controller = new UserController();
    $user = User::factory()->make();


    $request = new StoreUserRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($user->toArray()));

    $response = $controller->store($request);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_users.index'), $response->headers->get('Location'));
});

it('can update the user', function () {
    $controller = new UserController();
    $user = User::factory()->create();


    $request = new UpdateUserRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($user->toArray()));

    $response = $controller->update($request, $user->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_users.index'), $response->headers->get('Location'));
});



it('can destroy the user', function () {
    $controller = new UserController();
    $user = User::factory()->create();

    $response = $controller->destroy($user->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_users.index'), $response->headers->get('Location'));
});


it('can update the user password', function () {
    $controller = new UserController();

    $user = User::factory()->hasPreferences(1)->create(['password' => Hash::make("password")]);

    $data = [
        'new_password' => 'aaaaaaaa',
        'new_password_confirmation' => 'aaaaaaaa',
    ];

    $request = new ChangeUserPasswordRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($data));

    $response = $controller->updateUserPassword($request, $user->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin.change_user_password', $user->id), $response->headers->get('Location'));
});

