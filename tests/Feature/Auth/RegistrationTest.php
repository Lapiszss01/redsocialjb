<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'role_id' => 1,
        'email' => 'test@example.com',
        'username' => 'usuario',
        'biography' => '',
        'password' => 'password',
        'password_confirmation' => 'password',
        'remember_token' => '',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
