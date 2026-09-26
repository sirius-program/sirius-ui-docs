<x-layouts::app title="File Upload">
    <x-docs-page :navigation="['File Upload' => ['upload-demo' => 'Demo', 'upload-usage' => 'Usage', 'upload-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'storage' => 'Storage and validation', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">File Upload</h1>
                <p>Using <a href="https://pqina.nl/filepond" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">filepond</a> under the hood, an input file with great visualization, accessible, and silky smooth user experience.</p>
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
                <p>Controls automatically associate labels, helpers, and validation errors. Laravel or Livewire supplies the error bags; application validation remains authoritative.</p>
                <p>Use a nullable upload property for a single file, an array for multiple files, and Livewire's WithFileUploads trait. The adapter owns uploading; do not attach a second upload handler. Model modifiers do not delay temporary uploads. Use stable IDs and increment reset-key when resetting files from the server.</p>
                <p>Load Value displays the sample PDF and image through value metadata. Previews do not become local uploads or Livewire temporary files. Server validation must check retained existing files against records owned by the current user, separately from new uploads. The default slot remains available for application-owned content. Newly selected files must be chosen again after a reload/remount.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package stylesheet and JavaScript once in your application build, or publish <code>sirius-ui-assets</code> and load the published CSS and JavaScript.</p>
                @include('blade-components.examples.assets')
                <p>FilePond 4.32.12, file-validate-type 1.2.9, file-validate-size 2.2.8, image-preview 4.6.12, and file-poster 2.5.2 are bundled internally with MIT notices. PDF previews use a package-owned native browser adapter; Open preview remains available when embedded PDF rendering is unsupported. Preview URLs must be accessible to the browser and permitted by the application CSP. Blob URLs created for new PDFs are revoked when their previews are destroyed. No CDN or key is required. Keyboard users can focus Browse and the file action buttons. The UI supports light/dark themes and reduced motion.</p>
                <p>Blade uses a native file input and multipart/form-data. JavaScript synchronizes its FileList through DataTransfer; without that browser support, the native input remains available. Server validation still applies. After a redirect, browsers require files to be selected again. Blade uploads occur on form submission; per-file progress, cancellation, and retry belong to the Livewire temporary-upload flow.</p>
                <p>Readonly prevents choosing/removing files but retains the native submission. Disabled controls are omitted. Readonly requires JavaScript because HTML file inputs have no native readonly behavior. Livewire serializes uploads per field to make cancellation deterministic. Do not bind two upload components to the same property.</p>
                <p>Alpine event listeners can consume file-upload:start, progress, complete, error, cancel, and change. Progress detail contains progress (0–100); change detail contains file metadata. x-model is unsupported. value URLs are preview-only; they are never used as upload or deletion endpoints. Dynamic limits require remounting the component with a new wire:key; readonly/disabled, errors, and reset-key update in place.</p>
            </section>
            <section id="storage" class="space-y-3">
                <h2 class="text-xl font-medium">Storage and validation</h2>
                <p>The demos validate public sample documents and never store permanent files. Applications must authorize uploads, validate MIME content and size server-side, and choose the disk/path. Client accept, size, and count restrictions are usability controls. Validate both the array count and each file for multiple uploads.</p>
                @include('blade-components.examples.file-upload-storage')
                <p>Keep private documents on a private disk and use authorized download routes. Do not trust client filenames or a client-provided path for deletion. Livewire controls temporary validation, upload limits, and cleanup. Its local cleanup removes old temporary uploads; configure the documented lifecycle cleanup for S3. Abandoned or failed uploads may remain until that cleanup runs. PHP/web-server request limits also apply.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Override the <code>file_upload</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. UI messages use the application's active locale and fallback locale.</p>
                @include('blade-components.examples.file-upload-translations')
                <p>Validation messages remain in <code>validation.php</code>. FilePond placeholders such as <code>{filesize}</code> and <code>{allTypes}</code> must remain intact.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
