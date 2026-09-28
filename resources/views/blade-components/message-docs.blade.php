<x-layouts::app title="Message">
    <x-docs-page :navigation="['Message' => ['message-demo' => 'Demo', 'message-usage' => 'Usage', 'message-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Message</h1>
                <p>Inline feedback with optional dismissal.</p>
            </header>
            <section id="message-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>@include('blade-components.demos.message-blade')
                </div>
            </section>
            <section id="message-usage" class="space-y-4"><h2 class="text-xl font-medium">Usage</h2>@include('blade-components.examples.message')</section>
            <section id="message-attributes">@include('blade-components.attributes.message')</section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Dismissal is local to the current element and survives ordinary Livewire updates. Change reset-key or remount the component to show it again. The bubbling message:dismiss event includes detail.id; it does not update your model automatically.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>message</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.message-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
