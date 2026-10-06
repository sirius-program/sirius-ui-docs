# Sirius UI documentation

This application documents and tests the local `sirius/ui` package. Public components are added only after their implementation phases are completed.

## Local installation

Keep `sirius-ui` and `sirius-ui-docs` in sibling directories. Build the package with `npm ci` and `npm run build`, then run `composer install`, `npm ci`, and `npm run build` in docs. Provision application environment values yourself; agents must never access `.env` directly.

Docs uses a Composer path repository at `../sirius-ui`, mapped to `dev-main`. On Windows Composer creates a junction; elsewhere it uses a symlink. Source changes are immediately visible, but package assets must be rebuilt. After changing package Composer metadata, run `composer update sirius/ui --with-dependencies` in docs.

If linking is unavailable, set the repository's `options.symlink` to `false`, run `composer reinstall sirius/ui`, and repeat that reinstall after package edits to refresh the mirrored copy. Never edit files under `vendor`.

The docs stylesheet imports `vendor/sirius/ui/dist/sirius.css`, and `resources/js/app.js` imports `vendor/sirius/ui/dist/sirius.js`. Build package assets before building docs. The package script enables password visibility, readonly choice controls, and mixed checkbox state without depending on Alpine or Livewire JavaScript. Widget proofs use lazy, locally bundled JS/CSS imports; no runtime CDN is required and no second Alpine instance is installed. The existing docs layout uses Flux, but the package does not depend on Flux.

For applications without a bundler, run `php artisan vendor:publish --tag=sirius-ui-assets` and load `/vendor/sirius-ui/sirius.css` and `/vendor/sirius-ui/sirius.js` once. Refresh published assets after package upgrades, reviewing any local modifications first. The script handles later Livewire renders and navigation automatically.

## Navigation and component index

Documentation views live in resources/views/blade-components: examples contains copyable snippets, demos contains rendered Blade/Livewire demonstrations, and attributes contains property tables. Page views compose these partials; Livewire view entry points include the corresponding demo.

Each component follows **Demo → Usage → Attributes**, with **Shared field contract** and **Assets and interaction** where applicable. Form controls stack Livewire and ordinary Blade demos with matching controls and sample values. Non-form controls show Blade demos only, including every supported variant. Shared field contract appears only when applicable. Both provide **Submit / Validate**, **Load Value**, and **Reset Sample**; only Livewire provides **Toggle Readonly**. Demos use workspace scenarios such as project setup, billing details, member access, and subscription selection. Each Usage block displays the exact source of its rendered Blade demo partial, with a separate Copy control for each scenario. Syntax highlighting runs locally, with a selection fallback when clipboard access is denied. Named session keys in these snippets are supplied by the docs demo controller; adapt the value bindings and validation bag to your application. A right-hand content navigator links to sections on wide screens and moves above the content on smaller screens. Documentation pages end with a simple footer. Props tables include types, defaults, descriptions, and component-specific attribute support notes.

Open `/getting-started` through **Getting Started**; component pages are grouped under **Blade Components**. The **Label** page is available at `/blade-components/label`. Shared field behavior is explained on the relevant component pages; the former Form Conventions page has been removed. Field validation regression fixtures are available at `/development/fields` only in local/testing environments.

Use `<x-sirius::label>` for standalone labels and `<x-sirius::field>` to compose a native control with labels, helpers, validation messages, and accessible IDs. Controls and fields generate a random five-character ID when omitted or null; provide a unique explicit ID when it must remain stable across server renders. Apply the field's scoped `$component->controlAttributes()` to the actual control. Inline and fieldset/legend layouts prepare the foundation for choice controls.

