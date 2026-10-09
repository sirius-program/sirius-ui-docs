<x-layouts::app title="Menu">
    <x-docs-page :navigation="['Menu' => ['menu-demo' => 'Demo', 'menu-usage' => 'Usage', 'menu-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">NAVIGATION</p>
                <h1 class="text-3xl font-semibold">Menu</h1>
                <p>Build workspace navigation with nested sections.</p>
            </header>
            <section id="menu-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.menu-workspace')
                </div>
            </section>
            <section id="menu-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.menu')
            </section>
            <section id="menu-attributes">
                @include('blade-components.attributes.menu')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Menu uses ordinary links and buttons. Tab moves through visible items; click, Enter, or Space opens a submenu. Left/Right arrows enter or leave a nested section.</p>
                <p>Use <x-sirius::code>menu.category</x-sirius::code> for a titled section and <x-sirius::code>menu.group</x-sirius::code> to group its items. Add <x-sirius::code>accordion</x-sirius::code> to make a group collapsible. Each group opens independently with click, Enter, or Space; plain groups stay visible.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <x-sirius::code>wire:key</x-sirius::code> for stable Livewire identity.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>menu</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.menu-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
