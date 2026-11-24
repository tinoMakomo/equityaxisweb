<?php

namespace Tests\Feature\FormRequests;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Validation\ValidationException;
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

test('change password form requests works', function () {

    $data = [
        'current_password' => $this->password,
        'new_password' => 'aaaaaaaa',
        'new_password_confirmation' => 'aaaaaaaa',
    ];

    $request = new ChangePasswordRequest();
    $request->headers->set('content-type', 'application/json');
    $request->setJson(new ParameterBag($data));

    try {
        $request
            ->setContainer(app())
            ->setRedirector(app(Redirector::class))
            ->validateResolved();
    } catch (ValidationException $ex) {
    }

    $this->assertFalse(isset($ex));
});
