<x-layouts::app title="Icon">
    <x-docs-page :navigation="['Icon' => ['icon-demo' => 'Demo', 'icon-usage' => 'Usage', 'icon-attributes' => 'Attributes', 'included-icons' => 'Included icons', 'additional-icon-packs' => 'Additional icon packs', 'custom-icon-sets' => 'Custom icon sets', 'icon-cache' => 'Icon cache', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Icon</h1>
                <p>Icons with decorative or accessible names, powered by <x-sirius::link href="https://blade-ui-kit.com/blade-icons" target="_blank" rel="noopener noreferrer">Blade UI Kit - Blade Icon</x-sirius::link>. </p>
            </header>
            <section id="icon-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.icon-blade')
                </div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.icon-families')
                </div>
            </section>
            <section id="icon-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.icon')
            </section>
            <section id="icon-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.icon')
            </section>
            <section id="included-icons" class="space-y-3">
                <h2 class="text-xl font-medium">Included icons</h2>
                <p>Heroicons is the only icon pack included with Sirius UI. Its four families are available immediately:</p>
                <div class="overflow-x-auto rounded-xl border border-slate-300 dark:border-slate-600">
                    <table class="w-full text-left text-sm">
                        <thead><tr class="border-b border-slate-300 dark:border-slate-600"><th class="p-3">Family</th><th class="p-3">Prefix</th><th class="p-3">Source size</th></tr></thead>
                        <tbody>
                            <tr><td class="p-3">Outline</td><td class="p-3"><x-sirius::code>heroicon-o-*</x-sirius::code></td><td class="p-3">24 × 24</td></tr>
                            <tr><td class="p-3">Solid</td><td class="p-3"><x-sirius::code>heroicon-s-*</x-sirius::code></td><td class="p-3">24 × 24</td></tr>
                            <tr><td class="p-3">Mini</td><td class="p-3"><x-sirius::code>heroicon-m-*</x-sirius::code></td><td class="p-3">20 × 20</td></tr>
                            <tr><td class="p-3">Micro</td><td class="p-3"><x-sirius::code>heroicon-c-*</x-sirius::code></td><td class="p-3">16 × 16</td></tr>
                        </tbody>
                    </table>
                </div>
                <p>The family chooses the SVG design. Sirius <x-sirius::code>size</x-sirius::code> sets its displayed dimensions: <x-sirius::code>sm</x-sirius::code> is 1rem, <x-sirius::code>md</x-sirius::code> is 1.25rem, and <x-sirius::code>lg</x-sirius::code> is 1.5rem (16, 20, and 24px at the default root font size). The demo uses the same displayed size for all four families.</p>
                <p>Browse names in the <x-sirius::link href="https://github.com/driesvints/blade-heroicons/tree/2.7.0/resources/svg" target="_blank" rel="noopener noreferrer">installed Heroicons catalog</x-sirius::link>.</p>
            </section>
            <section id="additional-icon-packs" class="space-y-3">
                <h2 class="text-xl font-medium">Additional icon packs</h2>
                <p>Choose a pack from the <x-sirius::link href="https://github.com/driesvints/blade-icons#icon-packages" target="_blank" rel="noopener noreferrer">Blade Icons catalog</x-sirius::link> and install it in your application. Catalog packs are separate dependencies. For example, <x-sirius::link href="https://github.com/mallardduck/blade-lucide-icons#installation" target="_blank" rel="noopener noreferrer">Blade Lucide Icons</x-sirius::link> registers the <x-sirius::code>lucide</x-sirius::code> prefix:</p>
                @include('blade-components.examples.icon-lucide-install')
                <p>After installation, pass the registered name to Sirius Icon. This snippet requires Lucide and is not rendered by this docs project:</p>
                @include('blade-components.examples.icon-lucide-usage')
            </section>
            <section id="custom-icon-sets" class="space-y-3">
                <h2 class="text-xl font-medium">Custom icon sets</h2>
                <p>Publish the <x-sirius::link href="https://github.com/driesvints/blade-icons#defining-sets" target="_blank" rel="noopener noreferrer">Blade Icons configuration</x-sirius::link>:</p>
                @include('blade-components.examples.icon-publish-config')
                <p>Add a set to <x-sirius::code>config/blade-icons.php</x-sirius::code>, retaining other sets. Create <x-sirius::code>resources/svg</x-sirius::code> and place <x-sirius::code>project.svg</x-sirius::code> there. Use a unique prefix without dashes:</p>
                @include('blade-components.examples.icon-custom-config')
                @include('blade-components.examples.icon-custom-usage')
            </section>
            <section id="icon-cache" class="space-y-3">
                <h2 class="text-xl font-medium">Icon cache</h2>
                <p>Clear the icon cache before adding or changing sets. After changes, clear compiled views and rebuild the icon cache for deployment, as described in <x-sirius::link href="https://github.com/driesvints/blade-icons#caching" target="_blank" rel="noopener noreferrer">Blade Icons caching</x-sirius::link>:</p>
                @include('blade-components.examples.icon-cache')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Use label when the icon conveys information without adjacent text. Inside a named button, leave the icon decorative.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
