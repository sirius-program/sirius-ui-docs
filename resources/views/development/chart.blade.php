<x-layouts::app title="Chart integration">
    <x-docs-page :navigation="[]">
        <div class="min-w-0 space-y-8">
            <h1 class="text-2xl font-semibold">Chart integration</h1>
            <livewire:examples.revenue-chart-demo mode="development" />
            @php($basicData = ['labels' => ['Jan', 'Feb', 'Mar'], 'datasets' => [['label' => 'Visits', 'data' => [20, 35, 28]]]])
            <livewire:sirius::chart id="second-chart" :data="$basicData" label="Independent visits" />
            <x-sirius::tabs id="chart-tabs" label="Chart panels" :items="['summary' => 'Summary', 'chart' => 'Chart']">
                <x-slot:panel-summary>Open the Chart tab to view the hidden chart.</x-slot:panel-summary>
                <x-slot:panel-chart><livewire:sirius::chart id="tab-chart" :data="$basicData" label="Visits in Tabs" /></x-slot:panel-chart>
            </x-sirius::tabs>
            <x-sirius::button data-sir-dialog-open="chart-dialog">Open chart dialog</x-sirius::button>
            <x-sirius::dialog id="chart-dialog" header="Chart in Dialog" size="xl">
                <livewire:sirius::chart id="dialog-chart" :data="$basicData" label="Visits in Dialog" />
            </x-sirius::dialog>
            <x-sirius::button data-sir-dialog-open="chart-slideover">Open chart slideover</x-sirius::button>
            <x-sirius::slideover id="chart-slideover" header="Chart in Slideover" size="xl">
                <livewire:sirius::chart id="slideover-chart" :data="$basicData" label="Visits in Slideover" />
            </x-sirius::slideover>
            @foreach(['bar', 'line', 'pie', 'doughnut', 'radar', 'polarArea', 'scatter', 'bubble'] as $type)
                @php($points = in_array($type, ['scatter', 'bubble'], true) ? ['datasets' => [['label' => 'Points', 'data' => [['x' => 1, 'y' => 5, 'r' => 6], ['x' => 2, 'y' => 8, 'r' => 10]]]]] : $basicData)
                <livewire:sirius::chart :id="'native-'.$type" :type="$type" :data="$points" :height="220" :label="$type.' chart'" :key="$type" />
            @endforeach
            <livewire:sirius::chart id="mixed-chart" :data="['labels' => ['Jan', 'Feb'], 'datasets' => [['type' => 'bar', 'data' => [20, 35]], ['type' => 'line', 'data' => [25, 25]]]]" label="Mixed bar and line" />
            <livewire:sirius::chart id="time-chart" type="line" :data="['datasets' => [['label' => 'Visits', 'data' => [['x' => '2028-01-01', 'y' => 20], ['x' => '2028-01-02', 'y' => 35]]]]]"
                :options="['scales' => ['x' => ['type' => 'time', 'time' => ['unit' => 'day']]]]" label="Visits by date" />
            <livewire:sirius::chart id="static-chart" :data="$basicData" :width="400" :height="200" :options="['responsive' => false]" label="Fixed size chart" />
            <livewire:sirius::chart id="invalid-chart" type="unknownController" :data="$basicData" label="Render error fixture" />
        </div>
    </x-docs-page>
</x-layouts::app>
