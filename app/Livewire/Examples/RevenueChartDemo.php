<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

final class RevenueChartDemo extends Component
{
    #[Locked]
    public string $chartId = 'revenue-chart';

    #[Locked]
    public string $mode = 'overview';

    public string $type = 'bar';

    /** @var array<string, mixed> */
    public array $data = [];

    /** @var array<string, mixed> */
    public array $options = [];

    public int $height = 320;

    public bool $loading = false;

    public bool $visible = true;

    #[Locked]
    public string $selectedPoint = '';

    public function mount(): void
    {
        abort_unless(in_array($this->mode, ['overview', 'data', 'options', 'extensions', 'development'], true), 422);
        $this->resetSample();
    }

    public function resetSample(): void
    {
        $this->type = 'bar';
        $revenue = collect(['Jan' => 1200, 'Feb' => 1500, 'Mar' => 1800, 'Apr' => 2100]);
        $this->data = ['labels' => $revenue->keys()->all(), 'datasets' => [
            ['label' => 'Revenue (USD)', 'data' => $revenue->values()->all()],
        ]];
        $this->options = ['plugins' => ['legend' => ['position' => 'bottom']], 'scales' => ['y' => ['beginAtZero' => true]]];
        $this->height = 320;
        $this->loading = false;
        $this->selectedPoint = '';
    }

    #[On('revenue:point-selected')]
    public function readPoint(string $chart, int $dataset, int $index): void
    {
        abort_unless($chart === $this->chartId, 403);
        abort_unless($dataset >= 0 && $index >= 0, 422);
        $month = data_get($this->data, 'labels.' . $index);
        $amount = data_get($this->data, 'datasets.' . $dataset . '.data.' . $index);
        abort_unless(is_string($month) && (is_int($amount) || is_float($amount)), 422);
        $this->selectedPoint = $month . ': ' . $amount;
    }

    public function loadProjection(): void
    {
        $this->data['datasets'] = [['label' => 'Revenue (USD)', 'data' => [1400, 1700, 2200, 2600]]];
    }

    public function clearData(): void
    {
        $this->data = ['labels' => [], 'datasets' => []];
    }

    public function changeType(): void
    {
        $this->type = $this->type === 'bar' ? 'line' : 'bar';
    }

    public function changeOptions(): void
    {
        $this->options['plugins']['legend']['display'] = !($this->options['plugins']['legend']['display'] ?? true);
        $this->height = $this->height === 320 ? 240 : 320;
    }

    public function render(): View
    {
        return view('livewire.examples.revenue-chart-demo');
    }
}
