<x-layouts::app title="Form">
    <x-docs-page :navigation="['Form' => ['form-demo' => 'Demo', 'form-usage' => 'Usage', 'form-attributes' => 'Attributes']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Form</h1>
                <p>Native Blade forms with automatic CSRF and method spoofing.</p>
            </header>
            <section id="form-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                @if (session('form-result'))<p role="status" data-form-result>{{ session('form-result') }}</p>@endif
                @if ($query !== '')<p role="status" data-form-search>Search: {{ $query }}</p>@endif
                @foreach (['get' => 'GET — Project search', 'post' => 'POST — Create a project', 'put' => 'PUT — Replace project details', 'patch' => 'PATCH — Rename a project', 'delete' => 'DELETE — Archive a draft', 'upload' => 'Multipart — Project document'] as $kind => $title)
                    <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
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
        </article>
    </x-docs-page>
</x-layouts::app>
