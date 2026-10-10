<?php

declare(strict_types=1);

use App\Livewire\Examples\NavigationExample;
use Livewire\Livewire;

it('renders navigation documentation with separate demos usage and attributes', function (string $component): void {
    $response = $this->get(route('blade-components.' . $component))->assertOk()
        ->assertSee('id="' . $component . '-demo"', false)
        ->assertSee('id="' . $component . '-usage"', false)
        ->assertSee('id="' . $component . '-attributes"', false)
        ->assertSee('data-demo-mode="blade"', false)->assertSee('data-usage-example', false)
        ->assertDontSee('data-demo-mode="livewire"', false)->assertDontSee('Shared field contract');

    if ($component !== 'breadcrumb') {
        $response->assertSee('id="assets-and-interaction"', false);
    }
})->with(['breadcrumb', 'menu', 'dropdown']);

it('renders and updates the development navigation fixture without duplicating its actions', function (): void {
    Livewire::test(NavigationExample::class)->assertSee('Project actions')->call('increment')->assertSet('count', 1)
        ->call('rename')->assertSee('Download')->set('locked', true)->assertSee('aria-disabled="true"', false)
        ->set('opened', true)->assertSee('data-initial-open="true"', false)
        ->set('visible', false)->assertDontSee('id="livewire-actions"', false)
        ->set('visible', true)->assertSee('id="livewire-actions"', false);
});

it('loads the development navigation fixture inside its local route', function (): void {
    $this->get(route('development.navigation'))->assertOk()->assertSee('id="livewire-actions"', false)
        ->assertSee('id="team-links-submenu"', false)
        ->assertSee('id="project-links-submenu"', false)
        ->assertSee('id="account-links-submenu"', false);
});