Phase 2 provides **Input** (text, number, and password) at `/blade-components/input`, **Textarea** at `/blade-components/textarea`, and **Checkbox, Radio & Switch** at `/blade-components/choices`. Each control has its own example and options section within the combined page. Former Password, Checkbox, Radio, and Switch URLs redirect to the appropriate combined page. Pages include interactive Livewire examples, native Blade usage, props, errors, readonly/disabled semantics, and keyboard guidance. Each control has an ordinary POST demo with isolated validation and sample values. A combined native form remains in the development integration fixture.

Phase 3 provides **Currency** at `/blade-components/currency`: configurable grouping/decimal separators, exact canonical decimal strings, maximum precision with validation (no rounding or truncation), optional negative amounts, and string-based min/max checks. The paired project-budget and invoice-adjustment demos share exact copyable Blade sources. No additional dependency is required. Currency JavaScript is bundled into the same `dist/sirius.js` entry point, including published-asset usage. The native `/development/currency` and `/development/currency-bindings` fixtures cover editing, resets, modifiers, Alpine, and multiple Livewire instances in local/testing environments.

Phase 4 provides **Datetime Picker** at `/blade-components/datetime-picker` with `type="date|time|datetime"`, calendar/clock prefixes, and a Clear suffix using the shared input adornment styles. Display formats are separate from canonical wall-clock values (`Y-m-d`, `H:i`, and `Y-m-d H:i:s`). Flatpickr 4.6.13, locales, styles, and license notices are bundled in the package assets. The trip-planning demos cover date/time bounds, disabled dates, locale, server validation, reset, readonly/disabled behavior, and Livewire synchronization. Native-only and multiple-instance/Alpine fixtures live at `/development/datetime-picker` and `/development/date-bindings`. Global `locale` and `timezone` can be set in `config/sirius-ui.php` (publish with `php artisan vendor:publish --tag=sirius-ui-config`). Both default to null. At render time, timezone falls through `sirius-ui.timezone` → `app.timezone` → `UTC`, and locale through `sirius-ui.locale` → `app.locale` → `app.fallback_locale` → `en`; missing or null entries are skipped. Individual picker props may override them. Applications own timezone conversion and DST validation.

Development-only integration fixtures are available at `/development/integrations` and `/development/plain-blade` when the application environment is `local` or `testing`. These are experiments for later components, not public component APIs.

Dialog, Alert, and Slideover integration fixtures share `/development/overlays`.
Their integration checks are grouped in the browser and feature `OverlayTest.php` files.
Dialog and Slideover scroll within their body, keeping the header and footer visible.

Phase 15 adds **Avatar**, **Separator**, and **Skeleton**, with Blade demos and copyable examples. Avatar supports images and initials with recovery after source changes. Separator supports horizontal, vertical, and decorative lines. Skeleton reserves loading space and respects reduced motion. The development Avatar fixture verifies Livewire updates, removal, and remounting. See [Phase 15](PHASE_15.md) for contracts and verification.

Checkbox and radio options inside `<x-sirius::field group>` share the group's error key, error bag, and accessible descriptions. Put `required` on the group to show a single required marker alongside a single set of validation messages. Required radio groups preserve native validation; validate minimum checkbox selections on the server.

Phase 2 integration fixtures at `/development/basic-controls` and `/development/standalone-controls` verify multiple Livewire instances and native controls without Livewire or Alpine. They are available only in local/testing environments.

The expanded roadmap in the implementation checklist runs through Phase 26. Planned additions include single/range Slider, Message and Dialog naming, new display/navigation/overlay components, and Livewire Chart. Table phases also include custom row, bulk, and toolbar actions, with confirmation/input forms and explicit atomic or partial-result handling. The AI agent skill follows all component phases; replacing Flux throughout docs precedes final release validation. These are planned APIs, not shipped components.

- [Implementation checklist](IMPLEMENTATION_PLAN.md)
- [Phase 0 architecture, dependency decisions, and evidence](PHASE_0.md)
- [Phase 1 form foundation and verification](PHASE_1.md)
- [Phase 2 basic controls and verification](PHASE_2.md)
- [Phase 3 currency contract and verification](PHASE_3.md)
- [Phase 4 date/time contract and verification](PHASE_4.md)
- [Phase 5 phone contract and verification](PHASE_5.md)
- [Bundled dependency notices](public/third-party-notices.txt)

