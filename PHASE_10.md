# Phase 10 - Native Blade form

## Contract

`<x-sirius::form>` requires a nonempty action URL and defaults to GET. Methods are case-insensitive: GET and POST use native form methods; PUT, PATCH, and DELETE submit POST with one `_method` field. Every non-GET form includes one CSRF field. Consumers should not add duplicate `@csrf` or `@method` directives.

Boolean `sending-file` defaults to false. When true, it sets `enctype="multipart/form-data"`; GET and a conflicting explicit enctype are rejected. Matching multipart encoding is accepted, and false preserves an explicit native enctype. Native form attributes, classes, Alpine events, data attributes, and ARIA attributes are forwarded.

The form adds no styles, JavaScript, AJAX, loading state, model binding, or Livewire submission handling. Its child controls retain their own field contracts. Applications own validation, authorization, redirects, old values, error bags, uploads, and persistence. Submit-button overrides retain native HTML semantics and must agree with the configured method and encoding.

## Documentation

The Form page has six controller-backed Blade examples: GET project search, POST project creation, PUT replacement, PATCH rename, DELETE archive confirmation, and multipart document submission. Each example has its own copyable source. These demos validate requests without changing stored records or persisting uploaded files.

The page includes attributes, Shared field contract, and Assets and interaction. Navigation, breadcrumbs, the component index, and the README include Form. No dependency or architecture boundary changes were needed.

## Verification

Rendering tests cover method normalization, token and spoof-field uniqueness, escaped attributes, slots, forwarding, multipart combinations, and invalid configuration. Request tests activate CSRF protection and check missing/invalid tokens, real method spoofing, named error bags, old input, and isolated upload validation. Redirect tests carry the session cookie to match real browser behavior.

Browser coverage exercises GET search, canonical currency POST values, validation feedback, load/reset, PUT/PATCH/DELETE, and actual multipart files against an isolated HTTP server. Each flow checks for JavaScript errors.

Completed verification: package `composer test` passed (264 tests, 734 assertions); docs `composer test` passed (127 tests, 671 assertions); then docs `composer test:browser -- --processes=4` passed (75 tests, 804 assertions). Production asset builds passed. Browser tests reported no warnings or JavaScript errors. The docs build retains its existing optional Fontaine and large-chunk notices.
