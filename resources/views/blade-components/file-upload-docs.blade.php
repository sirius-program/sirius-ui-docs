<x-layouts::app title="File Upload">
    <x-docs-page :navigation="['File Upload' => ['upload-demo' => 'Demo', 'upload-usage' => 'Usage', 'upload-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'storage' => 'Storage and validation', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">File Upload</h1>
                <p>File uploads with image and PDF previews, powered by <a href="https://pqina.nl/filepond/" target="_blank" class="text-blue-500 dark:text-blue-400 hover:underline">filepond</a>.</p>
            </header>
            <section id="upload-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.file-upload-example />
                </div>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.file-upload-blade')
                </div>
            </section>
            <section id="upload-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.file-upload')
            </section>
            <section id="upload-attributes">@include('blade-components.attributes.file-upload')</section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                <p>With Livewire, use <code>WithFileUploads</code>, a nullable property for one file, or an array for multiple files. Do not add another upload handler. Uploads start immediately regardless of model modifiers. Use stable IDs and change <code>reset-key</code> for server resets.</p>
                <p>Existing files are displayed without uploading them again. Validate retained files separately from new uploads. New selections must be chosen again after a reload.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>FilePond and its preview plugins are bundled. PDF previews use the browser viewer, with an Open preview link as a fallback. Preview URLs must be accessible and allowed by your content security policy.</p>
                <p>Blade uploads use <code>multipart/form-data</code> on submit. Livewire uploads support progress, cancellation, and retry. A native input is used when enhancement is unavailable.</p>
                <p>Readonly blocks file changes but keeps files in the submission; disabled fields are omitted. Readonly needs JavaScript. Each Livewire upload component needs its own model property.</p>
                <p>Listen for <code>file-upload:start</code>, <code>file-upload:progress</code>, <code>file-upload:complete</code>, <code>file-upload:error</code>, <code>file-upload:cancel</code>, or <code>file-upload:change</code>. Progress includes a 0-100 value; change includes file metadata. Change <code>wire:key</code> to apply new upload limits.</p>
            </section>
            <section id="storage" class="space-y-3">
                <h2 class="text-xl font-medium">Storage and validation</h2>
                <p>Validate file content, size, and count before storing uploads. The demos validate without saving files.</p>
                @include('blade-components.examples.file-upload-storage')
                <p>Your application controls storage, downloads, and permanent deletion. Livewire manages temporary files; S3 requires a cleanup lifecycle rule. PHP and web-server upload limits still apply.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Edit the <code>file_upload</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. Messages follow the application locale and fallback locale.</p>
                @include('blade-components.examples.file-upload-translations')
                <p>Keep validation messages in <code>validation.php</code> and preserve placeholders such as <code>{filesize}</code> and <code>{allTypes}</code>.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