## Verification

Run `composer test` in each changed project. Once all those checks pass, run `composer test:browser` in docs and wait for completion. Use `npm run build` after frontend changes; it also refreshes third-party license notices.

Package architecture tests run under Pest 4/Testbench; docs feature/browser tests retain Pest 5. Tests use deterministic values, fake storage for file validation, and isolated browser contexts. They do not require production records or permanent file storage.


Phase 5 provides **Phone** at `/blade-components/phone`: `<x-sirius::phone>` accepts `country` as one country/regional locale, a list, or `*`. The wildcard list is sorted by calling code; options use `+62 - Indonesia` labels and a fixed five-character prefix text area with ellipsis. `sirius-ui.phone_country` inherits `sirius-ui.locale`, `app.locale`, `app.fallback_locale`, then `US`; an explicit component country takes priority. Set `SIRIUS_UI_PHONE_COUNTRY` through the published config for an environment override. `delimiter` affects display only; models and submissions use E.164 or null. JavaScript and full libphonenumber-js 1.13.13 metadata are bundled locally with license notices. Native draft restoration is opt-in through `draft-name`/`draft`; explicit Livewire resets use `reset-key`. See PHASE_5.md for contracts, limits, and verification.

The optional `Sirius\Ui\Rules\PhoneNumber` validation rule is provided by the package and used by the Phone demos. It checks international syntax and optional calling-code prefixes; see the Phone shared field contract for usage and limitations.

PhoneNumber messages use `sirius::validation.phone_number` and `sirius::validation.phone_country`. Publish with `php artisan vendor:publish --tag=sirius-ui-translations`, then customize `lang/vendor/sirius/{locale}/validation.php`; messages support the `:attribute` placeholder.

Phase 6 provides **Select** at `/blade-components/select`: local single/multiple selection, disabled options and groups, and opt-in same-origin remote search with debounce, pagination, label resolution, stale-response protection, and retry. Tom Select 2.6.2 and Apache-2.0 notices are bundled locally. Selections and search stay on one line; multiple selections scroll horizontally and keep the focused search input visible. Clear/Retry use suffix icons; search status appears opposite the label. Label accepts `status` and `status-id`; the status ID defaults to the label `id` or `for` plus `-label-status`, and is omitted when neither exists. An explicit `status-id` overrides this default. Field adapters expose `label-status`. Component translations use `sirius::sirius-ui.select.*`, overridden in `lang/vendor/sirius/{locale}/sirius-ui.php`; validation rules keep their separate `validation.php` translations. See [Phase 6](PHASE_6.md) for integration contracts and verification.

Phase 7 provides **File Upload** at `/blade-components/file-upload`: `<x-sirius::file-upload>` supports single/multiple files, MIME/extension restrictions, KiB limits, count limits, localized feedback, and application-owned existing-file content. Image/PDF previews support new files and existing name/size/url metadata, with safe removal events and no automatic permanent deletion. Blade submits native multipart files; Livewire uses temporary uploads with progress, cancellation, retry, and removal. FilePond 4.32.12 and its MIT validation plugins are bundled internally. The docs show private-storage examples but demos never persist permanent files. See [Phase 7](PHASE_7.md) for limits and verification.

The File Upload Supporting documents demo loads existing PDF, TXT, and CSV metadata without preview URLs. Only name and size are required; an optional url enables image/PDF previews. The Translations section includes a copyable translation override and the translation publishing command.

Component pages use concise usage notes and consistent attribute descriptions. Detailed implementation history remains in the phase reports.

