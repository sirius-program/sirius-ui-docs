<x-layouts::app title="Code">
    <x-docs-page :navigation="['Code' => ['code-demo' => 'Demo', 'code-usage' => 'Usage', 'code-attributes' => 'Attributes']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Code</h1>
                <p>Style inline code or keep an existing code block's formatting.</p>
            </header>
            <section id="code-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Inline</h3>
                    @include('blade-components.demos.code-inline')
                    <h3 class="font-medium">Block</h3>
                    @include('blade-components.demos.code-block')
                </div>
            </section>
            <section id="code-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.code')
            </section>
            <section id="code-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.code')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
