<?php

declare(strict_types=1);

use App\Livewire\Examples\ToastExample;
use Livewire\Livewire;

it('renders Toast docs with separate Blade examples attributes configuration and translations', function (): void {
    $this->get(route('blade-components.toast'))->assertOk()->assertSee('id="toast-demo"', false)
        ->assertSee('id="toast-usage"', false)->assertSee('id="toast-attributes"', false)
        ->assertSee('id="global-configuration"', false)->assertSee('id="translations"', false)
        ->assertSee('data-usage-example', false)->assertSee('data-demo-mode="blade"', false)
        ->assertDontSee('data-demo-mode="livewire"', false)->assertDontSee('Shared field contract');
});

it('dispatches ID based notifications and preserves bound state footer actions and content', function (): void {
    Livewire::test(ToastExample::class)->call('notify')->assertDispatched('toast:show', id: 'event-toast')
        ->assertSet('revision', 1)->assertSee('Delivery revision 1')
        ->set('open', true)->assertSee('data-open="true"', false)
        ->call('acknowledge')->assertSet('actions', 1)->assertSet('open', true)
        ->call('hideNotification')->assertDispatched('toast:hide', id: 'event-toast')
        ->set('visible', false)->assertDontSee('id="event-toast"', false)
        ->set('visible', true)->assertSee('id="event-toast"', false);
});

it('renders the queue Alpine and modal interaction fixture', function (): void {
    $this->get(route('development.toast'))->assertOk()->assertSee('id="queued-toast-25"', false)
        ->assertSee('id="alpine-toast"', false)->assertSee('id="toast-dialog"', false)
        ->assertSee('id="toast-slideover"', false);
});
