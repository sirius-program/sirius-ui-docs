<x-layouts::app title="Skeleton">
    <x-docs-page :navigation="['Skeleton' => ['skeleton-demo' => 'Demo', 'skeleton-usage' => 'Usage', 'skeleton-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Skeleton</h1>
                <p>Reserve space while content loads.</p>
            </header>
            <section id="skeleton-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
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
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Skeleton requires only the package CSS. Livewire can update its content without additional setup.</p>
                <p>The fade stops when reduced motion is enabled. Put loading announcements and <code>aria-busy</code> on the surrounding content.</p>
                <p>Dimensions support px, rem, em, %, vw/vh, dvw/dvh, vmin/vmax, and ch. Use classes or styles for other sizing.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
