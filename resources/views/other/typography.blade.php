<x-layouts::app title="Typography">
    <x-docs-page :navigation="['Typography' => ['typography-demo' => 'Demo', 'typography-usage' => 'Usage', 'typography-fonts' => 'Default fonts', 'typography-tokens' => 'CSS tokens', 'typography-sizes' => 'Font sizes', 'typography-overrides' => 'Customization', 'typography-loading' => 'Custom fonts']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">OTHER</p>
                <h1 class="text-3xl font-semibold">Typography</h1>
                <p>Choose font families and sizes with CSS tokens.</p>
            </header>
            <section id="typography-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <p>Sirius keeps your application's fonts by default. This preview uses the docs' Instrument Sans font.</p>
                <div data-demo-mode="blade">
                    @include('other.demos.typography')
                </div>
            </section>
            <section id="typography-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('other.examples.typography')
            </section>
            <section id="typography-fonts" class="space-y-3">
                <h2 class="text-xl font-medium">Default fonts</h2>
                <p>The package does not download a web font. Existing application and browser fonts remain in effect until you override them.</p>
                <ul class="list-disc space-y-2 pl-5">
                    <li>Main text follows the application's existing styles.</li>
                    <li>Inline Code uses Tailwind's <x-sirius::code>--font-mono</x-sirius::code> stack when available, falling back to <x-sirius::code>ui-monospace, monospace</x-sirius::code>.</li>
                    <li>Code's <x-sirius::code>block</x-sirius::code> mode inherits the font of its container, usually <x-sirius::code>pre</x-sirius::code>.</li>
                    <li>Richtext keyboard hints use the main font token when set, otherwise their system sans-serif stack.</li>
                </ul>
                <p>These docs load Instrument Sans separately. Their <x-sirius::code>--docs-font-family</x-sirius::code> and <x-sirius::code>--docs-font-family-mono</x-sirius::code> tokens also connect to Tailwind's <x-sirius::code>font-sans</x-sirius::code> and <x-sirius::code>font-mono</x-sirius::code> utilities.</p>
            </section>
            <section id="typography-tokens" class="space-y-3">
                <h2 class="text-xl font-medium">CSS tokens</h2>
                <p>Set these tokens on <x-sirius::code>:root</x-sirius::code> or a component's container. The default <x-sirius::code>initial</x-sirius::code> leaves existing font choices in effect.</p>
                @include('other.attributes.typography-families')
            </section>
            <section id="typography-sizes" class="space-y-3">
                <h2 class="text-xl font-medium">Font sizes</h2>
                <div data-demo-mode="blade">
                    @include('other.demos.typography-sizes')
                </div>
                @include('other.attributes.typography-sizes')
                <p>Code and Link keep the surrounding text size. Labels and native controls inherit their field size. Each size token is independent; changing <x-sirius::code>--sir-font-size-base</x-sirius::code> does not scale every size.</p>
                @include('other.examples.typography-sizes')
            </section>
            <section id="typography-overrides" class="space-y-4">
                <h2 class="text-xl font-medium">Customization</h2>
                <p>Load your overrides after Sirius CSS. Use <x-sirius::code>:root</x-sirius::code> to change fonts throughout your application.</p>
                @include('other.examples.typography-global')
                <p>For a scoped override, put the tokens on a wrapper. This example uses system fonts and maps the docs' font tokens to the same families.</p>
                <div data-demo-mode="blade">
                    @include('other.demos.typography-overrides')
                </div>
                @include('other.examples.typography-overrides')
            </section>
            <section id="typography-loading" class="space-y-3">
                <h2 class="text-xl font-medium">Custom fonts</h2>
                <p>Place your font file in <x-sirius::code>public/fonts</x-sirius::code>, declare it with <x-sirius::code>@font-face</x-sirius::code>, then set the token. Add declarations for other weights or styles you use.</p>
                @include('other.examples.typography-font-face')
                <p>Choosing a font family does not load its files. Keep a fallback family such as <x-sirius::code>sans-serif</x-sirius::code> or <x-sirius::code>monospace</x-sirius::code>.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
