<?php

declare(strict_types=1);

it('validates each native demo independently and never flashes passwords', function (string $kind, string $key): void {
    $this->post(route('blade-components.examples.store', ['kind' => $kind]), [])
        ->assertSessionHasErrorsIn('sample-' . $kind, [$key]);
})->with([['input', 'title'], ['password', 'password'], ['textarea', 'notes'], ['checkbox', 'roles'], ['radio', 'plan'], ['switch', 'enabled'], ['label', 'email']]);

it('accepts valid native demo values and flashes only non-password values', function (string $kind, array $values): void {
    $response = $this->post(route('blade-components.examples.store', ['kind' => $kind]), $values);

    $response->assertSessionHasNoErrors()->assertSessionHas('sample-success-' . $kind, true)
        ->assertSessionMissing('sample-' . $kind . '.password')->assertSessionMissing('_old_input.password');
})->with([
    ['input', ['title' => 'Example', 'quantity' => '0']],
    ['password', ['password' => 'example-only-password']],
    ['textarea', ['notes' => 'Example notes']],
    ['checkbox', ['agreed' => 'on', 'roles' => ['0']]],
    ['radio', ['plan' => '0']],
    ['switch', ['enabled' => 'on']],
    ['label', ['email' => 'reader@example.com']],
]);

it('loads sample values and resets without validating stale input', function (string $action): void {
    $response = $this->post(route('blade-components.examples.store', ['kind' => 'input']), ['sample_action' => $action, 'quantity' => 'invalid']);

    $response->assertRedirect(route('blade-components.control', ['control' => 'input']) . '#input-blade')->assertSessionHasNoErrors();
    if ($action === 'load') {
        $response->assertSessionHas('sample-input.title', 'Website redesign')->assertSessionHas('sample-input.quantity', 12);
    } else {
        $response->assertSessionHas('sample-input', []);
    }
})->with(['load', 'reset']);

it('rejects unrecognized demo kinds and actions', function (): void {
    $this->post('/blade-components/examples/unknown')->assertNotFound();
    $this->post(route('blade-components.examples.store', ['kind' => 'input']), ['sample_action' => 'delete'])->assertUnprocessable();
});

it('removes the public form conventions page and keeps field fixtures in development', function (): void {
    $this->get('/blade-components/forms')->assertNotFound();
    $this->post('/blade-components/forms')->assertNotFound();
    $this->get(route('started'))->assertDontSee('Form Conventions')->assertSee('On this page')->assertSee('Back to top');
    $this->get(route('development.fields'))->assertOk()->assertSee('data-blade-field-example', false);
});

it('displays the exact native demo source in separate copyable usage blocks', function (string $page, array $demos): void {
    $response = $this->get($page)->assertOk();
    foreach ($demos as $demo) {
        $source = trim(file_get_contents(resource_path('views/blade-components/demos/' . $demo . '.blade.php')));
        $response->assertSee(e($source), false);
        expect($source)->not->toContain('wire:model');
    }
    expect(substr_count($response->getContent(), 'data-usage-example'))->toBe(count($demos));
})->with([
    ['/blade-components/input', ['input-title', 'input-quantity', 'password']],
    ['/blade-components/textarea', ['textarea']],
    ['/blade-components/choices', ['checkbox-agreement', 'checkbox-roles', 'checkbox-mixed', 'radio', 'switch']],
    ['/blade-components/label', ['label-required', 'label-optional']],
]);
