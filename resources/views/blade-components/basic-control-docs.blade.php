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
                <p>Native and customized form behavior, with shared labels and validation.</p>
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
                <p>Application validation remains authoritative. Controls link labels, helpers, and errors automatically; Laravel or Livewire supplies the error bag.</p>
                @if ($control === 'choices')
                    <p>Wrap related checkboxes or radios in <code>&lt;x-sirius::field group&gt;</code> with a group label and error key. Validation messages and required markers appear once per group. For minimum checkbox selections, validate the array on the server instead of requiring every option.</p>
                @endif
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                @if ($control === 'choices')
                    <p>Checkboxes and radios gently pop when selected; switches slide smoothly between states. Motion respects the system's reduced-motion preference. Customize <code>--sir-choice-duration</code> (default <code>180ms</code>); set it to <code>0ms</code> to disable these animations. No additional library is required.</p>
                @endif
                <p>Import the package stylesheet and JavaScript once in your application build, or publish the <code>sirius-ui-assets</code> tag and load the published CSS and JavaScript. Docs imports both from the locally installed package.</p>
                @include('blade-components.examples.assets')
                <p>The package script initializes controls once and supports Livewire navigation and remounts without an extra Alpine instance or runtime CDN.</p>
                @if ($control === 'choices')
                    <p>Tab moves focus. Space toggles checkboxes and switches; arrow keys navigate native radio groups. Labels activate their associated controls.</p>
                @endif
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
