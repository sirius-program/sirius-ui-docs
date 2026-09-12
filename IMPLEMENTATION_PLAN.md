# Sirius UI Implementation Plan

Status: Phase 0 completed on 2026-09-12 following the user instruction to execute Phase 0. Phases 1–14 remain unstarted; await further implementation instructions.

Package: `D:/Projects/sirius-ui`  
Documentation and integration application: `D:/Projects/sirius-ui-docs`

Phase 0 checkboxes reflect executed work. The reusable phase gate remains an unchecked template; its Phase 0 outcome is recorded below. See PHASE_0.md for architecture boundaries, selected libraries, verification scope, and maintenance notes.

## 1. Agreed outcome and architecture

Deliver reusable Tailwind-styled Blade components and class-based Livewire components, with interactive documentation, meaningful automated tests, and no dependency on the consuming application's business models.

- Preserve Laravel 12/13 and Livewire 4 support. Verify valid PHP/framework/Testbench combinations instead of assuming every advertised PHP version supports both Laravel majors.
- Preserve the existing configurable Blade and Livewire namespaces, defaulting to `sirius`.
- Keep anonymous Blade components in `resources/views/components`, Livewire classes in `src/Livewire`, their views in `resources/views/livewire`, and JavaScript source in `resources/js`.
- Extract focused PHP helpers and JS adapters only when they remove real duplication or establish a necessary integration boundary. Avoid a generic repository/service layer for presentation components.
- Make Blade components work on ordinary Blade pages and inside Livewire. Livewire remains a package dependency; ordinary Blade usage must not require wrapping every input in a Livewire component.
- Preserve existing `sir-` styling and `--sir-` token conventions; support responsive layouts, light/dark themes, keyboard navigation, and visible focus.
- Use Blade Icons with a selected free icon set. Map `info` to Tailwind sky, `success` to emerald, `danger` to red, and `warning` to amber through customizable tokens.
- The table uses a consumer-defined subclass for query, columns, filters, and optional actions. Queries and authorization belong to the application; package code handles reusable interaction and presentation.
- Version-one calendar is a month grid with month/year navigation, today indication, date selection, and day actions. Event management, drag-and-drop, and range selection are outside this release.

## 2. Standing constraints

- Never read, print, or directly modify `.env`. Application code reads configuration via `config()`. If a selected library requires a key, ask the user to set it in `.env`, expose it through an appropriate config entry, and never expose server secrets to the browser.
- Use free library features with a license compatible with redistribution in this package. Record exact versions, licenses, required notices, and maintenance rationale before selecting a dependency.
- Bundle third-party JavaScript, styles, fonts, and related assets internally. No runtime CDN dependency. Preserve license notices; do not manually modify vendor source.
- Use one JS owner per widget. Avoid loading a second Alpine instance or initializing a widget twice.
- Third-party widgets must survive Livewire updates, navigation, conditional rendering, validation failures, and programmatic resets. An ignored DOM subtree alone is not proof of synchronization.
- Supply named props for common supported library options and a documented options bag for additional compatible options. Define precedence: component defaults, options bag, then explicit props. Protect lifecycle and value-synchronization callbacks from accidental replacement.
- Document unsupported options or differences between HTML and widget behavior instead of silently ignoring them.
- Add a docs menu entry and a working component page as each component is completed. Update the docs README/component index in the same phase.
- Keep the package README minimal: direct readers to the docs for usage details. Resolve the actual docs location before adding a published URL; do not invent one.
- Install `sirius/ui` into docs through a Composer path repository pointing to `../sirius-ui`, with local linking when supported and a documented mirror/update fallback. Never copy package components into docs.
- Keep docs demonstration models, factories, routes, and fixtures inside docs or package test fixtures; never make them production package dependencies.

## 3. Shared form contract

All form controls implement the following contract, including enhanced controls:

- `label`, `required`, `helper`, `id`, `name`, value/binding, disabled state, and applicable native attributes.
- Render labels through the shared label component. `required=true` appends a red asterisk and propagates the required state to the real input or equivalent accessible control.
- Render helper text below the control. Associate label, helper, and errors with the control through stable IDs, `for`, `aria-describedby`, and `aria-invalid`.
- Support Laravel validation error bags, explicit error-key overrides, nested field names, and Livewire validation updates. Prefer an explicit key, then the bound model path, then the normalized input name. Errors and helper text may coexist.
- Forward arbitrary native HTML attributes, `data-*`, `aria-*`, Alpine attributes, and Livewire directives to their intended control. Document a separate wrapper customization mechanism so control attributes are not accidentally attached to a container.
- Preserve native semantics where supported: disabled controls are not submitted; readonly controls retain values. For widgets without a native readonly concept, provide a documented equivalent that prevents interaction without disabling submission.
- Merge classes safely, keep consumer IDs stable, and avoid duplicate IDs for repeated or nested controls.
- Define initial values, server-to-client updates, client-to-server updates, and reset behavior. Do not generate duplicate submissions or synchronization loops.
- Client restrictions improve interaction; application-side validation remains required.
- Checkbox, radio, and switch share label/helper/error handling, with labels placed beside their controls. Use accessible group labeling for related choices. A required radio group means one choice is required; a required checkbox or switch means that individual control must be checked. Do not implement an at-least-one checkbox-group requirement by marking every checkbox required.

### Agreed public component shape

| Component | Contract |
| --- | --- |
| `label` | Text/slot, `for`, `required`; red required marker |
| `input` | `type=text|number|password`; optional prefix/suffix; password visibility control |
| `checkbox` | Native checkbox; boolean binding or array membership; `checked`, `value`, and optional `indeterminate` |
| `radio` | Native radio; shared group name/model, distinct option values, single selected value |
| `switch` | Native checkbox styled as an on/off switch with switch semantics; boolean binding |
| `currency` | Configurable separators and precision; separate display and canonical submitted value |
| `date-picker` | `mode=date|time|datetime`; display format, limits, locale, timezone configuration |
| `file-upload` | Single/multiple upload, progress, cancellation, type and size limits |
| `textarea` | Native textarea by default; `richtext=true` enables the editor |
| `select` | Single/multiple selection, local search, optional paginated server search |
| `card`, `modal` | String shorthands, header/footer named slots, body default slot; stable section IDs |
| `alert`, `badge`, `button` | `variant=info|success|danger|warning` |
| `collapsible` | Expandable content and accessible trigger; documented initial/open state |
| Livewire `table` | Consumer subclass with query, columns, filters, and optional actions |
| Livewire `calendar` | Month grid with selectable/actionable days |

Public spellings above are the plan baseline. Examples and tests must use one consistent spelling; do not introduce parallel aliases without an explicit compatibility need.

## 4. Mandatory completion gate for every phase

Apply this gate to every numbered phase below, including Phase 0. Subphases receive targeted checks as they are implemented; the parent phase cannot close until the full gate succeeds.

- [ ] Complete implementation, component-specific acceptance cases, and applicable architecture test updates.
- [ ] Add or update package feature tests and focused unit tests for framework-independent logic. Prefer observable behavior over implementation snapshots.
- [ ] Add docs integration/browser coverage for new interactions; browser tests assert no JavaScript errors. Static components receive appropriate rendering/docs coverage rather than redundant JS tests.
- [ ] Add the component docs menu/page, runnable examples, props/options, events, slots, validation, accessibility, and known limitations. Update the docs README/index and maintain the minimal package README.
- [ ] Build assets in each changed frontend project and verify that docs actually resolves the current local package assets.
- [ ] Run `composer test` in every project changed by the phase. If both projects changed, both must pass.
- [ ] Only after those commands pass, run `composer test:browser` in `sirius-ui-docs` and wait for completion.
- [ ] Fix phase-related failures and rerun the failing checks and required gate. Record pre-existing/environment blockers honestly; a blocked phase remains incomplete.
- [ ] Record command results, compatibility evidence, remaining limitations, and completed checklist items. Move to the next phase only after the gate is green.

## Phase 0 — Architecture rules, integration, and verification foundation

Prerequisite: explicit user instruction to begin implementation.

### 0.1 Establish the architecture contract before building any component

