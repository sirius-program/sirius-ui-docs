<x-layouts::app title="Icon">
    <x-docs-page :navigation="['Icon' => ['icon-demo' => 'Demo', 'icon-usage' => 'Usage', 'icon-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Icon</h1>
                <p>Icons with decorative or accessible names, powered by <a href="https://blade-ui-kit.com/blade-icons" target="_blank" rel="noopener noreferrer" class="text-blue-500 dark:text-blue-400 hover:underline">Blade UI Kit - Blade Icon</a>. </p>
            </header>
            <section id="icon-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.icon-blade')
                </div>
            </section>
            <section id="icon-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.icon')
            </section>
            <section id="icon-attributes">
                @include('blade-components.attributes.icon')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Use label when the icon conveys information without adjacent text. Inside a named button, leave the icon decorative.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
