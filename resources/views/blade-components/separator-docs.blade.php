<x-layouts::app title="Separator">
    <x-docs-page :navigation="['Separator' => ['separator-demo' => 'Demo', 'separator-usage' => 'Usage', 'separator-attributes' => 'Attributes']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Separator</h1>
                <p>Separate related sections or inline items.</p>
            </header>
            <section id="separator-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.separator-billing')
                </div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
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
        </article>
    </x-docs-page>
</x-layouts::app>