- [x] Read applicable project rules and inspect installed dependencies and existing tests without accessing `.env`.
- [x] Encode the agreed directory/namespace boundaries using Pest architecture tests where supported by the installed Pest version.
- [x] Assert package production classes do not depend on `App`, docs classes, test fixtures, or application-specific models.
- [x] Assert production Livewire components extend the appropriate Livewire base, including indirect inheritance through the table base class.
- [x] Enforce meaningful conventions: typed PHP boundaries, no debugging calls in production, and no environment access outside approved config files. Use suitable static checks where an architecture expectation cannot express a rule.
- [x] Keep queries/business mutations out of Blade templates; cover this through review/static enforcement appropriate to templates.
- [x] Do not impose `final` on intended extension points such as the table base class. Scope rules to relevant directories and exclude legitimate fixtures.
- [x] Verify the architecture suite runs inside `composer test`. Demonstrate that a temporary representative violation fails, then remove the temporary violation.
- [x] Document how later phases may refine architecture rules with a rationale, without weakening them simply to make tests pass.

### 0.2 Connect docs and validate the baseline

- [x] Add the local Composer path repository and `sirius/ui` dependency in docs; verify package auto-discovery and asset resolution.
- [x] Keep the package independent of docs' existing Flux UI dependency; existing docs shell components may remain in place.
- [x] Establish docs component navigation and a README index; reduce the package README to the docs pointer as requested.
- [x] Prepare deterministic test data and isolated browser test state. Preserve the projects' existing Pest majors rather than forcing them to match.
- [x] Verify the existing compatibility workflow against resolvable PHP/Laravel/Testbench combinations and update the matrix where necessary. Cover Laravel 12 and 13 with Livewire 4; docs remains the real application integration target.
- [x] Run the full phase completion gate to establish a recorded baseline.

### 0.3 Verify candidate integrations before committing to libraries

The following are candidate categories, not claims of verified compatibility or final dependency selections:

| Need | Evaluation starting point | Required proof |
| --- | --- | --- |
| Icons | Blade Icons and a free icon set | Rendering, license, internal assets |
| Date/time | Flatpickr or equivalent | Supported modes, limits, keyboard use, Livewire synchronization |
| File upload | FilePond, Dropzone, or equivalent | Free required features, temporary-upload bridge, cleanup/cancel behavior |
| Richtext | A free self-hostable editor; evaluate TinyMCE or an alternative | Redistribution license, no unexpected paid requirement, sanitized HTML contract, bundled assets |
| Select | Select2 or a lighter alternative | Multiple values, remote pagination, accessibility, JS lifecycle |
| Table/calendar | Native Livewire baseline; evaluate libraries only if needed | Clear reduction in complexity without conflicting ownership or paid features |

- [x] Check current official documentation and licenses; record chosen versions and sources in docs.
- [x] Create narrowly scoped integration proofs for risky widget synchronization before implementing their full component phases.
- [x] Choose the smallest suitable dependency set. jQuery is allowed if justified and bundled internally.
- [x] Establish JS loading and teardown for both ordinary Blade and Livewire contexts, including deferred initialization and multiple instances.
- [x] Define HTML sanitization ownership: richtext output is untrusted; application validation and server sanitization are required before rendering. The docs example must demonstrate a concrete, tested sanitization path.

Acceptance: architecture tests exist and pass before Phase 1; docs consumes the local package; dependency decisions and test baseline are recorded.

## Phase 1 — Shared form foundation and label

- [ ] Implement label, required marker, shared field layout, helper, and error rendering.
- [ ] Implement stable field/helper/error IDs, error-key resolution, and attribute routing.
- [ ] Ensure the shared field layout supports labels beside checkbox/radio/switch controls and accessible group labels with shared helper/error associations.
- [ ] Establish size, spacing, focus, invalid, disabled, readonly, light/dark, and responsive styles through shared tokens.
- [ ] Test required true/false, escaped text, named error bags, nested names, helper/error coexistence, explicit IDs, and multiple controls.
- [ ] Add label and form-conventions docs pages with native Blade and Livewire validation examples.
- [ ] Complete the mandatory phase gate.

## Phase 2 — Basic inputs, textarea, checkbox, radio, and switch

### 2.1 Text and number

- [ ] Implement `input` with text/number types and optional string/slot prefix and suffix.
- [ ] Forward applicable HTML attributes, including min/max/step, minlength/maxlength, pattern, autocomplete, inputmode, disabled, and readonly.
- [ ] Keep prefix/suffix separate from the submitted value; handle long adornments and validation styles.

### 2.2 Password and textarea

