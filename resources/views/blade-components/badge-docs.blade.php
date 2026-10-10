<x-layouts::app title="Badge">
    <x-docs-page :navigation="['Badge' => ['badge-demo' => 'Demo', 'badge-usage' => 'Usage', 'badge-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Badge</h1>
                <p>Compact labels for status and counts.</p>
            </header>
            <section id="badge-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>@include('blade-components.demos.badge-blade')
                </div>
            </section>
            <section id="badge-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.badge')
            </section>
            <section id="badge-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.badge')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Include text so color is not the only status indicator. Badges do not announce changes automatically; use a live region when needed.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
