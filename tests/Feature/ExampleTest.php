<?php

test('guests are sent to the login page', function () {
    $response = $this->get('/');

    $response->assertRedirect('/barang');
    $this->get('/barang')->assertRedirect('/login');
});
