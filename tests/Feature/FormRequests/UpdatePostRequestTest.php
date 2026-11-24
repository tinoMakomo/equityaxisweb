<?php

namespace Tests\Feature\FormRequests;

use function Pest\Faker\faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);

test('update post form requests works', function () {
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

    $request = new UpdatePostRequest();
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
