<x-layouts::app :title="$title">
    @php
        $navigation = [];
        foreach ($examples as $example => $label) {
            $navigation[$label] = [$example.'-demo' => 'Demo', $example.'-usage' => 'Usage', $example.'-attributes' => 'Attributes'];
        }
        $navigation['Shared'] = ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction'];
    @endphp
    <x-docs-page :navigation="$navigation">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">{{ $title }}</h1>
                <p>Form controls with labels, helper text, and validation errors.</p>
                @if (session('basic-result'))<p role="status">Blade sample received. Nothing was stored.</p>@endif
            </header>
            @foreach ($examples as $example => $label)
                <section id="{{ $example }}" data-control-demo="{{ $example }}" class="space-y-5">
                    <h2 class="text-2xl font-semibold">{{ $label }}</h2>
                    <h3 id="{{ $example }}-demo" class="text-xl font-medium">Demo</h3>
                    <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="livewire">
                        <h4 class="font-medium">Livewire</h4>
                        <livewire:examples.basic-controls-example :kind="$example" :key="'docs-'.$example" />
                    </div>
                    <div id="{{ $example }}-blade" class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                        <h4 class="font-medium">Blade</h4>
                        @include('blade-components.demos.basic-blade', ['kind' => $example])
                    </div>
                    <div id="{{ $example }}-usage" class="space-y-4">
                        <h3 class="text-xl font-medium">Usage</h3>
                        @include('blade-components.examples.'.$example)
                    </div>
                    <div id="{{ $example }}-attributes">
                        @include('blade-components.attributes.basic-controls', ['kind' => $example])
                    </div>
                </section>
            @endforeach
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                @if ($control === 'choices')
                    <p>Use <code>&lt;x-sirius::field group&gt;</code> for checkboxes or radios to show one label, required marker, and error message. Validate selection counts on the server.</p>
                @endif
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                @if ($control === 'choices')
                    <p>Choice animations respect reduced-motion settings. Set <code>--sir-choice-duration</code> to change their speed, or <code>0ms</code> to disable them.</p>
                @endif
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Controls support Livewire updates and navigation. No extra Alpine instance is needed.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
