<x-layouts::app title="Richtext">
    <x-docs-page :navigation="['Richtext' => ['richtext-demo' => 'Demo', 'richtext-usage' => 'Usage', 'richtext-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'richtext-upload' => 'Image upload', 'richtext-sanitization' => 'Sanitization', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Richtext</h1>
                <p>Textarea with Docs-like formatting, powered by <a href="https://tiptap.dev/" target="_blank" rel="noopener noreferrer" class="text-blue-500 dark:text-blue-400 hover:underline">Tiptap</a>.</p>
            </header>
            <section id="richtext-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.richtext-example />
                </div>
                <div id="richtext-blade" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.richtext-blade')
                </div>
            </section>
            <section id="richtext-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.richtext')
            </section>
            <section id="richtext-attributes">
                @include('blade-components.attributes.richtext')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Controls support Livewire updates and navigation. No extra Alpine instance is needed.</p>
                <p>Tiptap core, the MIT-licensed Tiptap UI components, and React are bundled internally. No React setup, API key, or Tiptap subscription is needed.</p>
            </section>
            <section id="richtext-upload" class="space-y-3">
                <h2 class="text-xl font-medium">Image upload</h2>
                <p>The richtext sends a multipart <code>POST</code> with the <code>image</code> field. Return JSON with a <code>url</code> pointing to the stored image. Laravel CSRF is read from the page meta tag, form token, or XSRF cookie.</p>
                <x-docs-code language="PHP" :source="file_get_contents(app_path('Http/Controllers/RichtextImageStoreController.php'))" />
                <p>The demo endpoint stores images on the default disk and serves them through a dedicated route. Add your application's authorization and cleanup policy. Removing an image from the richtext does not delete its file.</p>
                <p>Submission waits for uploads to finish. Failed uploads can be retried by choosing the file again.</p>
            </section>
            <section id="richtext-sanitization" class="space-y-3">
                <h2 class="text-xl font-medium">Sanitization</h2>
                <p>Validate and sanitize HTML on the server before storing or rendering it. The demos use Symfony HTML Sanitizer with an allowlist of formatting tags and safe link schemes.</p>
                <x-docs-code language="PHP" :source="file_get_contents(app_path('Support/RichtextSample.php'))" />
                <p>Render only the sanitized result with Blade's unescaped output syntax. Toolbar settings do not protect against forged requests.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>richtext</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>.</p>
                @include('blade-components.examples.richtext-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