- [ ] Add the password eye icon with an accessible label and button semantics that do not submit the parent form.
- [ ] Preserve the password value, selection/focus where practical, and Livewire binding while toggling visibility.
- [ ] Implement the native textarea with rows, cols, resize customization, helper, errors, and attribute forwarding.
- [ ] Test rendering and validation; browser-test password toggling, typing, resetting, and programmatic Livewire updates.
- [ ] Add input, password, and textarea docs pages.

### 2.3 Checkbox

- [ ] Implement `<x-sirius::checkbox>` using a native checkbox and the shared field contract. Keep this separate from text input to support its different layout and checked-state semantics without unrelated prefix/suffix props.
- [ ] Support a single boolean Livewire binding and multiple checkbox values bound to an array. For ordinary Blade forms, support explicit `value`, initial `checked`, and array-style names such as `roles[]`.
- [ ] Preserve native submission: unchecked controls are omitted; checked controls submit their configured value. Document server normalization for boolean fields. Do not insert same-name hidden fields that corrupt arrays or duplicate Livewire state.
- [ ] Expose `indeterminate` as an explicit visual/mixed state independent of checked state and submitted value; synchronize it after Livewire updates. This supports the future table header selection control.
- [ ] Test boolean and array binding, distinct values including `0`, initial checked state, required validation, disabled state, custom IDs, label activation, helper/errors, and attribute forwarding.
- [ ] Browser-test Space/label toggling, indeterminate state, server updates, form resets, and multiple instances without duplicated events.

### 2.4 Radio

- [ ] Implement `<x-sirius::radio>` using a native radio input. Options in a group share a name and Livewire property while retaining distinct IDs, labels, and values.
- [ ] Support initial selection, no initial selection, disabled options, required groups, and ordinary Blade form submission of exactly one selected value.
- [ ] Document value types and explicit Livewire casting where appropriate; do not silently turn all option values into booleans or confuse string `0` with an empty selection.
- [ ] Document accessible grouping with `fieldset`/`legend`, group helper/error text, and per-option labels using the shared label component.
- [ ] Test independent groups, changing selection, validation/error mapping, disabled options, and HTML/Livewire attribute forwarding.
- [ ] Browser-test native arrow-key/Space interaction, label activation, programmatic selection updates, and resets.

### 2.5 Switch

- [ ] Implement `<x-sirius::switch>` as a Tailwind-styled native checkbox with `role="switch"`, a stable accessible label, visible focus, and visually distinct on/off states in light/dark themes.
- [ ] Use boolean Livewire state and ordinary checkbox submission semantics. Support `checked`, explicit `value`, disabled, required, helper, and errors; do not introduce a fictitious HTML `type="switch"` or a third mixed state.
- [ ] Reuse checkbox checked-state/binding behavior where practical without coupling switch to array selection or checkbox indeterminate state.
- [ ] Preserve native keyboard and label activation. Keep checked state and any explicitly rendered accessibility state consistent during server updates and resets.
- [ ] Test initial on/off states, validation, disabled interaction, submitted values, focus/keyboard behavior, and Livewire synchronization without duplicate change events.

### 2.6 Choice-control documentation and completion

- [ ] Define and test the documented readonly equivalent for checkbox/radio/switch: block user changes while preserving form submission, focus, and server-driven updates. Do not claim that forwarding the native `readonly` attribute alone implements this behavior.
- [ ] Add separate Checkbox, Radio, and Switch docs menu entries/pages with ordinary Blade and Livewire examples, props, group semantics, helper/errors, disabled/readonly behavior, and keyboard instructions.
- [ ] Update the docs README/component index, maintain the package README docs pointer, and extend applicable architecture checks if shared internals are introduced.
- [ ] Complete the mandatory phase gate: `composer test` in each changed project, followed by `composer test:browser` in docs after all project checks pass.

## Phase 3 — Currency input

