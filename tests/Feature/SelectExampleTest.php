<?php

declare(strict_types=1);

use App\Livewire\Examples\SelectExample;
use Livewire\Livewire;

it('renders select docs and separate copyable native examples', function (): void {
    $this->get(route('blade-components.select'))->assertSee('Select')->assertSee('data-select-example', false)->assertSee('blade-select-shipping')->assertSee('Server search');
});

it('paginates and resolves only public venue options with bounded input', function (): void {
    $this->getJson(route('blade-components.select.options'))->assertJsonCount(2, 'options')->assertJsonPath('hasMore', true);
    $this->getJson(route('blade-components.select.options', ['page' => 3]))->assertJsonCount(1, 'options')->assertJsonPath('hasMore', false);
    $this->getJson(route('blade-components.select.options', ['q' => 'Bali']))->assertJsonPath('options.0.value', 'bali')->assertJsonCount(1, 'options');
    $this->getJson(route('blade-components.select.options', ['values' => ['bali', 'private-venue']]))->assertJsonCount(1, 'options')->assertJsonPath('options.0.label', 'Bali garden pavilion');
    $this->getJson(route('blade-components.select.options', ['q' => str_repeat('a', 101), 'page' => -1]))->assertUnprocessable()->assertJsonValidationErrors(['q', 'page']);
});

it('validates native selections including disabled and unauthorized IDs', function (): void {
    $this->from(route('blade-components.select'))->post(route('blade-components.select.store'), ['action' => 'validate', 'shipping' => '0', 'topics' => ['design'], 'venue' => 'bali'])->assertSessionHas('select_saved', true)->assertSessionHas('select_sample.shipping', '0');
    $this->post(route('blade-components.select.store'), ['action' => 'validate', 'shipping' => 'drone', 'topics' => ['unknown'], 'venue' => 'private-venue'])->assertSessionHasErrors(['shipping', 'topics.0', 'venue'], errorBag: 'select');
});

it('loads validates and resets Livewire selections', function (): void {
    Livewire::test(SelectExample::class)->call('save')->assertHasErrors(['shipping', 'topics', 'venue'])
        ->call('loadExample')->assertSet('shipping', '0')->assertSet('topics', ['design', 'research'])->call('save')->assertHasNoErrors()
        ->set('venue', 'private-venue')->call('save')->assertHasErrors('venue')
        ->call('resetExample')->assertSet('shipping', null)->assertSet('topics', []);
});
