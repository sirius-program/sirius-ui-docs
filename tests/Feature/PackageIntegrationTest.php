<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Sirius\Ui\SiriusUiServiceProvider;

it('discovers the local package and renders its icon dependency', function (): void {
    expect(app()->getProvider(SiriusUiServiceProvider::class))->not->toBeNull()
        ->and(config('sirius-ui.blade_namespace'))->toBe('sirius');

    expect(Blade::render('<x-heroicon-o-eye aria-label="Show password" />'))
        ->toContain('<svg', 'Show password');
});

it('provides navigation for completed components', function (): void {
    $this->get(route('started'))
        ->assertSee('Getting Started')
        ->assertDontSee('Form Conventions')
        ->assertSee('Checkbox')
        ->assertSee(route('blade-components.phone'));
});
