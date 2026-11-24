<?php

namespace Tests\Feature\Routes;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('can login', function () {
    $user = User::factory()->hasPreferences(1)->create(['password' => Hash::make("password")]);
    $response = $this->followingRedirects()->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
        '_token' => Session::token(),
    ]);
    $response->assertStatus(200);
    $response->assertViewIs('admin.index');
});

test('invalid login credentials fail', function () {
    $user = User::factory()->hasPreferences(1)->create(['password' => Hash::make("password")]);
    $response = $this->from(route('login'))->followingRedirects()->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong_password',
        '_token' => Session::token(),
    ]);
    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
});

test('authentication is required for admin dashboard', function(){
    $response = $this->followingRedirects()->get(route('admin_dashboard'));
    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
});
