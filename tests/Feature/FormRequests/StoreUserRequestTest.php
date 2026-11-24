<?php

namespace Tests\Feature\FormRequests;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;
use function Pest\Faker\faker;

uses(RefreshDatabase::class);

beforeEach(function () {
    parent::setUp();
    $this->password = "password";
    $userType = UserType::factory()->create(['name' => 'Admin']);
    $user = User::factory()->hasPreferences(1)->create(['user_type_id' => $userType->id, 'password' => Hash::make($this->password)]);
    $this->actingAs($user);
    $this->user = $user;
});

test('store user form requests works', function () {
    $data = [
        'name' => faker()->name(),
        'email' => faker()->unique()->safeEmail(),
        'user_type_id' => UserType::factory()->create()->id,
        'bio' => faker()->sentence(),
        'twitter' => faker()->url(),
        'linkedin' => faker()->url(),
        'phone' => faker()->phoneNumber(),
        'password' => "tadiwanashe",
        'password_confirmation' => "tadiwanashe",
    ];

    $request = new StoreUserRequest();
    $request->headers->set('content-type', 'application/json');
    $request->setJson(new ParameterBag($data));

    try {
        $request
            ->setContainer(app())
            ->setRedirector(app(Redirector::class))
            ->validateResolved();
    } catch (ValidationException $ex) {
        print($ex);
    }

    $this->assertFalse(isset($ex));
});
