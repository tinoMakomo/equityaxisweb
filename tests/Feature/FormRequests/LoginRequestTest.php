<?php

namespace Tests\Feature\FormRequests;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Routing\Redirector;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ChangeUserPasswordRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);

test('login form requests works', function () {

    $data = [
        'email' => 'iser@mail.com',
        'password' => 'aaaaaaaa',
    ];

    $request = new LoginRequest();
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
