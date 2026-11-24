<?php

namespace Tests\Feature\FormRequests;

use App\Models\User;
use App\Models\AdPreset;
use App\Models\UserType;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdRequest;
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

test('store ad form requests works', function () {
    $data = [
        'description' => 'Long description',
        'link' => 'https://google.com',
        'preset' =>  faker()->randomElement(AdPreset::LIST),
        'advert' => UploadedFile::fake()->image('avatar.jpg')
    ];

    $request = new StoreAdRequest();
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
