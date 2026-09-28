<x-layouts::app title="Slider">
    <x-docs-page :navigation="['Slider' => ['slider-demo' => 'Demo', 'slider-usage' => 'Usage', 'slider-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Slider</h1>
                <p>Choose a number or an ordered range.</p>
            </header>
            <section id="slider-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.slider-example />
                </div>
                <div id="slider-blade" class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.slider-blade')
                </div>
            </section>
            <section id="slider-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.slider')
            </section>
            <section id="slider-attributes">
                @include('blade-components.attributes.slider')
            </section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                <p>Range handles share one label and error area. Use <code>error-key="budget*"</code> to include errors for both the array and its entries.</p>
                <p>Values must be finite, within their bounds, and on their step grid. Range handles cannot cross. Invalid PHP values throw a configuration error; invalid bound values keep the last valid selection and show an error. Validate submitted values on the server too.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Controls support Livewire updates and navigation. No extra Alpine instance is needed.</p>
                <p>Drag a handle or click the track. Arrow keys move one step; Page Up/Down move ten. Home/End move to the current limits. Without JavaScript, the control provides numeric inputs.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>slider</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.slider-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
