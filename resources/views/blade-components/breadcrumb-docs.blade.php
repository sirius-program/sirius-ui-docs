<x-layouts::app title="Breadcrumb">
    <x-docs-page :navigation="['Breadcrumb' => ['breadcrumb-demo' => 'Demo', 'breadcrumb-usage' => 'Usage', 'breadcrumb-attributes' => 'Attributes', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">NAVIGATION</p>
                <h1 class="text-3xl font-semibold">Breadcrumb</h1>
                <p>Show where the current page belongs.</p>
            </header>
            <section id="breadcrumb-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.breadcrumb-project')
                </div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.breadcrumb-settings')
                </div>
            </section>
            <section id="breadcrumb-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.breadcrumb')
            </section>
            <section id="breadcrumb-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.breadcrumb')
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>breadcrumb</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.breadcrumb-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
