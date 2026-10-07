<x-layouts::app title="Textarea">
    <x-docs-page :navigation="['Textarea' => ['textarea-demo' => 'Demo', 'textarea-usage' => 'Usage', 'textarea-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Asset and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="textarea">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Textarea</h1>
                <p>Plain text with adjustable height.</p>
                @if (session('basic-result'))<p role="status">Blade sample received. Nothing was stored.</p>@endif
            </header>
            <section id="textarea-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.basic-controls-example kind="textarea" />
                </div>
                <div id="textarea-blade" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.textarea-blade')
                </div>
            </section>
            <section id="textarea-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.textarea')
            </section>
            <section id="textarea-attributes">
                @include('blade-components.attributes.textarea')
            </section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Asset and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Controls support Livewire updates and navigation. No extra Alpine instance is needed.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
