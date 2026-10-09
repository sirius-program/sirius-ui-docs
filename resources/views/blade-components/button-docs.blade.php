<x-layouts::app title="Button">
    <x-docs-page :navigation="['Button' => ['button-demo' => 'Demo', 'button-usage' => 'Usage', 'button-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Button</h1>
                <p>Actions and links with consistent styles.</p>
            </header>
            <section id="button-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.button-blade')
                </div>
            </section>
            <section id="button-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.button')
            </section>
            <section id="button-attributes">
                @include('blade-components.attributes.button')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>An icon-only button needs aria-label or aria-labelledby. Use type=submit inside a form.</p>
                <p>Bind loading explicitly when needed. For Livewire requests, wire:loading.attr="disabled" disables a real button while the request is pending. Application actions still need authorization.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