Phase 8 provides the HTML richtext. **Richtext** has its own page at `/blade-components/richtext`, while `/blade-components/textarea` retains the native textarea documentation. Use `<x-sirius::textarea>` for plain text and `<x-sirius::richtext>` for HTML; richtext demos cover announcement and signature fields with separate copyable examples, Blade/Livewire bindings, and server-side HTML sanitization. Official MIT Tiptap UI components and React are bundled internally; consumers need no React setup or paid Tiptap service. The approved image-upload contract uses a consumer-owned `upload-url` endpoint, multipart `image`, same-origin Laravel CSRF, and a JSON `url` response; default types are JPEG/PNG/WebP up to 2 MiB, with permanent-file cleanup owned by the application.

See [Phase 8 contracts and verification](PHASE_8.md) for richtext lifecycle, upload integration, and dependency details.

Phase 9 provides **Slider** at `/blade-components/slider`: numeric single values or two ordered handles with independent min/max/step arrays. Native Blade payloads, Livewire/Alpine bindings, keyboard/pointer/touch, readonly/disabled, and reset are supported without a new dependency. See [Phase 9 contracts and verification](PHASE_9.md).

Phase 10 provides **Form** at `/blade-components/form`: `<x-sirius::form>` defaults to GET, adds CSRF for non-GET requests, spoofs PUT/PATCH/DELETE, and enables multipart uploads with `sending-file`. Six Blade demos use controller-backed native submissions. See [Phase 10 contracts and verification](PHASE_10.md).

Component docs share Demo, Usage, and Attributes sections, with Shared field contract and Asset and interaction where applicable. Usage uses one copyable demo source per component; native Blade demos use the Form component. Attribute tables focus on package props and behavior that differs from HTML.

Input, Textarea, and Checkbox/Radio/Switch use separate page views. The Input demo combines text, number, and password fields under one Usage and Attributes section.

Input, Textarea, Checkbox, Radio, and Switch each have dedicated attribute tables and Blade/Livewire demo partials.

These pages have explicit named routes (blade-components.input, blade-components.textarea, and blade-components.choices), with separate demo submission routes. Legacy password and individual choice URLs redirect to their combined pages.

Global configuration and Translations have separate sections and navigator links where applicable.

Phase 11 provides **Icon**, **Button**, **Button Group**, **Badge**, and **Message**, each with a dedicated page, Blade demos, and copyable usage. Non-form variants are demonstrated in full; Livewire regression fixtures remain in development pages. Shared semantic styles support light/dark themes. Buttons support icons, loading, disabled links, and link styling. Messages with `dismissible` preserve local state through Livewire updates and expose a reset key and dismissal event. See [Phase 11](PHASE_11.md) for contracts and verification.

Presentation variants use primary (sky), info (neutral), and secondary (indigo). Button chooses its element with `as`; Message enables dismissal with `dismissible`.

Phase 12 provides **Card** and **Accordion**, with Blade-only demos and separate copyable examples. Card supports text or slots and stable section IDs. Accordion supports independent items or exclusive groups using a shared `name`, optional opening animation, and Alpine/Livewire state synchronization. Attribute tables list each attribute separately. See [Phase 12](PHASE_12.md) for contracts and verification.

Phase 13 provides **Dialog**, with Card-style content slots, sizing, initial focus, configurable dismissal, simple fades, and Alpine/Livewire state updates. Its Blade and Livewire project forms demonstrate every shipped form control, including file and richtext image uploads. One dialog is active at a time. Scroll locking preserves page and fixed-element positions and restores prior styles on close, removal, or navigation. See [Phase 13](PHASE_13.md) for the interaction contract and verification.

Phase 14 adds **Alert** for focused prompts with an optional icon and title, text, eight standard variants, fade–bounce animations, and your own footer actions. **Slideover** opens from all four viewport edges; its right-side Blade and Livewire project forms demonstrate every shipped form control. Both reuse Dialog focus, dismissal, events, and scroll locking, with one active overlay across all three components. Usage provides copyable Blade examples; lifecycle fixtures remain in development routes. No dependency was added. See [Phase 14](PHASE_14.md) for contracts and verification.

