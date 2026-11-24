<?php

namespace Tests\Feature\FormRequests;

use App\Models\User;
use App\Models\AdPreset;
use App\Models\Category;
use App\Models\UserType;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);

test('store category form requests works', function () {
    $data = [
        'name' => 'stanbic_ad',
        'description' => 'Long description',
        'parent' => Category::factory()->create()->id,
        'position' => 1,
        'display_in_navbar' => 1,
    ];

    $request = new StoreCategoryRequest();
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
