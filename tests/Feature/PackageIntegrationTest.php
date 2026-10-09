<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Sirius\Ui\SiriusUiServiceProvider;

it('discovers the local package and renders its icon dependency', function (): void {
    expect(app()->getProvider(SiriusUiServiceProvider::class))->not->toBeNull()
        ->and(config('sirius-ui.namespace.blade'))->toBe('sirius');

    expect(Blade::render('<x-heroicon-o-eye aria-label="Show password" />'))
        ->toContain('<svg', 'Show password');
});

it('provides navigation for completed components', function (): void {
    $this->get(route('started'))->assertRedirect(route('started.introduction'));
    $this->get(route('started.introduction'))
        ->assertSee('Getting Started')
        ->assertDontSee('Form Conventions')
        ->assertSee(route('blade-components.choices'))
        ->assertSee(route('blade-components.phone'));
});
