<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdatePreferenceRequest;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);

beforeEach(function () {
    parent::setUp();
    $this->password = "password";
    $userType = UserType::factory()->create(['name' => 'Admin']);
    $user = User::factory()->hasPreferences(1)->create(['user_type_id' => $userType->id, 'password' => Hash::make($this->password)]);
    $this->actingAs($user);
    $this->user = $user;
});



it('can update the own password', function () {
    $controller = new AdminController();

    $data = [
        'current_password' => $this->password,
        'new_password' => 'aaaaaaaa',
        'new_password_confirmation' => 'aaaaaaaa',
    ];

    $request = new ChangePasswordRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($data));

    $response = $controller->updatePassword($request);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin.change_password'), $response->headers->get('Location'));
});


it('can update the profile', function () {
    $controller = new AdminController();

    $request = new UpdateProfileRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($this->user->toArray()));

    $response = $controller->updateProfile($request);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_profile'), $response->headers->get('Location'));
});


it('can update the preferences', function () {
    $controller = new AdminController();

    $request = new UpdatePreferenceRequest();
    $request->headers->set('content-type', 'application/json');

    $data =  [
        'user_id' => $this->user->id,
        'dark_mode_set' => 0,
        'items_per_page' => 10,
        'flat_nav_bar_set' => 1,
        'fixed_header_set' => 1,
    ];

    $request->setJson(new ParameterBag($data));

    $response = $controller->updatePreferences($request);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_preferences'), $response->headers->get('Location'));
});
