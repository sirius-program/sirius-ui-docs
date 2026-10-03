<x-layouts::app title="Separator">
    <x-docs-page :navigation="['Separator' => ['separator-demo' => 'Demo', 'separator-usage' => 'Usage', 'separator-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Separator</h1>
                <p>Separate related sections or inline items.</p>
            </header>
            <section id="separator-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.separator-billing')
                </div>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.separator-navigation')
                </div>
            </section>
            <section id="separator-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.separator')
            </section>
            <section id="separator-attributes">
                @include('blade-components.attributes.separator')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Separator requires only the package CSS. Livewire can update its content without additional setup.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
