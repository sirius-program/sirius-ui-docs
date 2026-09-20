# Phase 6 — Searchable select

## Implemented contract

`<x-sirius::select>` enhances a native select with locally bundled Tom Select 2.6.2. Tom Select, Sifter 1.1.0, and Unicode Variants 1.1.2 use Apache-2.0; the build preserves the library notices and Sifter README attribution. No API key, CDN, jQuery, or additional Alpine instance is required. The installation audit reported no known vulnerabilities.

Options are records with a unique non-empty string/integer `value`, plain-text `label`, optional boolean `disabled`, and optional string `group`. IDs normalize to strings, preserving zero. Single model values are nullable strings; multiple values are arrays of strings. Native multiple names receive `[]`, and empty multiple controls omit their form entry. The application normalizes missing arrays and validates permitted IDs. Groups and disabled options are reflected in the native and enhanced controls.

Named props cover placeholder, searchable, clearable, maximum selections, remote URL, debounce, and minimum query length. Clearability defaults to the inverse of required. Package-owned renderers and lifecycle are not exposed as arbitrary JavaScript options. Consumer-defined HTML/Alpine event attributes remain on the source select; selection changes forward input/change events. Native attributes, accessibility state, model modifiers compatible with string IDs, and external form association are supported.

## Remote provider contract

`search-url` identifies a same-origin GET endpoint owned by the application. Search requests send `q` and one-based `page`; selected-label resolution sends `values[]`. Responses contain `options` records and boolean `hasMore`. This endpoint works identically with ordinary Blade and Livewire. The adapter validates response shapes, escapes option labels through Tom Select, cancels superseded requests, and ignores stale responses even if cancellation is ineffective. Selected options survive later result pages. Load more, empty/loading feedback, and Retry support recoverable failures.

Authentication, authorized record scoping, input bounds, rate limits, and final submission validation belong to the host application. Apply the same authorization to searching and resolving preselected labels. The demo endpoint exposes only a fixed public catalog, rejects excessive query/page parameters, and never accepts model/query definitions from the client. Invalid submitted and unresolved private IDs are rejected by the demo's validation contract.

## Lifecycle, layout, and localization

Tom Select owns an ignored UI subtree. The original select remains the only named form control; a separate ignored model bridge preserves null/array types in Alpine and Livewire. Mutation handling synchronizes option/configuration changes and readonly/disabled state. Native reset restores initial values, including external controls. Teardown aborts requests and removes widget listeners before remount/navigation.

Native source visibility is based on the presence of the enhanced wrapper as well as the hidden attribute. This prevents Livewire morphs from revealing duplicate native controls. The adapter maps optgroups explicitly. Clear and Retry are Blade-icon suffix buttons with accessible translated labels and native hover titles. Search status appears opposite the label, outside the dropdown. Label exposes reusable `status` and `status-id`; the field adapter exposes `label-status`. Default labels keep their existing markup when no status is supplied.

Component UI translations are grouped in `resources/lang/{locale}/sirius-ui.php`, starting with `select`. Blade resolves each key individually so partial application overrides retain fallback translations, then passes the messages to JavaScript. Publish with `sirius-ui-translations`; consumers override `lang/vendor/sirius/{locale}/sirius-ui.php`. Validation messages remain in `validation.php`. This convention is recorded in package and docs AGENTS.md.

## Documentation and verification

The Select page contains matching delivery, workshop-interest, and remote-venue Blade/Livewire demos, separate exact Blade examples, attributes, shared contract, asset notes, remote endpoint guidance, and global translations. Local/testing-only fixtures cover native and Alpine/Livewire integration. The README, navigation, component index, and architecture boundary were updated. Package support classes remain independent of persistence and application namespaces.

Package `composer test` passed with 183 tests / 557 assertions. Docs `composer test` passed with 81 tests / 393 assertions. Both asset builds passed. Docs `composer test:browser` passed with 54 tests / 557 assertions, including eight Select browser tests. The first full browser run stalled during runner startup and was interrupted; a clean rerun completed successfully. Browser cases cover selection and zero IDs, group rendering, canonical submissions, native resets, options updates, readonly/disabled, Alpine arrays, Livewire selection/morphs, label loading, stale responses, retries, pagination, remount/navigation, suffix placement, and mobile light/dark layouts.

Local verification uses PHP 8.5 / Laravel 13; existing CI retains coverage responsibility for other supported runtime combinations. Native local selection works without JavaScript; remote search and readonly enforcement require JavaScript. A selected remote ID may appear temporarily until the provider resolves its label; supplying initial options avoids that placeholder.

References: [Tom Select usage](https://tom-select.js.org/docs/), [Tom Select API](https://tom-select.js.org/docs/api/), and the installed 2.6.2 source and dependency notices.
