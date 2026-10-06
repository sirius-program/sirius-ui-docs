<?php

declare(strict_types=1);

use App\Livewire\Examples\InvoiceChartDemo;
use App\Livewire\Examples\RevenueChartDemo;
use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Livewire\Livewire;

it('renders separate Chart topics with their own working examples', function (string $topic, string $chartId): void {
    $route = 'livewire-components.chart' . ($topic === '' ? '' : '.' . $topic);
    $this->get(route($route))->assertOk()->assertViewIs('livewire-components.chart' . ($topic === '' ? '' : '-' . $topic) . '-docs')
        ->assertSee('id="' . $chartId . '"', false)->assertSee('data-usage-example', false)->assertSee('role="img"', false)
        ->assertDontSee('Toggle chart')->assertDontSee('Toggle loading')
        ->assertDontSee('Monthly revenue (USD)')->assertDontSee('Revenue in USD. The table below contains the same values.');
})->with([['', 'revenue-chart'], ['data', 'invoice-chart'], ['extensions', 'extensions-chart'], ['options', 'options-chart']]);

it('updates chart data and configuration in the owning application component', function (): void {
    $test = Livewire::test(RevenueChartDemo::class);
    $test->call('loadProjection')->assertSet('data.datasets.0.data', [1400, 1700, 2200, 2600])
        ->call('changeType')->assertSet('type', 'line')
        ->call('changeOptions')->assertSet('height', 240)->assertSet('options.plugins.legend.display', false)
        ->call('clearData')->assertSet('data.datasets', [])
        ->call('resetSample')->assertSet('height', 320)->assertSet('data.datasets.0.data', [1200, 1500, 1800, 2100]);
});

it('aggregates only scoped Eloquent records for the chart', function (): void {
    InvoiceSample::initialize(false);
    DemoInvoice::factory()->create(['status' => 'paid', 'amount' => 12345, 'workspace' => 'design']);
    DemoInvoice::factory()->create(['status' => 'paid', 'amount' => 555, 'workspace' => 'design']);
    DemoInvoice::factory()->create(['status' => 'paid', 'amount' => 99999, 'workspace' => 'private']);
    Livewire::test(InvoiceChartDemo::class)->assertViewHas('data', [
        'labels' => ['paid'], 'datasets' => [['label' => 'Invoice total (USD)', 'data' => [129.0]]],
    ])->assertSee('id="invoice-chart"', false)->assertDontSee('999.99');
});

it('serves the chart integration fixture only in development environments', function (): void {
    $this->get(route('development.chart'))->assertOk()->assertSee('id="time-chart"', false)->assertSee('id="dialog-chart"', false)
        ->assertSee('Toggle chart')->assertSee('Toggle loading');
});

it('resolves local point callbacks from current server data and rejects unrelated or missing points', function (): void {
    Livewire::test(RevenueChartDemo::class)->call('loadProjection')
        ->dispatch('revenue:point-selected', chart: 'revenue-chart', dataset: 0, index: 0)
        ->assertSet('selectedPoint', 'Jan: 1400');
    Livewire::test(RevenueChartDemo::class)->call('readPoint', 'another-chart', 0, 0)->assertForbidden();
    Livewire::test(RevenueChartDemo::class)->call('readPoint', 'revenue-chart', 0, 99)->assertUnprocessable();
});
