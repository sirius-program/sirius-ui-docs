<x-docs-example view="livewire-components.demos.chart-extended-control" />
<p>For application actions, dispatch an event from a local callback:</p>
<x-docs-code language="JavaScript">const unregister = window.SiriusChart.register('extensions-chart', ({ wire }) => ({
    options: {
        plugins: { tooltip: { callbacks: {
            label: context => 'USD ' + context.parsed.y.toFixed(2)
        } } },
        onClick(event, points, chart) {
            if (!points.length) return;
            const point = points[0];
            wire.dispatch('sales:point-selected', {
                dataset: point.datasetIndex,
                index: point.index
            });
        }
    },
    plugins: [{
        id: 'areaOutline',
        afterDraw(chart) {
            if (!chart.chartArea) return;
            const { left, top, width, height } = chart.chartArea;
            chart.ctx.save();
            chart.ctx.strokeStyle = '#6366f1';
            chart.ctx.strokeRect(left, top, width, height);
            chart.ctx.restore();
        }
    }]
}));
// Call unregister() when the registration is no longer needed.</x-docs-code>
