<x-layouts::app title="Checkbox, Radio & Switch">
    @php
        $examples = ['checkbox' => 'Checkbox', 'radio' => 'Radio', 'switch' => 'Switch'];
        $navigation = [];
        foreach ($examples as $example => $label) {
            $navigation[$label] = [$example.'-demo' => 'Demo', $example.'-usage' => 'Usage', $example.'-attributes' => 'Attributes'];
        }
        $navigation['Shared'] = ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Asset and interaction'];

    @endphp
    <x-docs-page :navigation="$navigation">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Checkbox, Radio &amp; Switch</h1>
                <p>Form controls with labels, helper text, and validation errors.</p>
                @if (session('basic-result'))<p role="status">Blade sample received. Nothing was stored.</p>@endif
            </header>
            @foreach ($examples as $example => $label)
                <section id="{{ $example }}" data-control-demo="{{ $example }}" class="space-y-5">
                    <h2 class="text-2xl font-semibold">{{ $label }}</h2>
                    <section id="{{ $example }}-demo" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                        <h3 class="font-medium">Livewire</h3>
                        <livewire:examples.basic-controls-example :kind="$example" :key="'docs-'.$example" />
                    </section>
                    <section id="{{ $example }}-blade" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                        <h3 class="font-medium">Blade</h3>
                        @include('blade-components.demos.'.$example.'-blade')
                    </section>
                    <section id="{{ $example }}-usage" class="space-y-4">
                        <h3 class="text-xl font-medium">Usage</h3>
                        @include('blade-components.examples.'.$example)
                    </section>
                    <section id="{{ $example }}-attributes" class="space-y-3">
                        <h3 class="text-xl font-medium">Attributes</h3>
                        @include('blade-components.attributes.'.$example)
                    </section>
                </section>
            @endforeach
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                <p>Use <x-sirius::code>&lt;x-sirius::field group&gt;</x-sirius::code> for checkboxes or radios to show one label, required marker, and error message. Validate selection counts on the server.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Asset and interaction</h2>
                <p>Choice animations respect reduced-motion settings. Set <x-sirius::code>--sir-choice-duration</x-sirius::code> to change their speed, or <x-sirius::code>0ms</x-sirius::code> to disable them.</p>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Controls support Livewire updates and navigation. No extra Alpine instance is needed.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