Phase 16 adds **Breadcrumb**, **Menu**, and **Dropdown** in the Navigation group. Menu and Dropdown share items with icons, links/actions, trailing shortcuts or badges, active/disabled states, and nested submenus. Dropdown supports keyboard/touch navigation, viewport positioning, reduced-motion fades, and Livewire lifecycle updates. Public demos use Blade; the development fixture covers Livewire integration. No dependency was added. See [Phase 16](PHASE_16.md) for contracts and verification.

Phase 17 adds **Tooltip** and **Popover**, with six variants, viewport positioning, keyboard interaction, and reduced-motion fades. Tooltip shows escaped text on hover/focus; Popover accepts HTML and interactive controls without trapping focus. Native Popover API panels stay above Dialog/Slideover scroll areas. Public pages show Blade examples; Livewire and nested-panel fixtures share Overlay integration. No dependency was added. See [Phase 17](PHASE_17.md) for contracts and verification.

Popover uses `class` for its content panel and `wrapper-class` for its outer wrapper. Tooltip and Popover default to the `info` variant.

Phase 18 adds **Tabs** and **Timeline**. Tabs supports horizontal/vertical lists, automatic/manual keyboard activation, disabled tabs, and active-state binding through `active` and `tabs:change`. Inactive panels stay mounted, preserving form values through tab switches. Timeline displays completed/current/upcoming steps with icons, numbers, or custom markers; progression stays application-owned. Both have separate Blade demos and copyable Usage. Livewire, Alpine, nested tabs, and Dialog fixtures live at `/development/tabs-timeline`. No dependency was added. See [Phase 18](PHASE_18.md) for contracts and verification.

Phase 19 adds **Toast** at `/blade-components/toast`. Like Alert, render the component before opening it by ID through `toast:show`/`toast:hide` or an `open` binding. It supports the eight presentation variants, six viewport positions (default `top-end` through `sirius-ui.toast_position`), optional icon/title, escaped text, and a footer slot. Timers default to 5000 ms through `sirius-ui.toast_duration`; zero is persistent. Hover, focus, and hidden browser tabs pause the remaining timer. Three Toasts can be visible, with a FIFO queue of 20; overflow drops the oldest waiting item. Toasts preserve Livewire footer actions above Dialog/Slideover and clear on navigation. Integration fixtures live at `/development/toast`. No dependency was added. See [Phase 19](PHASE_19.md) for verification and browser requirements.

Phase 20 adds **Livewire Table**. Its docs are grouped under Table: Overview (`/livewire-components/table`), Query (`/query`), Columns (`/columns`), Filters (`/filters`), and Row Actions (`/row-actions`), with the latter paths under `/livewire-components/table`. Each page has its own demo and copyable examples; Query demonstrates both Eloquent and Collection sources. Extend `Sirius\Ui\Livewire\Table` with `query()` and `columns()`, plus optional `filters()`, cell views, and row actions. `filters()` replaces `filterDefinitions()`. Builder sources search, filter, sort, and paginate in the database; Collection sources process already-loaded models, arrays, or objects in memory. Collection filter callbacks return the filtered Collection. Records need stable, unique IDs; override `recordKey()` for another key. Row views receive `$record`; application code owns its links, overlays, authorization, and execution. Loading blocks rows and footer for requests other than checkbox selection and for explicit external processing; toolbar search and filters stay usable. The filter panel has a stable width, enlarged by 50 px and bounded by the viewport. Select option lists keep the full field width when Clear appears. `record-label` customizes counts and empty states. Two-instance integration lives at `/development/table`; selection is documented in the Bulk Actions submenu. See [Phase 20](PHASE_20.md) for contracts and verification.

Table headings cycle ascending, descending, and unsorted. Shift-click combines columns with visible sort priorities; a plain click selects one column. Pagination includes translated Back/Next controls disabled at the boundaries. The Translations example lists all Table UI keys.

