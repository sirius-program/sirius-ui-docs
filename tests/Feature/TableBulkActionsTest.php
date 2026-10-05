<?php

declare(strict_types=1);

use App\Livewire\Examples\TableBulkActions;
use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Livewire\Livewire;

it('renders the bulk demo and resolves only explicitly linked scoped invoices', function (): void {
    $this->get(route('livewire-components.table.bulk-actions'))->assertOk()
        ->assertSee('id="bulk-invoices"', false)->assertSee('0 selected')->assertSee('data-usage-example', false)
        ->assertDontSee('Private billing note');
    $this->get(route('livewire-components.table.bulk-actions', ['ids' => [1, 3]]))
        ->assertSee('INV-1042, INV-1044')->assertSee('0 selected');
});

it('passes normalized selected IDs to application owned overlays and completes cleanup explicitly', function (): void {
    $parent = Livewire::test(TableBulkActions::class)->dispatch('invoice:bulk-review.bulk-invoices', ids: ['1', 3])
        ->assertSet('ids', [1, 3])->assertSet('numbers', ['INV-1042', 'INV-1044'])
        ->assertDispatched('dialog:show', id: 'bulk-invoices-review');
    $parent->call('beginReview')->assertHasErrors(['note' => 'required'])
        ->set('note', 'Ready for billing')->call('beginReview')->assertSet('loading', true)
        ->call('completeReview')->assertSet('loading', false)->assertSet('feedback', 'Reviewed 2 invoices: Ready for billing')
        ->assertDispatched('table:remove-selection.bulk-invoices', ids: [1, 3])
        ->assertDispatched('table:refresh.bulk-invoices')->assertDispatched('dialog:hide', id: 'bulk-invoices-review');
    $parent->dispatch('invoice:bulk-reminder.bulk-invoices', ids: [1])
        ->assertDispatched('dialog:show', id: 'bulk-invoices-confirm')->call('prepareReminders')
        ->assertDispatched('table:clear-selection.bulk-invoices');
    $parent->dispatch('invoice:bulk-details.bulk-invoices', ids: [3])
        ->assertSet('numbers', ['INV-1044'])->assertDispatched('dialog:show', id: 'bulk-invoices-details');
});

it('preserves selection on failure and cancellation and recovers external loading', function (): void {
    $parent = Livewire::test(TableBulkActions::class)->call('review', [1])->set('note', 'Checked')
        ->call('beginReview')->call('completeReview', true)->assertSet('loading', false)
        ->assertNotDispatched('table:remove-selection.bulk-invoices')->assertNotDispatched('dialog:hide')
        ->assertSet('feedback', 'Review failed. Retry or cancel; selection was kept.');
    $parent->call('beginReview')->assertSet('loading', true)->call('cancelReview')->assertSet('loading', false)
        ->assertNotDispatched('table:clear-selection.bulk-invoices');
});

it('rejects empty duplicate missing and malformed IDs instead of acting on every invoice', function (array $ids): void {
    Livewire::test(TableBulkActions::class)->call('review', $ids)->assertHasErrors()
        ->assertSet('ids', [])->assertNotDispatched('dialog:show');
})->with(['empty' => [[]], 'duplicates' => [[1, '1']], 'missing' => [[999]], 'nested' => [[['id' => 1]]], 'negative' => [[-1]], 'too many' => [array_fill(0, 201, 1)]]);

it('rejects unscoped IDs at preview and rechecks scope before completing a bulk action', function (): void {
    InvoiceSample::initialize(false);
    $allowed = DemoInvoice::factory()->create();
    $private = DemoInvoice::factory()->create(['workspace' => 'other']);
    Livewire::test(TableBulkActions::class)->call('review', [$private->getKey()])->assertHasErrors('ids')
        ->assertSet('ids', []);
    $parent = Livewire::test(TableBulkActions::class)->call('review', [$allowed->getKey()])
        ->set('note', 'Checked')->call('beginReview')->assertSet('loading', true);
    $allowed->update(['workspace' => 'other']);
    $parent->call('completeReview')->assertHasErrors('ids')->assertSet('loading', false)
        ->assertNotDispatched('table:remove-selection.bulk-invoices');
});

it('rejects invalid navigation IDs without exposing invoice data', function (): void {
    InvoiceSample::initialize(false);
    $private = DemoInvoice::factory()->create(['workspace' => 'other']);
    $this->get(route('livewire-components.table.bulk-actions', ['ids' => [$private->getKey()]]))
        ->assertSee('One or more invoices are unavailable. Choose them again.')->assertDontSee($private->number);
    $this->get(route('livewire-components.table.bulk-actions', ['ids' => 'wrong']))->assertSee('Choose an array of invoice IDs.');
});
