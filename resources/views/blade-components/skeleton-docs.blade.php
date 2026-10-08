<x-layouts::app title="Skeleton">
    <x-docs-page :navigation="['Skeleton' => ['skeleton-demo' => 'Demo', 'skeleton-usage' => 'Usage', 'skeleton-attributes' => 'Attributes']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Skeleton</h1>
                <p>Reserve space while content loads.</p>
            </header>
            <section id="skeleton-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.skeleton-project')
                </div>
            </section>
            <section id="skeleton-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.skeleton')
            </section>
            <section id="skeleton-attributes">
                @include('blade-components.attributes.skeleton')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
