<?php

it('returns all pages successfully without errors', function () {
    $routes = ['/', '/dashboard', '/repairs'];

    $this->visit($routes)
         ->assertDontSee('Not Found')
         ->assertNoSmoke();
});
