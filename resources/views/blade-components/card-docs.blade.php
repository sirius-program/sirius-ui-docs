<x-layouts::app title="Card">
    <x-docs-page :navigation="['Card' => ['card-demo' => 'Demo', 'card-usage' => 'Usage', 'card-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Card</h1>
                <p>Group related content with optional header and footer.</p>
            </header>
            <section id="card-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.card-summary')
                </div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.card-slots')
                </div>
            </section>
            <section id="card-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.card')
            </section>
            <section id="card-attributes">
                @include('blade-components.attributes.card')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Named header/footer slots override their text props, including empty slots. The default slot overrides body text when it contains content. Empty header/footer sections are omitted; the body remains.</p>
                <p>Section IDs use the root ID plus <code>-header</code>, <code>-body</code>, or <code>-footer</code>. Header/footer slot attributes are forwarded, but their IDs cannot replace these associations.</p>
                <p>Card requires only the package CSS. Livewire can update its content without additional setup.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
