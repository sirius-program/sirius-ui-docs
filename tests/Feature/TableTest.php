<?php

declare(strict_types=1);

use App\Livewire\Examples\CollectionInvoiceTable;
use App\Livewire\Examples\ColumnInvoiceTable;
use App\Livewire\Examples\FilterInvoiceTable;
use App\Livewire\Examples\InvoiceTable;
use App\Livewire\Examples\TableActions;
use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Livewire\Livewire;

it('renders the Table docs without private fields and removes the invoice detail page', function (): void {
    $this->get(route('livewire-components.table'))->assertOk()->assertSee('INV-1042')
        ->assertSee('id="table-usage"', false)->assertSee('id="table-attributes"', false)
        ->assertSee('id="translations"', false)->assertSee('data-usage-example', false)->assertDontSee('Private billing note');
    $this->get('/livewire-components/invoices/1')->assertNotFound();
});

it('searches and paginates the Collection source demo without using the invoice database', function (): void {
    Livewire::test(CollectionInvoiceTable::class)->assertSee('1–2 · 2 shown of 4 data')
        ->call('goToPage', 2)->assertSee('Bright Books')->assertDontSee('Northstar Studio')
        ->set('search', 'northstar')->assertSet('page', 1)->assertSee('Northstar Studio')->assertSee('1 shown of 1 data');
});

it('formats the Columns demo with row context and renders its cell view', function (): void {
    InvoiceSample::initialize(false);
    DemoInvoice::factory()->create(['number' => 'INV-100', 'customer' => 'Northstar', 'status' => 'paid']);

    Livewire::test(ColumnInvoiceTable::class)->set('search', 'Northstar')->assertSee('$120.00 · Paid')->assertSee('Paid');
});

it('applies and resets the Filters demo through filters()', function (): void {
    Livewire::test(FilterInvoiceTable::class)->set('filters.issued', '2028-10-16')
        ->assertSee('10 shown of 11 data')->set('filters.status', 'pending')->assertSee('0 shown of 0 data')
        ->call('resetFilters')->assertSet('filters.issued', '')->assertSee('10 shown of 34 data');
});

it('applies application filters and cell views to the scoped invoice table', function (): void {
    InvoiceSample::initialize(false);
    DemoInvoice::factory()->create(['number' => 'INV-100', 'customer' => 'Northstar', 'status' => 'paid']);
    DemoInvoice::factory()->create(['number' => 'INV-200', 'workspace' => 'other', 'status' => 'paid']);

    Livewire::test(InvoiceTable::class)->set('filters.status', 'paid')->set('search', 'Northstar')
        ->assertSee('INV-100')->assertSee('$120.00')->assertDontSee('INV-200');
});

it('renders the existing invoice cell and action views with Collection array records', function (): void {
    $record = ['id' => 1, 'number' => 'INV-1042', 'status' => 'paid'];

    $this->view('livewire-components.demos.table-row-actions', ['record' => $record])
        ->assertSee('Review INV-1042')->assertSee('invoice:dialog')
        ->assertSee('href="#"', false)->assertSee('Open INV-1042');
    $this->view('livewire-components.demos.table-status', ['record' => $record])
        ->assertSee('Paid');
});

it('opens application-owned overlays and validates the review outside the Table', function (): void {
    InvoiceSample::initialize(false);
    $record = DemoInvoice::factory()->create(['number' => 'INV-100']);

    $parent = Livewire::test(TableActions::class)->dispatch('invoice:dialog', id: $record->getKey())
        ->assertDispatched('dialog:show', id: 'invoice-review')->assertSet('invoiceId', $record->getKey());
    $parent->call('saveReview')->assertHasErrors(['note' => 'required'])
        ->set('note', 'Ready for billing')->call('saveReview')->assertHasNoErrors()
        ->assertSet('feedback', 'INV-100: Ready for billing')->assertDispatched('table:refresh.invoice-table');
    $parent->dispatch('invoice:alert', id: $record->getKey())->assertDispatched('dialog:show', id: 'invoice-confirm');
    $parent->dispatch('invoice:slideover', id: $record->getKey())->assertDispatched('dialog:show', id: 'invoice-details');
});

it('rejects external action IDs outside the application workspace', function (): void {
    InvoiceSample::initialize(false);
    $record = DemoInvoice::factory()->create(['workspace' => 'other']);

    Livewire::test(TableActions::class)->dispatch('invoice:dialog', id: $record->getKey())->assertStatus(404);
});

it('loads two independent tables in the development fixture', function (): void {
    $this->get(route('development.table'))->assertOk()->assertSee('id="invoice-table"', false)->assertSee('id="second-table"', false);
});

it('searches and resolves remote filter options within the invoice scope', function (): void {
    InvoiceSample::initialize(false);
    foreach (['Alpha', 'Beta', 'Gamma'] as $customer) {
        DemoInvoice::factory()->create(['customer' => $customer]);
    }
    DemoInvoice::factory()->create(['customer' => 'Private', 'workspace' => 'other']);
    $url = route('livewire-components.table.customers');

    $this->getJson($url)->assertOk()->assertJsonCount(2, 'options')->assertJsonPath('hasMore', true);
    $this->getJson($url . '?page=2')->assertOk()->assertJsonPath('options.0.value', 'Gamma')->assertJsonPath('hasMore', false);
    $this->getJson($url . '?q=Bet')->assertOk()->assertJsonPath('options.0.label', 'Beta')->assertJsonCount(1, 'options');
    $this->getJson($url . '?' . http_build_query(['values' => ['Gamma', 'Private']]))
        ->assertOk()->assertJsonCount(1, 'options')->assertJsonPath('options.0.value', 'Gamma');
    $this->getJson($url . '?page=0')->assertUnprocessable();
    $this->getJson($url . '?values=invalid')->assertUnprocessable();
});
