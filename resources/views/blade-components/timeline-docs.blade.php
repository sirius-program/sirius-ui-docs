<x-layouts::app title="Timeline">
    <x-docs-page :navigation="['Timeline' => ['timeline-demo' => 'Demo', 'timeline-usage' => 'Usage', 'timeline-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Timeline</h1>
                <p>Show progress or events in a vertical sequence.</p>
            </header>
            <section id="timeline-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">@include('blade-components.demos.timeline-onboarding')</div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">@include('blade-components.demos.timeline-delivery')</div>
            </section>
            <section id="timeline-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.timeline')
            </section>
            <section id="timeline-attributes">
                @include('blade-components.attributes.timeline')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS, or publish and load <code>sirius-ui-assets</code>. JavaScript is not required.</p>
                <p>Timeline only displays the supplied state. Your application owns progression, validation, and any actions. Mark one item as current when displaying a step sequence.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>timeline</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. These translations are used only for accessibility.</p>
                @include('blade-components.examples.timeline-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
