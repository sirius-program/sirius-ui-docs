<x-layouts::app title="Select">
    <x-docs-page :navigation="['Select' => ['select-demo' => 'Demo', 'select-usage' => 'Usage', 'select-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'server-search' => 'Server search', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="select">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Select</h1>
                <p>Searchable single or multiple selections, powered by <a href="https://tom-select.js.org/" target="_blank" class="text-blue-500 dark:text-blue-400 hover:underline">Tom Select</a>.</p>
            </header>
            <section id="select-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.select-example />
                </div>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.select-blade')
                </div>
            </section>
            <section id="select-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.select')
            </section>
            <section id="select-attributes">
                @include('blade-components.attributes.select')
            </section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                <p>Use a nullable string for one selection or an array of strings for multiple selections. The value <code>0</code> becomes <code>"0"</code>. Native forms omit empty multiple fields, so normalize missing values to an array. Validate that submitted IDs are allowed for the current user.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Tom Select is bundled. Without JavaScript, local options use a native select; remote search and readonly need JavaScript.</p>
                <p>Livewire/Alpine updates and form resets keep selections in sync. Readonly values are submitted; disabled values are omitted. Input/change events reach the original select.</p>
            </section>
            <section id="server-search" class="space-y-3">
                <h2 class="text-xl font-medium">Server search</h2>
                <p>Use a same-origin JSON endpoint. Searches send <code>q</code> and a one-based <code>page</code>; label lookups send <code>values[]</code>. Return <code>options</code> and <code>hasMore</code> as shown below. Labels are plain text. Initial options avoid showing IDs while labels load.</p>
                @include('blade-components.examples.select-response')
                <p>Apply the same access rules to search, label lookup, and submitted IDs. Bound query inputs and rate-limit the endpoint. The demo uses a public venue list.</p>
                <p>New searches replace pending requests and preserve selected values. Load more fetches the next page. Status appears beside the label; failed requests show a Retry button.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Edit the <code>select</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. Messages follow the application locale and fallback locale.</p>
                @include('blade-components.examples.select-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