- [ ] Implement digits, decimal separator, grouping separator, paste normalization, and automatic thousand grouping. Default grouping is comma and decimal separator is dot.
- [ ] Keep the display value separate from the submitted canonical decimal string: display `1,234.50`, submit `1234.50`.
- [ ] Keep empty input empty; never coerce it to zero. Support configurable precision and opt-in negative values; reject a sign when negative values are disabled.
- [ ] Reject conflicting separators and malformed input predictably; avoid binary floating-point conversion for monetary normalization.
- [ ] Specify rounding/excess-precision behavior explicitly in docs before implementing it; default to validation rather than silently losing digits.
- [ ] Preserve caret behavior during editing and grouping. Forward relevant min/max and other attributes while documenting enforcement for the formatted text input.
- [ ] Test separator reversal, very large values, zero, fractions, invalid paste, leading/trailing separators, precision, empty values, negative opt-in, reset, and Livewire synchronization.
- [ ] Add currency docs and complete the mandatory phase gate.

## Phase 4 — Date, time, and datetime

- [ ] Implement `date-picker` using the verified library and modes date/time/datetime.
- [ ] Use canonical values `Y-m-d`, `H:i`, and `Y-m-d H:i:s` respectively; configure display format separately.
- [ ] Default timezone to application config and permit override. Do not silently convert submitted wall-clock values to UTC; application code owns persistence conversion and ambiguous/nonexistent DST-time validation.
- [ ] Expose compatible min/max dates or times, locale, week start, minute increment, disabled dates, clearability, and supported additional options.
- [ ] Test leap days, month/year boundaries, bounds, invalid typed input, clear/reset, disabled/readonly, and native Blade submission.
- [ ] Browser-test selection and server updates through re-renders, conditional mounting, navigation, and multiple widget instances.
- [ ] Add mode-specific examples under date-picker docs and complete the mandatory phase gate.

## Phase 5 — Searchable select

### 5.1 Local options

- [ ] Implement single/multiple values, placeholder, clearability, disabled options, groups where supported, and local searching.
- [ ] Define stable option value/label serialization, retaining values such as `0` and distinguishing empty single selection from an empty multiple array.

### 5.2 Server search

- [ ] Add an opt-in consumer-provided search provider with debounce, pagination, loading/empty/error states, and resolution of labels for preselected values.
- [ ] Ignore stale responses; preserve selected options when later search results omit them.
- [ ] Keep data access and authorization in the consuming application. Do not accept arbitrary client-provided model or query definitions.
- [ ] Provide an ordinary-Blade remote integration contract when server search is used outside Livewire; document the host application's endpoint responsibility.
- [ ] Test single/multiple submit/reset, keyboard selection, updates to options and values, paginated results, authorization boundaries, race conditions, and repeated mounting.
- [ ] Add select docs and complete the mandatory phase gate.

## Phase 6 — File upload

- [ ] Implement the verified upload widget with single/multiple mode, accept/type restrictions, size/count limits, progress, cancel, retry, and remove controls.
- [ ] Connect Livewire temporary uploads and propagate loading, validation, completion, failure, and cancellation states.
- [ ] Keep permanent storage, disk/path selection, authorization, and server validation in the application. Removing an existing file must never delete permanent data without an explicit application handler.
- [ ] Support ordinary Blade multipart forms with a verified native file-input submission path. Do not silently require a Livewire upload endpoint on ordinary pages.
- [ ] Expose applicable free widget options and document temporary file cleanup responsibility, existing-file representation, and browser limitations.
- [ ] Test rejection of invalid/oversized files, upload failure, cancel/retry, multiple upload, reset, and server validation. Use isolated fake storage where appropriate.
- [ ] Browser-test real file selection, progress/result state, remove, re-render, and duplicate-request prevention.
- [ ] Add upload docs with permanent-storage examples and complete the mandatory phase gate.

## Phase 7 — Richtext textarea

- [ ] Enable the verified editor through `textarea richtext=true`; preserve native textarea mode as the default.
- [ ] Expose toolbar, height, placeholder, readonly/disabled, locale, and compatible free editor options.
- [ ] Synchronize HTML for ordinary form submission and Livewire, including initial content, empty content, validation errors, and resets.
- [ ] Keep image upload outside version one. Ensure toolbar configuration does not imply an unsupported upload feature.
- [ ] Demonstrate server-side sanitization and safe output rendering in docs; test malicious markup and unsafe URLs through that integration.
- [ ] Browser-test editing, formatting, form submission, programmatic updates, teardown/remount, and multiple editors without duplicate initialization.
- [ ] Extend textarea docs and complete the mandatory phase gate.

## Phase 8 — Button, badge, and alert

