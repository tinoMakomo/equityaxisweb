<?php

namespace Tests\Feature\FormRequests;

use App\Models\User;
use Illuminate\Routing\Redirector;
use App\Http\Requests\UpdatePreferenceRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);

test('update preference form requests works', function () {
    $data = [
        'user_id' => User::factory()->create()->id,
        'dark_mode_set' => 0,
        'items_per_page' => 10,
        'flat_nav_bar_set' => 1,
        'fixed_header_set' => 1,
    ];

    $request = new UpdatePreferenceRequest();
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
