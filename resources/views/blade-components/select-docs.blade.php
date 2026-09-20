<x-layouts::app title="Select">
    <x-docs-page :navigation="['Select' => ['select-demo' => 'Demo', 'select-usage' => 'Usage', 'select-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'server-search' => 'Server search', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="select">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Select</h1>
                <p>Using <a href="https://tom-select.js.org/" target="_blank" class="text-blue-500 hover:underline">Tom Select</a> under the hood, a searchable select component with support for local and server search.</p>
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
                <p>Controls automatically associate labels, helpers, and validation errors. Laravel or Livewire supplies the error bags; application validation remains authoritative.</p>
                <p>Use nullable strings for single selections and arrays of strings for multiple selections. The ID 0 is preserved as the string "0". Native empty multiple selects omit their field; normalize missing arrays in your application. Validate submitted IDs against records the current user may select, including when options came from a remote endpoint. Disabled options and browser filtering are not authorization boundaries.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package stylesheet and JavaScript once in your application build, or publish <code>sirius-ui-assets</code> and load the published CSS and JavaScript.</p>
                @include('blade-components.examples.assets')
                <p>Tom Select 2.6.2 and its Apache-2.0 dependency notices are bundled internally. Use Tab to focus, type to search, arrows to navigate, Enter to select, and Escape to close. No CDN, key, or extra Alpine instance is needed. Local options remain a native select without JavaScript; remote searching and readonly protection require JavaScript.</p>
                <p>Livewire and Alpine model updates, native form resets, external form associations, multiple instances, and navigation are supported. Readonly retains submitted values; disabled fields are omitted. The package owns the enhanced DOM and tears it down on removal. Native event attributes remain on the original select; input/change events are forwarded when a selection changes.</p>
            </section>
            <section id="server-search" class="space-y-3">
                <h2 class="text-xl font-medium">Server search</h2>
                <p>Provide a same-origin endpoint returning JSON. Search requests send <code>q</code> and a one-based <code>page</code>. Label resolution sends <code>values[]</code>. Return <code>options</code> records with value, label, optional disabled/group, and a boolean <code>hasMore</code>. Labels are plain text. Supply initial options when available to avoid showing IDs while labels load.</p>
                @include('blade-components.examples.select-response')
                <p>Both Blade and Livewire use this endpoint with same-origin cookies. Add authentication, authorization, bounded inputs, rate limits, and authorized record scoping in the host application. Apply the same restrictions to label resolution and submission; never accept model names or query definitions from the client. This demo searches only a fixed, intentionally public venue catalog.</p>
                <p>New queries cancel previous requests and ignore stale responses. Selected options survive result-page changes. Load more retrieves the next page; loading, empty, and failure states are announced, with a Retry suffix icon after a failed request. Search status appears opposite the field label, separate from the helper text below the control. Search failures preserve selected values.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Override the <code>select</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. UI messages use the application's active locale and fallback locale.</p>
                @include('blade-components.examples.select-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
