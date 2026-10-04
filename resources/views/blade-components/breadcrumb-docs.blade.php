<x-layouts::app title="Breadcrumb">
    <x-docs-page :navigation="['Breadcrumb' => ['breadcrumb-demo' => 'Demo', 'breadcrumb-usage' => 'Usage', 'breadcrumb-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">NAVIGATION</p>
                <h1 class="text-3xl font-semibold">Breadcrumb</h1>
                <p>Show where the current page belongs.</p>
            </header>
            <section id="breadcrumb-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.breadcrumb-project')
                </div>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.breadcrumb-settings')
                </div>
            </section>
            <section id="breadcrumb-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.breadcrumb')
            </section>
            <section id="breadcrumb-attributes">
                @include('blade-components.attributes.breadcrumb')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Breadcrumb requires only the package CSS. Links keep their native keyboard behavior; separators are decorative.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>breadcrumb</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.breadcrumb-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
