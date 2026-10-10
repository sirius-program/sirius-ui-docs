<x-layouts::app title="Colors">
    <x-docs-page :navigation="['Colors' => ['colors-demo' => 'Demo', 'colors-usage' => 'Usage', 'tailwind-colors' => 'Tailwind equivalents', 'color-tokens' => 'CSS tokens', 'color-overrides' => 'Customization']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">OTHER</p>
                <h1 class="text-3xl font-semibold">Colors</h1>
                <p>Semantic variants, their Tailwind colors, and CSS overrides.</p>
            </header>
            <section id="colors-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('other.demos.colors-variants')
                </div>
            </section>
            <section id="colors-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('other.examples.colors-variants')
            </section>
            <section id="tailwind-colors" class="space-y-3">
                <h2 class="text-xl font-medium">Tailwind equivalents</h2>
                <p>Filled presentation variants use these background, text, and border colors. The light shades are 100/900/300; dark shades are 950/200/700. Sirius reads Tailwind's <x-sirius::code>--color-*</x-sirius::code> variables, so your Tailwind theme can change their values.</p>
                @include('other.attributes.colors-variants')
                <p><x-sirius::code>info</x-sirius::code> mixes 75% surface with 25% border for its background, using the normal text and border tokens. It has no single named Tailwind shade.</p>
                <p><x-sirius::code>ghost</x-sirius::code> and <x-sirius::code>outline</x-sirius::code> are transparent treatments supported by some components; Button also has <x-sirius::code>link</x-sirius::code>. Check each component's variants. Code and Link use the six semantic variants shown above.</p>
            </section>
            <section id="color-tokens" class="space-y-3">
                <h2 class="text-xl font-medium">CSS tokens</h2>
                <p>Presentation components resolve <x-sirius::code>--sir-{variant}-bg</x-sirius::code>, <x-sirius::code>--sir-{variant}-text</x-sirius::code>, and <x-sirius::code>--sir-{variant}-border</x-sirius::code>. Code and Link use only the colors relevant to their appearance.</p>
                <p>Widgets and layout use a separate set of tokens. In particular, <x-sirius::code>--sir-color-primary</x-sirius::code> does not replace <x-sirius::code>--sir-primary-bg</x-sirius::code>. Its custom OKLCH values have no exact named Tailwind equivalent.</p>
                @include('other.attributes.colors-tokens')
                <p>Components may also expose their own tokens, such as Chart datasets and <x-sirius::link :href="route('other.customized-scrollbar')" wire:navigate>scrollbar colors</x-sirius::link>. One primary token does not recolor every component.</p>
            </section>
            <section id="color-overrides" class="space-y-4">
                <h2 class="text-xl font-medium">Customization</h2>
                <p>Load your overrides after Sirius CSS. Set presentation and widget tokens separately, and provide dark values under your app's <x-sirius::code>dark</x-sirius::code> ancestor.</p>
                <div data-demo-mode="blade">
                    @include('other.demos.colors-overrides')
                </div>
                @include('other.examples.colors-overrides')
                <p>This example scopes the override to <x-sirius::code>brand-theme</x-sirius::code>. For an application-wide override, use <x-sirius::code>:root</x-sirius::code> for the light declarations and <x-sirius::code>.dark</x-sirius::code> for dark. Check contrast and visible focus after changing colors.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
