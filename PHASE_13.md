# Phase 13 - Dialog

## Component contract

`<x-sirius::dialog>` uses native `dialog.showModal()` with package-managed lifecycle. The `header`, `body`, and `footer` text props and named slots follow Card precedence: named header/footer slots override text, including empty slots; a nonempty default slot replaces body text. Section IDs use `{id}-header`, `{id}-body`, and `{id}-footer`, protected from slot overrides. Omitted IDs are random five-character strings; use explicit IDs and Livewire keys for stable identity.

`open` defaults to false. Sizes are sm, md, lg, xl, and full, with md as the default. `closable`, `close-on-escape`, and `close-on-backdrop` default to true independently. The built-in close button uses type=button and `sirius::sirius-ui.dialog.close`. An absent header requires aria-label or aria-labelledby. Initial focus accepts a scoped selector, falling back to autofocus/native focus. Native background inertness and a Tab boundary guard contain keyboard focus; closing returns focus to the opener when it remains available.

## State and cleanup

Plain Blade triggers use data-sir-dialog-open with a target ID, and data-sir-dialog-close inside the dialog or with an explicit target ID. Programmatic requests dispatch dialog:show/dialog:hide with detail.id. Alpine binds data-open; Livewire renders :open and synchronizes dialog:close back to its boolean. Server renders otherwise restore the supplied state. The owner preserves native open during Livewire attribute morphs without skipping child content or validation updates.

Lifecycle events dialog:open/dialog:close carry id and reason. Opening another dialog closes the previous one with reason=replaced. Nested dialogs are unsupported and blocked; this phase creates no stacking or queue. Removal/navigation releases scroll locks; one document owner and WeakMap state avoid duplicate listeners and retained removed dialogs.

Dialog and backdrop fade in for 160 ms and out for 120 ms. The native modal state, focus containment, and scroll lock remain active until the exit finishes. Reopening cancels a pending exit; replacement, removal, navigation, and native close clean up immediately. Reduced-motion preferences disable animations. The closing event is emitted once after cleanup.

Scroll locking saves the affected inline styles and scroll position. Stable scrollbar gutters preserve existing scrollbar space; unsupported browsers receive measured padding compensation. Fixed descendants are measured and adjusted when viewport geometry changes, then restored. No Windows settings or vendor files are modified.

Datetime Picker calendars mount in a persistent wire:ignore host inside Dialog and use viewport positioning. This keeps the calendar within the modal layer and intact during Livewire updates. Escape closes an open picker before its parent dialog; dialog closure closes its pickers. Tom Select works within its existing local dropdown container.

## Documentation and verification

The public page contains matching Livewire and Blade project-form demos, plus compact Blade invoice and delivery demos. Dialog is an explicit exception to the general Blade-only rule for non-form components. The project form includes text, number, password, currency, phone, date, time, datetime, textarea, richtext, single/multiple Select, checkbox, checkbox group, radio, switch, file upload, and scalar/range Slider. Both forms share validation, Load Value, and Reset Sample; Livewire also supports Toggle Readonly. The Blade form uses the package Form component with multipart encoding and a dedicated invocable controller. Passwords and uploaded files are never flashed or stored by this demo submission.

Usage is copyable per Blade demo, followed by Attributes, Assets and interaction, State and events, and Translations. Dialog is inserted after Card in the existing Layout menu and index. Additional lifecycle regression fixtures stay in development routes. No architecture boundary or dependency changed.

Classic-scrollbar testing reproduced a centered-content shift on the public docs page. The root's clientWidth expanded even with a stable gutter, causing duplicate padding compensation. Scroll locking now measures the root's actual bounding width. Headed Chromium verifies unchanged docs/sidebar geometry and style restoration with native scrollbars and the fallback.

Combining all widgets also exposed document-wide observer feedback between Select, Richtext, and Slider. Their observers now refresh only affected component roots, while preserving initialization and cleanup after insertion, removal, and navigation. Browser coverage edits and submits every control in both forms, uploads a PDF and a richtext image, opens widget popups, checks readonly/reset behavior, ensures enhanced native sources remain hidden after updates, and checks mobile overflow.

Fields align their grid content to the start so taller neighboring fields do not stretch the space between labels and controls. Richtext also hides its source textarea whenever an initialized editor exists, preserving the JavaScript-free fallback while preventing a native textarea from appearing after Livewire removes enhancement attributes.

Rendering tests cover escaped sections, slot precedence, naming, generated and protected IDs, translation overrides, dismissal options, and invalid contracts. Browser tests cover focus containment/return, prevented dismissal, initial focus, validation and updates, Select/Datetime Picker interaction, one active dialog, removal/remounting/navigation, native initial/programmatic state, event uniqueness, scroll-lock geometry/restoration (including fallback), and mobile light/dark layouts.

References: [MDN native dialog](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/dialog) and [MDN scrollbar-gutter](https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/Properties/scrollbar-gutter). Livewire morph APIs were verified against the installed Livewire 4 distribution.

Both asset builds passed. Package `composer test` passed (321 tests, 1,019 assertions), docs `composer test` passed (139 tests, 756 assertions), and docs `composer test:browser -- --processes=4` passed (97 tests, 1,015 assertions). The focused Dialog suite also passed in headed Chromium with classic scrollbars (14 tests, 151 assertions). Lint, type, and Rector checks passed in both projects.

The full browser gate also exposed stale routes, accordion demo references, and navigation assumptions after the earlier docs refactors. Development breadcrumbs and affected browser fixtures were updated to the current Choices page, accordion demos, and grouped sidebar without removing regression coverage.
