<?php

<<<<<<< HEAD
it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
=======
test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
});
>>>>>>> 9274150457084e72d569d3ae769f1817318a4c10