- [ ] Implement the four semantic variants using the agreed Tailwind color mapping and customization tokens.
- [ ] Implement button `tag=button|a`, validating the allowed tag list. Default real buttons to `type=button`; require explicit submit behavior.
- [ ] Support icons, sizes, loading, focus, and disabled behavior. A disabled anchor must prevent mouse and keyboard activation and expose an accessible disabled state.
- [ ] Implement badge content and variants, with readable contrast in light/dark themes.
- [ ] Implement alert content, variants, appropriate announcement semantics, and `closable` with an accessible dismiss control and documented dismissal state.
- [ ] Test tag semantics, escaped content, attributes, loading/disabled states, and alert dismissal through Livewire updates.
- [ ] Add separate button, badge, and alert docs entries and complete the mandatory phase gate.

## Phase 9 — Card and collapsible

- [ ] Implement card string shorthands, named header/footer slots, and default body slot. Slots override corresponding string shorthands; document precedence.
- [ ] Give rendered sections `{id}-header`, `{id}-body`, and `{id}-footer` IDs; generate a stable unique root ID when omitted.
- [ ] Allow section-specific styling without overwriting stable IDs. Omit empty optional header/footer sections with documented behavior.
- [ ] Implement `collapsible` with accessible trigger, controlled open state, expanded/controls attributes, optional transition, and reduced-motion support.
- [ ] Test slot precedence, section IDs, multiple instances, keyboard toggling, hidden content focus behavior, and Livewire-driven state changes.
- [ ] Add card and collapsible docs entries and complete the mandatory phase gate.

## Phase 10 — Modal

- [ ] Reuse the agreed card-like content contract and section ID scheme for modal header/body/footer.
- [ ] Define open/close binding and events, sizing, initial focus, focus containment, focus return, body scroll handling, and accessible dialog naming.
- [ ] Support Escape and backdrop dismissal with explicit options to prevent each; prevent unintended form submission by close controls.
- [ ] Preserve state correctly during validation and re-renders; clean up listeners and scroll locks after removal/navigation.
- [ ] Cover multiple modal instances; scope version one to one active modal at a time and document nested/stacked dialogs as unsupported.
- [ ] Browser-test keyboard behavior, prevented close, focus restoration, Livewire-triggered opening/closing, and widgets mounted inside a modal.
- [ ] Add modal docs and complete the mandatory phase gate.

## Phase 11 — Livewire table core

### 11.1 Consumer extension contract and rendering

- [ ] Implement the table base class and focused definitions for columns/filters, with typed extension points and consumer-owned scoped Eloquent queries.
- [ ] Support stable row keys, escaped default cells, explicit custom cell views, empty/loading states, and responsive rendering.
- [ ] Keep column identifiers server-allowlisted; never use an unchecked client string as a query column or expression.

### 11.2 Search, filtering, ordering, and pagination

- [ ] Add debounced global search, per-column search/filter controls, ordering, configurable page sizes, and pagination.
- [ ] Reset pagination when search/filter/page-size changes; specify deterministic ordering with a unique tie-breaker.
- [ ] Use server pagination and eager-loading guidance to avoid loading entire tables or hidden per-row queries.
- [ ] Isolate state for multiple table instances. Document searchable/filterable/orderable column configuration and query responsibilities.
- [ ] Test combined filters, sort allowlisting, stable pagination, query scoping, no-result states, and tampered public state.
- [ ] Browser-test interactive searches, filters, ordering, pagination, and two tables on one page.
- [ ] Add table docs and complete the mandatory phase gate.

## Phase 12 — Table selection, bulk actions, and CSV

### 12.1 Selection and mutations

- [ ] Reuse the shared checkbox component for per-row selection and the indeterminate header checkbox; add a visible selection count across pages.
- [ ] Header selection applies to the current page; selection persists across page navigation and resets when search/filter changes. Selecting all matching results is outside version one.
- [ ] Make delete, restore, force delete, and CSV independently opt-in. Provide no implicit write permissions.
- [ ] Re-query selected IDs through the consumer's authorized/scoped query and authorize every row at execution time. Reject tampered, stale, or inaccessible IDs without expanding scope.
- [ ] Enable restore/force-delete only for supported soft-deleted records. Application handlers own domain side effects and transactions.
- [ ] Add confirmation UX for destructive actions, duplicate-submit protection, success/failure feedback, and selection cleanup.
- [ ] Specify atomic failure as the built-in default: validate and authorize the whole selection before changing data. Custom handlers must document deviations and external side effects.

