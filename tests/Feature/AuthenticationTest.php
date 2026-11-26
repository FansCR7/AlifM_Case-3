<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('a visitor can register and receives a hashed password', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Pengguna Baru',
        'email' => 'baru@example.com',
        'password' => 'password-rahasia',
        'password_confirmation' => 'password-rahasia',
    ]);

    $response->assertRedirect(route('products.index'));
    $this->assertAuthenticated();
    expect(Hash::check('password-rahasia', User::where('email', 'baru@example.com')->firstOrFail()->password))->toBeTrue();
});

test('a user can log in and log out', function () {
    $user = User::factory()->create();

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('products.index'));

    $this->assertAuthenticatedAs($user);

    $this->post(route('logout'))->assertRedirect(route('login'));
    $this->assertGuest();
});
