<x-layouts::app title="Input">
    <x-docs-page :navigation="['Input' => ['input-demo' => 'Demo', 'input-usage' => 'Usage', 'input-attributes' => 'Attributes', 'assets-and-interaction' => 'Asset and interaction', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="input">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Input</h1>
                <p>Text, number, and password inputs.</p>
                @if (session('basic-result'))<p role="status">Blade sample received. Nothing was stored.</p>@endif
            </header>
            <section id="input-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.basic-controls-example kind="input" />
                </div>
                <div id="input-blade" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.input-blade')
                </div>
            </section>
            <section id="input-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.input')
            </section>
            <section id="input-attributes">
                @include('blade-components.attributes.input')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Asset and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Controls support Livewire updates and navigation. No extra Alpine instance is needed.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>These translation strings are used only for accessibility.</p>
                <p>Edit the <x-sirius::code>input</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>.</p>
                @include('blade-components.examples.input-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