Table's Overview submenu appears first; the remaining submenus stay alphabetical. This exception is recorded in the documentation menu ordering rule in `AGENTS.md`.

The Query page documents `pageSizes()` with a copyable override: footer choices default to `[10, 25, 50]`, and the first choice is selected initially for either source type.

The Row Actions demo uses `href="#"` for its link button. The separate invoice detail page and route have been removed.

Text filters and global search use native search inputs. Select filters reuse Select, including remote option search through `searchUrl`; date, time, and datetime filters reuse Datetime Picker with canonical values. Column `format` closures receive the raw value and record for display formatting without a separate Blade view. The docs include a scoped option endpoint and all filter types.

Table filters stay open through focus changes and Livewire updates. Close them by clicking outside or activating the filter button. Escape closes a nested Select or calendar without dismissing the filters. Date filter calendars remain part of their owning dropdown even when rendered outside its DOM.

Phase 21 adds **Table Bulk Actions** at `/livewire-components/table/bulk-actions`. Return `bulkActionsView()` to enable per-row/current-page checkboxes and the ellipsis dropdown. Selection persists across pages and sorting; search/filter changes clear it. Consumer buttons receive `$selectedIds` and own their overlays, validation, authorization, execution, and cleanup. Loading disables bulk buttons while preserving search and filters. Use `clearSelection()` / `removeSelection()` or their scoped events after handling an action; Table does not infer outcomes. Data columns share the available width, with a compact checkbox column and horizontal scrolling on narrow screens. The Bulk Actions page lists its selection methods and state in a Functions and variables table. Checkbox states follow the current server selection after pagination and cleanup. Row and current-page selection requests update without a loading overlay; other Table requests and external loading retain it. See [Phase 21](PHASE_21.md) for the contract and verification.

Selecting a remote filter option preserves the Select's focus and resolved label without rebuilding the widget or replaying the filter panel's fade. Sort indicators use ↑ for ascending and ↓ for descending.

Moving focus into the calendar does not commit the date prematurely. Toolbar controls stay outside the loading area, so choosing a date keeps its input focused.

Phase 22 adds **Calendar** at `/livewire-components/calendar`, backed by internally bundled FullCalendar Standard 7.1.1. Extend `Sirius\Ui\Livewire\Calendar` and implement `events(start, end, timezone)` with scoped Eloquent or Collection data. Month, week, day, and agenda views support all-day/timed events, date/range actions, and simple recurrence. Application hooks own forms, permissions, persistence, and drag/resize acknowledgment; rejected or failed changes revert. Explicit locale/timezone override the existing global fallbacks. Calendar UI strings use the package `calendar` translation group. The development fixture at `/development/calendar` covers separate instances, RTL, Tabs, Dialog, and Slideover. See [Phase 22](PHASE_22.md) for API boundaries, dependency notices, and verification.

Calendar documentation follows the Table submenu pattern: **Overview** at the base URL, then **Actions**, **Events**, and **Options** at `/livewire-components/calendar/{topic}`. Each page has its own demo, copyable usage, attribute table, and content navigator. Actions contains the create/edit/delete form and drag/resize demo; Events shows both Eloquent and Collection sources; Options shows a localized work-week schedule. Global configuration is on Options, while translations remain a separate section on Overview.

Calendar loading uses Table's backdrop and spinner styles. The overlay covers the whole calendar, including the toolbar, while fetching events, running date/event actions, or saving drag/resize changes. It stays active through the subsequent event refresh. Controls unlock after success or failure; other calendars and application-owned forms remain usable. Focus returns to the previous control unless the user has moved elsewhere.

Calendar keeps its previous height while a new view loads, so the loading message stays in place. More-event popups retain the calendar theme outside the widget DOM and scroll within their own content. Resize handles stay inside event bounds, including events ending on Sunday, without adding a horizontal scrollbar.
