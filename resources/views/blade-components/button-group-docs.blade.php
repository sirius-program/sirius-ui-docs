<x-layouts::app title="Button Group">
    <x-docs-page :navigation="['Button Group' => ['button-group-demo' => 'Demo', 'button-group-usage' => 'Usage', 'button-group-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Button Group</h1>
                <p>Related actions with connected borders.</p>
            </header>
            <section id="button-group-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>@include('blade-components.demos.button-group-blade')
                </div>
            </section>
            <section id="button-group-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.button-group')
            </section>
            <section id="button-group-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.button-group')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Give the group a short accessible name. Each button keeps its own action and accessible name.</p>
                <p>Place Button components directly inside the group. It does not add selection state, arrow-key navigation, or toggle behavior.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
