<x-layouts::app title="Link">
    <x-docs-page :navigation="['Link' => ['link-demo' => 'Demo', 'link-usage' => 'Usage', 'link-attributes' => 'Attributes']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Link</h1>
                <p>Underlined links with theme colors and keyboard focus styling.</p>
            </header>
            <section id="link-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Colors</h3>
                    @include('blade-components.demos.link-variants')
                    <h3 class="font-medium">Navigation and download</h3>
                    @include('blade-components.demos.link-navigation')
                    <p id="link-details">Your project links can point to a section on the same page.</p>
                </div>
            </section>
            <section id="link-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.link')
            </section>
            <section id="link-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.link')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
