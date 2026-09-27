<x-layouts::app title="Form">
    <x-docs-page :navigation="['Form' => ['form-demo' => 'Demo', 'form-usage' => 'Usage', 'form-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2"><p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p><h1 class="text-3xl font-semibold">Form</h1><p>Native Blade forms with automatic CSRF and method spoofing.</p></header>
            <section id="form-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                @if (session('form-result'))<p role="status" data-form-result>{{ session('form-result') }}</p>@endif
                @if ($query !== '')<p role="status" data-form-search>Search: {{ $query }}</p>@endif
                @foreach (['get' => 'GET — Project search', 'post' => 'POST — Create a project', 'put' => 'PUT — Replace project details', 'patch' => 'PATCH — Rename a project', 'delete' => 'DELETE — Archive a draft', 'upload' => 'Multipart — Project document'] as $kind => $title)
                    <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                        <h3 class="font-medium">{{ $title }}</h3>
                        @include('blade-components.demos.form-'.$kind)
                    </div>
                @endforeach
            </section>
            <section id="form-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.form')
            </section>
            <section id="form-attributes">
                @include('blade-components.attributes.form')
            </section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>The controls inside the form own their labels and errors. Controllers own validation, authorization, redirects, old values, and persistence. The form does not add an error summary.</p>
                <p>Do not add another <code>@@csrf</code> or <code>@@method</code> inside the slot. Submit-button overrides such as <code>formaction</code>, <code>formmethod</code>, and <code>formenctype</code> keep their native meaning; ensure they agree with the form's token, spoofed method, and encoding.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>The form itself needs no JavaScript or package styles. Load the assets required by its child controls.</p>
                <p>Submissions navigate to the action URL. This component adds no AJAX, loading state, or Livewire model handling.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
