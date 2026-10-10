<x-layouts::app title="Dropdown">
    <x-docs-page :navigation="['Dropdown' => ['dropdown-demo' => 'Demo', 'dropdown-usage' => 'Usage', 'dropdown-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">NAVIGATION</p>
                <h1 class="text-3xl font-semibold">Dropdown</h1>
                <p>Keep related actions in a compact menu.</p>
            </header>
            <section id="dropdown-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.dropdown-invoice')
                </div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.dropdown-workspace')
                </div>
            </section>
            <section id="dropdown-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.dropdown')
            </section>
            <section id="dropdown-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.dropdown')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Enter, Space, or Down/Up opens the menu. Up/Down, Home/End, and typing a name move focus; Right/Left enters or leaves a submenu. Escape closes the current menu, and Tab leaves it. Disabled items remain focusable but cannot run actions.</p>
                <p>Actions close the menu and return focus to its trigger. Outside click closes it without moving focus. Opening another Dropdown closes the previous one. Submenus support touch and menus can scroll; fades respect reduced motion.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <x-sirius::code>wire:key</x-sirius::code> for stable Livewire identity.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Listen for <x-sirius::code>dropdown:open</x-sirius::code> and <x-sirius::code>dropdown:close</x-sirius::code> on the root. Both events bubble and include <x-sirius::code>event.detail.id</x-sirius::code>. Client open state survives unrelated Livewire updates.</p>
                <p>Dropdown items use action-menu semantics; use Menu for persistent page navigation. Put badges or shortcuts in <x-sirius::code>trailing</x-sirius::code>, and keep item content free of nested interactive controls.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
