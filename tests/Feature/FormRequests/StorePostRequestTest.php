<?php

namespace Tests\Feature\FormRequests;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StorePostRequest;
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

test('store post form requests works', function () {
    $data = [
        'title' => faker()->title(),
        'body' => faker()->paragraph(),
        'excerpt' => faker()->sentence(),
        'status' => "published",
        'categories' => faker()->words(3),
        'featured_image' => UploadedFile::fake()->image('avatar.jpg'),
        'tags' => faker()->words(3),
        'editors_pick' => faker()->boolean(),
        'publish_at' => now()->addDays(2),
    ];

    $request = new StorePostRequest();
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
