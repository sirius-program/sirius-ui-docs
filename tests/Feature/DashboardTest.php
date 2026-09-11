<?php

test('dashboard is publicly accessible', function (): void {
    $response = $this->get(route('dashboard'));

    $response
        ->assertSeeInOrder(['Home', 'Dashboard'])
        ->assertSee('Light')
        ->assertSee('Dark')
        ->assertSee('System');
});
