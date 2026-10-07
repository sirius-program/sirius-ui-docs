<x-layouts::app title="Avatar">
    <x-docs-page :navigation="['Avatar' => ['avatar-demo' => 'Demo', 'avatar-usage' => 'Usage', 'avatar-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Avatar</h1>
                <p>Identify a person or workspace with an image or initials.</p>
            </header>
            <section id="avatar-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.avatar-team')
                </div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.avatar-workspace')
                </div>
            </section>
            <section id="avatar-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.avatar')
            </section>
            <section id="avatar-attributes">
                @include('blade-components.attributes.avatar')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Image loading keeps the same space as the fallback. Changing the source retries the image; failed sources are never retried automatically.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <code>wire:key</code> for stable Livewire identity.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
