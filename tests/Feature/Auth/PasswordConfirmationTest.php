<?php

use App\Models\User;

<<<<<<< HEAD
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

=======
>>>>>>> 9274150457084e72d569d3ae769f1817318a4c10
test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('password.confirm'));

    $response->assertStatus(200);
});