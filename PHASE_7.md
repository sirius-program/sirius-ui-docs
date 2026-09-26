# Phase 7 — File upload

## Contract

`<x-sirius::file-upload>` uses the shared Field/Label/error contract, single or multiple files, `accept`, positive `max-size` (KiB), `max-files`, `reset-key`, and an allowlisted FilePond `options` bag. The default slot represents application-owned existing-file metadata or authorized actions. The value prop requires only name and byte size for existing files. An optional preview URL enables image/PDF previews; omitted or null URLs display filename and size only, including non-previewable file types. Local mock items are never fetched as upload files. Existing items count toward max-files and client required. Remove emits file-upload:remove-existing, never permanent deletion.

Blade submits a named native file input through multipart/form-data. The widget synchronizes its FileList with DataTransfer. Unsupported browsers retain the native input, with authoritative validation in the application. Livewire uses WithFileUploads and one upload adapter per property, serializing requests within each field; multiple properties hold arrays. Native `wire:model` file listeners are excluded to prevent duplicate uploads. FilePond shows progress, cancellation, retry, and temporary removal.

Server validation, authorization, permanent storage, and cleanup policy remain application concerns. Local temporary cleanup is provided by Livewire; S3 temporary storage needs its lifecycle cleanup configuration. Browser-selected files cannot be prefilled or restored after reload/remount. The demo Load Value action displays public/sample/sample.pdf and sample.jpg through existing metadata, not fake local uploads. Reset keys clear widget state without deleting permanent data. Dynamic restrictions require remounting with a new key.

## Dependencies and sources

- FilePond 4.32.12 — MIT.
- filepond-plugin-file-validate-type 1.2.9 — MIT.
- filepond-plugin-file-validate-size 2.2.8 — MIT.
- filepond-plugin-image-preview 4.6.12 and filepond-plugin-file-poster 2.5.2 — MIT.
- PDF preview uses an owned native-browser adapter with URL cleanup and an Open preview fallback. The third-party PDF plugin was evaluated but rejected because metadata-only existing items become invalid Blob content and its object URLs are not revoked.
- Vendored builds retain notices in dist/third-party-notices.txt. No CDN or license key.
- [FilePond server callbacks](https://pqina.nl/filepond/docs/api/server/)
- [FilePond properties](https://pqina.nl/filepond/docs/api/instance/properties/)
- Livewire upload signatures and append/removal behavior verified against installed Livewire 4 sources.

## Architecture and verification

No package endpoints, persistence service, business model, or storage dependency was introduced. Existing architecture tests protect these boundaries. Field error collection now flattens wildcard messages so multiple-file validation remains accessible.

Feature tests cover rendering, lifecycle-option rejection, escaping, wildcard errors, real controller validation, multiple limits, Livewire load/reset, and no permanent writes. Browser tests use a real PHP HTTP server and isolated storage because the installed Pest in-process HTTP driver does not parse uploaded multipart files. Network failures and pending requests are injected at XMLHttpRequest to exercise retry/cancel without an external service.

Verification: composer test passes in sirius-ui (212 tests, 608 assertions) and sirius-ui-docs (85 tests, 424 assertions). The full docs composer test:browser -- --processes=4 passes (60 tests, 620 assertions). Four workers avoid timeouts seen with the default parallel worker count. Package and docs assets were rebuilt. Preview checks cover image loading, PDF embedding/fallback, existing-file removal events, native-source visibility, and mobile dark-mode bounds. Headless Chromium cannot render native PDF content; the object source and Open preview fallback are verified, while embedded rendering depends on the browser PDF viewer.
