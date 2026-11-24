<?php

namespace Tests\Feature\Controllers;

use App\Models\Ad;
use App\Models\User;
use App\Models\AdPreset;
use App\Models\UserType;
use function Pest\Faker\faker;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreAdRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateAdRequest;
use App\Http\Controllers\Admin\AdController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;

uses(RefreshDatabase::class);

beforeEach(function () {
    parent::setUp();
    $userType = UserType::factory()->create(['name' => 'Admin']);
    $user = User::factory()->hasPreferences(1)->create(['user_type_id' => $userType->id]);
    $this->actingAs($user);
});

it('can index resources', function () {
    $controller = new AdController();

    $view = $controller->index();
    $this->expect($view->getName())->toBe('admin.ads.index');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->toHtml())->toContain("Ads List");
});

it('can show the show view', function () {
    $controller = new AdController();
    $ad = Ad::factory()->create();

    $view = $controller->show($ad->id);
    $this->expect($view->getName())->toBe('admin.ads.show');
    $this->expect($view->getData())->toBeArray();
    $this->expect($view->getData())->toHaveKey("ad");
});


it('can store the ad', function () {
    $controller = new AdController();
    $data = [
        'description' => faker()->paragraph(),
        'link' => faker()->url(),
        'preset' => faker()->randomElement(AdPreset::LIST),
        'advert' => UploadedFile::fake()->image('avatar.jpg'),
    ];

    $request = new StoreAdRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($data));

    $response = $controller->store($request);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_ads.index'), $response->headers->get('Location'));
});

it('can update the ad', function () {
    $controller = new AdController();
    $ad = Ad::factory()->create();


    $request = new UpdateAdRequest();
    $request->headers->set('content-type', 'application/json');

    $request->setJson(new ParameterBag($ad->toArray()));

    $response = $controller->update($request, $ad->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_ads.index'), $response->headers->get('Location'));
});



it('can destroy the ad', function () {
    $controller = new AdController();
    $ad = Ad::factory()->create();
    $response = $controller->destroy($ad->id);
    $this->assertInstanceOf(RedirectResponse::class, $response);
    $this->assertEquals(route('admin_ads.index'), $response->headers->get('Location'));
});
