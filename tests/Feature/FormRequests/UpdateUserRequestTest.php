<?php

namespace Tests\Feature\FormRequests;

use App\Models\UserType;
use Illuminate\Support\Str;
use function Pest\Faker\faker;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);


test('update user form requests works', function () {
    $data = [
        'name' => faker()->name(),
        'email' => faker()->unique()->safeEmail(),
        'user_type_id' => UserType::factory()->create()->id,
        'bio' => faker()->sentence(),
        'twitter' => faker()->url(),
        'linkedin' => faker()->url(),
        'phone' => faker()->phoneNumber(),
        'password' => Hash::make('tadiwanashe'),
    ];

    $request = new UpdateUserRequest();
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
