<?php

declare(strict_types=1);

use App\Livewire\Examples\TabsExample;
use Livewire\Livewire;

it('renders separate Tabs and Timeline docs with Blade demos and copyable usage', function (string $component): void {
    $this->get(route('blade-components.' . $component))->assertOk()
        ->assertSee('id="' . $component . '-demo"', false)->assertSee('id="' . $component . '-usage"', false)
        ->assertSee('id="' . $component . '-attributes"', false)->assertSee('id="assets-and-interaction"', false)
        ->assertSee('data-demo-mode="blade"', false)->assertSee('data-usage-example', false)
        ->assertDontSee('data-demo-mode="livewire"', false)->assertDontSee('Shared field contract');
})->with(['tabs', 'timeline']);

it('preserves project form values while the server changes the active tab and refreshes content', function (): void {
    Livewire::test(TabsExample::class)->set('title', 'Launch project')->set('notes', 'Review on Friday')
        ->set('tab', 'notes')->assertSee('data-active="notes"', false)
        ->call('save')->assertHasNoErrors()->assertSet('revision', 1)->assertSet('title', 'Launch project')->assertSet('notes', 'Review on Friday')
        ->call('refreshExample')->assertSet('revision', 2)->assertSet('tab', 'notes')
        ->set('notesDisabled', true)->assertSee('data-selected="overview"', false)
        ->set('notesVisible', false)->assertDontSee('id="livewire-project-tabs-panel-notes"', false)
        ->set('visible', false)->assertDontSee('id="livewire-project-tabs"', false)
        ->set('visible', true)->assertSee('id="livewire-project-tabs"', false);
});

it('renders form nested Alpine and Dialog integration fixtures for tabs', function (): void {
    $this->get(route('development.tabs-timeline'))->assertOk()
        ->assertSee('id="blade-tabs-form"', false)->assertSee('id="nested-project-tabs"', false)
        ->assertSee('id="alpine-project-tabs"', false)->assertSee('id="dialog-project-tabs"', false);
});
