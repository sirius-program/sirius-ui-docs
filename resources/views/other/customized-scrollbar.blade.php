<x-layouts::app title="Customized Scrollbar">
    <x-docs-page :navigation="['Customized Scrollbar' => ['scrollbar-demo' => 'Demo', 'scrollbar-usage' => 'Usage', 'scrollbar-variables' => 'CSS variables', 'scrollbar-overrides' => 'Customization', 'scrollbar-support' => 'Browser support']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">OTHER</p>
                <h1 class="text-3xl font-semibold">Customized Scrollbar</h1>
                <p>Apply the package's rounded scrollbar with CSS.</p>
            </header>
            <section id="scrollbar-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="blade">
                    @include('other.demos.scrollbar')
                </div>
            </section>
            <section id="scrollbar-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                <p>Load Sirius CSS, then add <x-sirius::code>sir-scrollbar</x-sirius::code> to a scrolling element or its wrapper. It styles that element and its descendants. Give the scroll area a height or width limit and an overflow rule.</p>
                @include('other.examples.scrollbar')
                <p>For the whole page, add the class to <x-sirius::code>html</x-sirius::code>, as this docs project does. No JavaScript initialization is needed. Keep scroll areas keyboard-accessible with a useful name and a focus target.</p>
                @include('other.examples.scrollbar-page')
            </section>
            <section id="scrollbar-variables" class="space-y-3">
                <h2 class="text-xl font-medium">CSS variables</h2>
                <p>These variables inherit into nested scroll areas. Dark values follow a <x-sirius::code>dark</x-sirius::code> ancestor.</p>
                @include('other.attributes.scrollbar')
                <p>The track formula is the same in both themes; its surface and border inputs change with the theme.</p>
            </section>
            <section id="scrollbar-overrides" class="space-y-4">
                <h2 class="text-xl font-medium">Customization</h2>
                <p>Load overrides after Sirius CSS. This example changes the size, track, thumb, and hover colors only inside <x-sirius::code>brand-scrollbar</x-sirius::code>.</p>
                <div data-demo-mode="blade">
                    @include('other.demos.scrollbar-overrides')
                </div>
                @include('other.examples.scrollbar-overrides')
                <p>For an application-wide override, use <x-sirius::code>:root</x-sirius::code> for the light declarations and <x-sirius::code>.dark</x-sirius::code> for dark. Check contrast and visible focus after changing colors.</p>
            </section>
            <section id="scrollbar-support" class="space-y-3">
                <h2 class="text-xl font-medium">Browser support</h2>
                <p>Where <x-sirius::code>::-webkit-scrollbar</x-sirius::code> is supported, the thumb is rounded and the size/hover variables apply. Other browsers use the standard <x-sirius::code>scrollbar-width: thin</x-sirius::code> and thumb/track colors; exact pixel size and hover styling are not available through that fallback.</p>
                <p>Browser and operating-system settings control visibility and final appearance, including overlay scrollbars. In forced-colors mode, Sirius leaves scrollbar rendering to the browser.</p>
                <p>See MDN's <x-sirius::link href="https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/Properties/scrollbar-color" target="_blank" rel="noopener noreferrer">scrollbar-color</x-sirius::link> and <x-sirius::link href="https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/Selectors/::-webkit-scrollbar" target="_blank" rel="noopener noreferrer">WebKit scrollbar</x-sirius::link> references for compatibility.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