### 12.2 CSV export

- [ ] Export selected authorized rows through configured exportable columns. Do not silently export all results when selection is empty.
- [ ] Stream/chunk output where appropriate, escape CSV correctly, mitigate spreadsheet formula injection, and document encoding and selection limits.
- [ ] Keep queued exports and exports of all matching results outside version one.
- [ ] Test cross-page selection, filter reset, unauthorized rows, stale selections, soft-delete/restore/force-delete behavior, transaction failure, CSV escaping, and formula-like cells.
- [ ] Browser-test selection, confirmation, completion/failure feedback, and CSV download.
- [ ] Extend table docs and complete the mandatory phase gate.

## Phase 13 — Livewire calendar

- [ ] Implement the agreed month view using native Livewire unless Phase 0 demonstrates a clear benefit from a free library.
- [ ] Default to the current month in the configured application timezone; provide previous/next month, month/year selectors, and return-to-today.
- [ ] Support localized labels, configurable week start, selected/today styles, optional date bounds, and disabled dates.
- [ ] Render a consistent grid across month boundaries with a documented treatment of adjacent-month days.
- [ ] Expose a typed day action/event with a canonical date; consumer application code handles authorization and domain behavior.
- [ ] Add accessible keyboard navigation and labels without making every day an unrelated tab stop.
- [ ] Test leap years, year transitions, timezone-sensitive today, bounds, invalid navigation state, and day-action payloads using deterministic time.
- [ ] Browser-test navigation, selecting month/year, keyboard operation, day actions, and Livewire updates.
- [ ] Add calendar docs and complete the mandatory phase gate.

## Phase 14 — Cross-component validation and release readiness

- [ ] Exercise representative forms combining label, helper, error, checkbox, radio, switch, currency, date, upload, richtext, and select inside a modal.
- [ ] Verify repeated components, multiple instances, validation failures, form reset, conditional rendering, and Livewire navigation without state loss or leaked listeners.
- [ ] Review keyboard access, focus, light/dark contrast, mobile layouts, and reduced-motion behavior across docs examples.
- [ ] Verify an ordinary Blade form and a Livewire form submit the documented canonical values, including disabled/readonly behavior.
- [ ] Verify internal assets load with no runtime CDN requests and no duplicate Alpine/widget initialization.
- [ ] Verify package distribution includes compiled assets and license notices; validate a clean docs installation against the local dependency instructions.
- [ ] Finish compatibility checks for the supported Laravel/PHP combinations and record limitations. Do not claim browser/OS support without evidence.
- [ ] Audit docs navigation, prop tables, events, slots, options, examples, config instructions, and the minimal package README pointer.
- [ ] Record a release checklist/changelog and any deferred work. Publishing or deploying is outside this plan unless separately requested.
- [ ] Complete the mandatory phase gate and confirm every promised version-one component is represented in docs.

## Progress record

For each phase, append its outcome here when it is actually executed:

| Phase | Status | Changed projects | `composer test` results | Docs browser result | Evidence or blockers |
| --- | --- | --- | --- | --- | --- |
| 0 | Complete | Package and docs | Both passed: package 5 tests / 31 assertions; docs 6 tests / 21 assertions; lint, types, refactoring passed | Passed: 4 tests / 31 assertions | Both asset builds passed; isolated Laravel 12 suite passed (5 tests / 31 assertions); architecture negative control confirmed; npm/Composer audits passed. See PHASE_0.md. |
| 1–14 | Not started | None | Not run for implementation | Not run for implementation | Awaiting further implementation instruction |

Planning-document verification on 2026-09-12: only this Markdown file was added. In docs, `composer test` passed (Pint, PHPStan, Rector, and 1 existing test with 4 assertions), followed by `composer test:browser` passing (1 existing test with 2 assertions). These baseline checks do not validate unimplemented components or complete any phase. The package was unchanged, so its suite was not run for this documentation-only change.

Any additional implementation detail that changes the agreed public behavior must be surfaced before coding that behavior. Routine implementation choices and dependency verification within this plan do not require repeating already-granted approval.
