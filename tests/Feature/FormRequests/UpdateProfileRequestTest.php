<?php

namespace Tests\Feature\FormRequests;

use App\Models\UserType;
use Illuminate\Support\Str;
use function Pest\Faker\faker;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);


test('update profile form requests works', function () {
    $data = [
        'name' => faker()->name(),
        'email' => faker()->unique()->safeEmail(),
        'bio' => faker()->sentence(),
        'twitter' => faker()->url(),
        'linkedin' => faker()->url(),
        'phone' => faker()->phoneNumber(),
    ];

    $request = new UpdateProfileRequest();
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
