<x-layouts::app title="File Upload">
    <x-docs-page :navigation="['File Upload' => ['upload-demo' => 'Demo', 'upload-usage' => 'Usage', 'upload-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'storage' => 'Storage and validation', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">File Upload</h1>
                <p>File uploads with image and PDF previews, powered by <x-sirius::link href="https://pqina.nl/filepond/" target="_blank" rel="noopener noreferrer">filepond</x-sirius::link>.</p>
            </header>
            <section id="upload-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.file-upload-example />
                </div>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.file-upload-blade')
                </div>
            </section>
            <section id="upload-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.file-upload')
            </section>
            <section id="upload-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.file-upload')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>FilePond and its preview plugins are bundled. PDF previews use the browser viewer, with an Open preview link as a fallback. Preview URLs must be accessible and allowed by your content security policy.</p>
                <p>Blade uploads use <x-sirius::code>multipart/form-data</x-sirius::code> on submit. Livewire uploads support progress, cancellation, and retry. A native input is used when enhancement is unavailable.</p>
                <p>Listen for <x-sirius::code>file-upload:start</x-sirius::code>, <x-sirius::code>file-upload:progress</x-sirius::code>, <x-sirius::code>file-upload:complete</x-sirius::code>, <x-sirius::code>file-upload:error</x-sirius::code>, <x-sirius::code>file-upload:cancel</x-sirius::code>, or <x-sirius::code>file-upload:change</x-sirius::code>. Progress includes a 0-100 value; change includes file metadata. Change <x-sirius::code>wire:key</x-sirius::code> to apply new upload limits.</p>
            </section>
            <section id="storage" class="space-y-3">
                <h2 class="text-xl font-medium">Storage and validation</h2>
                <p>Validate file content, size, and count before storing uploads. The demos validate without saving files.</p>
                @include('blade-components.examples.file-upload-storage')
                <p>Your application controls storage, downloads, and permanent deletion. Livewire manages temporary files; S3 requires a cleanup lifecycle rule. PHP and web-server upload limits still apply.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>file_upload</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>.</p>
                @include('blade-components.examples.file-upload-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
