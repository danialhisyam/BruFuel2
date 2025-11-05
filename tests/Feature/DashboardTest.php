<?php

use App\Models\User;

<<<<<<< HEAD
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

=======
>>>>>>> 9274150457084e72d569d3ae769f1817318a4c10
test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
});