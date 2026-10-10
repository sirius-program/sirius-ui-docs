<x-layouts::app title="Timeline">
    <x-docs-page :navigation="['Timeline' => ['timeline-demo' => 'Demo', 'timeline-usage' => 'Usage', 'timeline-attributes' => 'Attributes', 'translations' => 'Translations']]">
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
            <section id="timeline-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.timeline')
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>timeline</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>. These translations are used only for accessibility.</p>
                @include('blade-components.examples.timeline-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
