<?php

namespace Tests\Feature\FormRequests;

use App\Models\AdPreset;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use App\Http\Requests\UpdateAdRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;
use function Pest\Faker\faker;

uses(RefreshDatabase::class);

test('update ad form requests works', function () {
    $data = [
        'description' => 'Long description',
        'link' => 'https://google.com',
        'preset' =>  faker()->randomElement(AdPreset::LIST),
        'advert' => UploadedFile::fake()->image('avatar.jpg')
    ];

    $request = new UpdateAdRequest();
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
