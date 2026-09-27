# Phase 8 — Richtext

## Component and documentation

`<x-sirius::richtext>` provides HTML editing; `<x-sirius::textarea>` remains a separate native control. Textarea and Richtext have separate docs pages. Each Richtext demo field has its own copyable Blade source. The announcement supports full formatting and optional image uploads; the signature demonstrates a reduced toolbar.

The shared Field contract supplies IDs, labels, helper text, required markers and Laravel/Livewire errors. Richtext props cover toolbar order, minimum height, free heading/history/link options, readonly/disabled, and image upload settings. Native form attributes remain on the canonical textarea. HTML is synchronized with Blade forms, Alpine x-model, and Livewire string bindings. Empty richtexts produce an empty string. Browser length limits count text; server limits can independently cap HTML length. Server updates and native resets update the richtext; removed instances release React roots and abort uploads. Change reset-key for an explicit Livewire reset even if its model is already empty.

## Tiptap UI and licensing

Tiptap core, StarterKit, React adapter, ProseMirror facade, and Image extension are pinned at 3.31.3. React/ReactDOM 18.3.1 are bundled in production mode. Official MIT Tiptap UI source is pinned at commit 799929bea4804c73767562b69f8acc2acdb8ac86. The package vendors the actual toolbar, mark/list/heading/link/history controls and their UI primitives. Its upload action composes the official Button primitive with a Blade icon and a package-owned HTTP adapter. It does not use the upstream simulated upload callback.

Local UI patches scope styles and portals, translate UI labels, and validate link schemes. Per-richtext messages are provided from `sirius::sirius-ui.richtext.*`; published overrides live in `lang/vendor/sirius/{locale}/sirius-ui.php`. Source provenance and MIT licenses accompany the copied source, and bundled transitive notices are regenerated during the asset build. No Pro registry, Cloud service, license key, CDN, or consumer React setup is needed.

Official references: [Simple Editor](https://tiptap.dev/docs/ui-components/templates/simple-editor), [UI source](https://github.com/ueberdosis/tiptap-ui-components), [Image extension](https://tiptap.dev/docs/editor/extensions/nodes/image).

## Image uploads

Include `image` in toolbar and set upload-url to a same-origin endpoint. The package POSTs multipart field `image`, supplies Laravel CSRF from meta/form/cookie, and expects JSON `{ "url": "https://..." }`. Only HTTP(S) returned URLs are inserted. Defaults are JPEG/PNG/WebP up to 2048 KiB. Props may restrict/extend raster formats and size; the server remains authoritative. SVG and base64 uploads are excluded.

Progress, cancellation and retry-by-reselection are supported. Submit is blocked during pending uploads, including forms using novalidate. Reset, readonly changes and teardown abort pending requests. Removing richtext content never deletes stored files.

Docs use separate invocable store/show controllers, rate-limit uploads, validate image content/type/size, use random storage names, and return safe image URLs. Application consumers own authorization, storage and orphan cleanup. The docs sanitizer allowlists formatting and image attributes and rejects unsafe link/media schemes before unescaped output.

## Architecture and verification

The package contains no upload endpoint or persistence code; existing architecture boundaries still apply. Docs own the sample controllers and Symfony HTML Sanitizer integration. React only owns the ignored toolbar subtree; the canonical textarea and shared field remain server-owned.

Feature tests cover configuration, escaping, translations, native fallback, upload settings, controller validation and malicious HTML/URLs. Browser tests cover formatting/link UI, Blade submission, Livewire/Alpine synchronization, native validation/reset, readonly/disabled, remount/navigation, multiple richtexts, mobile themes, real multipart uploads, retry, pending-submit blocking and cancellation. Upload tests share the existing isolated real-HTTP-server harness because the in-process driver cannot parse multipart uploads.

All toolbar controls are hidden in readonly/disabled state. Translations use the application locale and fallback; richtext has no locale prop.

Verification: package `composer test` passed (225 tests, 646 assertions); docs `composer test` passed (97 tests, 518 assertions); docs `composer test:browser -- --processes=4` passed (66 tests, 695 assertions). Package and docs production assets were rebuilt.
