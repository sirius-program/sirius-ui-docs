<div x-data="{ unregister: null, init() {
            this.unregister = window.SiriusChart.register(@js($chartId), ({ wire }) => ({
                options: {
                    plugins: { tooltip: { callbacks: { label: context => context.dataset.label + ': ' + new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y) } } },
                    onClick: (event, elements) => { if (elements.length) wire.dispatch('revenue:point-selected', { chart: @js($chartId), dataset: elements[0].datasetIndex, index: elements[0].index }); }
                },
                plugins: [{ id: 'areaOutline', afterDraw(chart) {
                    if (!chart.chartArea) return;
                    const { left, top, width, height } = chart.chartArea;
                    chart.ctx.save(); chart.ctx.strokeStyle = '#6366f1'; chart.ctx.strokeRect(left, top, width, height); chart.ctx.restore();
                } }]
            }));
        }, destroy() { this.unregister?.(); } }">
            @include('livewire-components.demos.chart-control')
            <p class="mt-3 text-sm" data-chart-selection>{{ $selectedPoint ?: 'Click a bar to read its value.' }}</p>
        </div>
