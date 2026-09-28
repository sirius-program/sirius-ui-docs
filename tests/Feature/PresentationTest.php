<?php

declare(strict_types=1);

use App\Livewire\Examples\PresentationExample;
use Livewire\Livewire;

it('renders each presentation page with Blade demos and copyable usage', function (string $name): void {
    $this->get(route('blade-components.' . $name))->assertOk()
        ->assertDontSee('data-demo-mode="livewire"', false)->assertSee('data-demo-mode="blade"', false)
        ->assertSee('id="' . $name . '-usage"', false)->assertSee('data-docs-props', false);
})->with(['icon', 'button', 'button-group', 'badge', 'message']);

it('updates demo state without replacing the message reset key until explicitly requested', function (): void {
    Livewire::test(PresentationExample::class, ['kind' => 'message'])
        ->call('save')->assertSet('saved', true)->assertSet('revision', 0)
        ->call('refreshExample')->assertSet('saved', false)->assertSet('revision', 1);
});
