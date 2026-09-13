# Sirius UI Implementation Plan


Package: `D:/Projects/sirius-ui`  
Documentation and integration application: `D:/Projects/sirius-ui-docs`

Phase 0 through Phase 3 checkboxes reflect executed work. The reusable phase gate remains an unchecked template. The expanded roadmap runs through Phase 24; phases 0–3 retain their completed status, Slider precedes Form, the AI skill follows all component phases, and Flux migration immediately precedes final validation. See PHASE_0.md, PHASE_1.md, PHASE_2.md, and PHASE_3.md for architecture boundaries, decisions, verification scope, and maintenance notes.

## 1. Agreed outcome and architecture

Deliver reusable Tailwind-styled Blade components and class-based Livewire components, with interactive documentation, meaningful automated tests, and no dependency on the consuming application's business models.

- Preserve Laravel 12/13 and Livewire 4 support. Verify valid PHP/framework/Testbench combinations instead of assuming every advertised PHP version supports both Laravel majors.
- Preserve the existing configurable Blade and Livewire namespaces, defaulting to `sirius`.
- Keep anonymous Blade components in `resources/views/components`, Livewire classes in `src/Livewire`, their views in `resources/views/livewire`, and JavaScript source in `resources/js`.
- Permit narrowly scoped class-backed Blade adapters in `src/View/Components` when scoped methods are necessary. Phase 1's `Field` computes one control attribute bag for both the caller's slot and the surrounding layout; `label` remains anonymous. Architecture tests require these adapters to extend Laravel's component base and prohibit database dependencies.
- Extract focused PHP helpers and JS adapters only when they remove real duplication or establish a necessary integration boundary. Avoid a generic repository/service layer for presentation components.
- Make Blade controls work on ordinary Blade pages and inside Livewire. The `form` component is specifically for ordinary browser submissions to application controllers, without Livewire submission handling. Livewire remains a package dependency; ordinary Blade usage must not require wrapping every input in a Livewire component.
- Preserve existing `sir-` styling and `--sir-` token conventions; support responsive layouts, light/dark themes, keyboard navigation, and visible focus.
- Use Blade Icons with a selected free icon set. Map `info` to Tailwind sky, `success` to emerald, `danger` to red, and `warning` to amber through customizable tokens.
- The table uses a consumer-defined subclass for query, columns, filters, and optional actions. Queries and authorization belong to the application; package code handles reusable interaction and presentation. Consumers can register custom row, bulk, and toolbar actions alongside the optional built-in actions.
- Version-one calendar is a month grid with month/year navigation, today indication, date selection, and day actions. Event management, drag-and-drop, and range selection are outside this release.

## 2. Standing constraints

- Route request-handling logic through controllers, never inline route closures. Design controllers around resources and Laravel's standard CRUD actions (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`). When a controller needs only one action, use `__invoke()`. Model additional operations as focused resources rather than accumulating custom action methods.
- Never read, print, or directly modify `.env`. Application code reads configuration via `config()`. If a selected library requires a key, ask the user to set it in `.env`, expose it through an appropriate config entry, and never expose server secrets to the browser.
- Use free library features with a license compatible with redistribution in this package. Record exact versions, licenses, required notices, and maintenance rationale before selecting a dependency.
- Bundle third-party JavaScript, styles, fonts, and related assets internally. No runtime CDN dependency. Preserve license notices; do not manually modify vendor source.
- Use one JS owner per widget. Avoid loading a second Alpine instance or initializing a widget twice.
- Third-party widgets must survive Livewire updates, navigation, conditional rendering, validation failures, and programmatic resets. An ignored DOM subtree alone is not proof of synchronization.
- Supply named props for common supported library options and a documented options bag for additional compatible options. Define precedence: component defaults, options bag, then explicit props. Protect lifecycle and value-synchronization callbacks from accidental replacement.
- Document unsupported options or differences between HTML and widget behavior instead of silently ignoring them.
- Add a docs menu entry and a working component page as each component is completed. Update the docs README/component index in the same phase.
- Use the same component documentation pattern: Demo, Usage, Props and attributes, followed by Shared field contract and Assets and interaction when applicable. Stack Livewire and Blade demos with matching controls and values; share Submit / Validate, Load Value, and Reset Sample buttons, with Toggle Readonly only in Livewire. Render props in minimal responsive tables (name, type, mandatory, default, description), followed by accurate HTML5/Alpine/data/ARIA/Livewire support notes. Highlight usage syntax and provide copy controls using the shared docs presentation components.
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
- Merge classes safely and preserve explicit consumer IDs. Components needing an ID generate a random five-character string when it is omitted or null; helper/error/trigger associations must use the same generated ID. Generated IDs may change on a fresh server render; document explicit IDs for stable Livewire identity, repeated records, and external selectors.
- Define initial values, server-to-client updates, client-to-server updates, and reset behavior. Do not generate duplicate submissions or synchronization loops.
- Client restrictions improve interaction; application-side validation remains required.
- Checkbox, radio, and switch share label/helper/error handling, with labels placed beside their controls. Use accessible group labeling for related choices. A required radio group means one choice is required; a required checkbox or switch means that individual control must be checked. Do not implement an at-least-one checkbox-group requirement by marking every checkbox required.

### Agreed public component shape

| Component | Contract |
| --- | --- |
| `label` | Text/slot, `for`, `required`; red required marker |
| `input` | `type=text\|number\|password`; optional prefix/suffix; password visibility control |
| `checkbox` | Native checkbox; boolean binding or array membership; `checked`, `value`, and optional `indeterminate` |
| `radio` | Native radio; shared group name/model, distinct option values, single selected value |
| `switch` | Native checkbox styled as an on/off switch with switch semantics; boolean binding |
| `currency` | Configurable separators and precision; separate display and canonical submitted value |
| `date-picker` | `mode=date\|time\|datetime`; display format, limits, locale, timezone configuration |
| `file-upload` | Single/multiple upload, progress, cancellation, type and size limits |
| `textarea` | Native textarea by default; `editor=true` enables the editor |
| `select` | Single/multiple selection, local search, optional paginated server search |
| `slider` | Single numeric value by default; `range=true` uses two values and exactly two numeric entries in each of `min`, `max`, and `step` |
| `form` | Ordinary Blade submission; explicit `action`; `method=GET` by default; automatic CSRF for non-GET methods and method spoofing for PUT/PATCH/DELETE; `sending-file=false` by default |
| `card`, `dialog` | String shorthands, header/footer named slots, body default slot; stable section IDs |
| `message`, `badge`, `button` | `variant=info\|success\|danger\|warning\|secondary\|ghost\|outline`; Button also supports `link` and optional `icon`; Message preserves the former inline Alert behavior and `closable` |
| `icon`, `button-group` | Blade Icons wrapper; visual button grouping without selection state |
| `alert` | Dialog-based prompt with optional icon, escaped text, and a free-form footer slot |
| `avatar` | Image with string fallback for initials; `size`, `variant=rounded\|circle`, `fallback`, `alt` |
| `breadcrumb` | Item slots, configurable `separator`, and current-page semantics |
| `menu`, `dropdown` | Shared nested item contract: optional `icon`, `name`, optional `link`, optional `trailing` string/slot, `disabled`, `active` |
| `tooltip`, `popover` | `variant=default\|primary\|secondary\|warning\|success\|danger`; text tooltip versus HTML-slot popover |
| `separator`, `skeleton` | Horizontal/vertical styled separator; fading loading placeholder with reduced-motion support |
| `slideover` | Dialog interaction contract with `side=top\|right\|bottom\|left`; preserve scrollbar space |
| `tabs` | Local panels, keyboard navigation, and active-tab binding |
| `timeline` | Vertical sequence with numbered/icon markers, title, description, content slot, and completed/current/upcoming states |
| Livewire `chart` | Library-backed chart with serializable options and a local JavaScript callback/plugin extension point |
| `collapsible` | Expandable content and accessible trigger; documented initial/open state |
| Livewire `table` | Consumer subclass with query, columns, filters, optional built-in actions, and custom row/bulk/toolbar actions |
| Livewire `calendar` | Month grid with selectable/actionable days |

The former inline Alert is named `message` without changing its planned behavior; the new `alert` is a distinct Dialog-based prompt. The former Modal is named `dialog` without changing its planned behavior, with explicit scrollbar-space preservation.

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
| Editor | A free self-hostable editor; evaluate TinyMCE or an alternative | Redistribution license, no unexpected paid requirement, sanitized HTML contract, bundled assets |
| Select | Select2 or a lighter alternative | Multiple values, remote pagination, accessibility, JS lifecycle |
| Table/calendar | Native Livewire baseline; evaluate libraries only if needed | Clear reduction in complexity without conflicting ownership or paid features |

- [x] Check current official documentation and licenses; record chosen versions and sources in docs.
- [x] Create narrowly scoped integration proofs for risky widget synchronization before implementing their full component phases.
- [x] Choose the smallest suitable dependency set. jQuery is allowed if justified and bundled internally.
- [x] Establish JS loading and teardown for both ordinary Blade and Livewire contexts, including deferred initialization and multiple instances.
- [x] Define HTML sanitization ownership: editor output is untrusted; application validation and server sanitization are required before rendering. The docs example must demonstrate a concrete, tested sanitization path.

Acceptance: architecture tests exist and pass before Phase 1; docs consumes the local package; dependency decisions and test baseline are recorded.

## Phase 1 — Shared form foundation and label

- [x] Implement label, required marker, shared field layout, helper, and error rendering.
- [x] Implement stable field/helper/error IDs, error-key resolution, and attribute routing.
- [x] Ensure the shared field layout supports labels beside checkbox/radio/switch controls and accessible group labels with shared helper/error associations.
- [x] Establish size, spacing, focus, invalid, disabled, readonly, light/dark, and responsive styles through shared tokens.
- [x] Test required true/false, escaped text, named error bags, nested names, helper/error coexistence, explicit IDs, and multiple controls.
- [x] Document Label with paired native Blade and Livewire examples; keep shared field guidance on component pages and low-level validation fixtures in development.
- [x] Complete the mandatory phase gate.

Verification: package `composer test` passed (17 tests, 95 assertions), docs `composer test` passed (10 tests, 48 assertions), then docs `composer test:browser` passed (8 tests, 59 assertions). Both asset builds passed. See PHASE_1.md for the composition contract and architecture refinement.

## Phase 2 — Basic inputs, textarea, checkbox, radio, and switch

### 2.1 Text and number

- [x] Implement `input` with text/number types and optional string/slot prefix and suffix.
- [x] Forward applicable HTML attributes, including min/max/step, minlength/maxlength, pattern, autocomplete, inputmode, disabled, and readonly.
- [x] Keep prefix/suffix separate from the submitted value; handle long adornments and validation styles.

### 2.2 Password and textarea

- [x] Add the password eye icon with an accessible label and button semantics that do not submit the parent form.
- [x] Preserve the password value, selection/focus where practical, and Livewire binding while toggling visibility.
- [x] Implement the native textarea with rows, cols, resize customization, helper, errors, and attribute forwarding.
- [x] Test rendering and validation; browser-test password toggling, typing, resetting, and programmatic Livewire updates.
- [x] Document text/number/password together on the Input page and provide a separate Textarea page.

### 2.3 Checkbox

- [x] Implement `<x-sirius::checkbox>` using a native checkbox and the shared field contract. Keep this separate from text input to support its different layout and checked-state semantics without unrelated prefix/suffix props.
- [x] Support a single boolean Livewire binding and multiple checkbox values bound to an array. For ordinary Blade forms, support explicit `value`, initial `checked`, and array-style names such as `roles[]`.
- [x] Preserve native submission: unchecked controls are omitted; checked controls submit their configured value. Document server normalization for boolean fields. Do not insert same-name hidden fields that corrupt arrays or duplicate Livewire state.
- [x] Expose `indeterminate` as an explicit visual/mixed state independent of checked state and submitted value; synchronize it after Livewire updates. This supports the future table header selection control.
- [x] Test boolean and array binding, distinct values including `0`, initial checked state, required validation, disabled state, custom IDs, label activation, helper/errors, and attribute forwarding.
- [x] Browser-test Space/label toggling, indeterminate state, server updates, form resets, and multiple instances without duplicated events.

### 2.4 Radio

- [x] Implement `<x-sirius::radio>` using a native radio input. Options in a group share a name and Livewire property while retaining distinct IDs, labels, and values.
- [x] Support initial selection, no initial selection, disabled options, required groups, and ordinary Blade form submission of exactly one selected value.
- [x] Document value types and explicit Livewire casting where appropriate; do not silently turn all option values into booleans or confuse string `0` with an empty selection.
- [x] Document accessible grouping with `fieldset`/`legend`, group helper/error text, and per-option labels using the shared label component.
- [x] Test independent groups, changing selection, validation/error mapping, disabled options, and HTML/Livewire attribute forwarding.
- [x] Browser-test native arrow-key/Space interaction, label activation, programmatic selection updates, and resets.

### 2.5 Switch

- [x] Implement `<x-sirius::switch>` as a Tailwind-styled native checkbox with `role="switch"`, a stable accessible label, visible focus, and visually distinct on/off states in light/dark themes.
- [x] Use boolean Livewire state and ordinary checkbox submission semantics. Support `checked`, explicit `value`, disabled, required, helper, and errors; do not introduce a fictitious HTML `type="switch"` or a third mixed state.
- [x] Reuse checkbox checked-state/binding behavior where practical without coupling switch to array selection or checkbox indeterminate state.
- [x] Preserve native keyboard and label activation. Keep checked state and any explicitly rendered accessibility state consistent during server updates and resets.
- [x] Test initial on/off states, validation, disabled interaction, submitted values, focus/keyboard behavior, and Livewire synchronization without duplicate change events.

### 2.6 Choice-control documentation and completion

- [x] Define and test the documented readonly equivalent for checkbox/radio/switch: block user changes while preserving form submission, focus, and server-driven updates. Do not claim that forwarding the native `readonly` attribute alone implements this behavior.
- [x] Add one combined Checkbox, Radio & Switch docs menu entry/page, with separate sections for each component's ordinary Blade and Livewire examples, props, group semantics, helper/errors, disabled/readonly behavior, and keyboard instructions.
- [x] Update the docs README/component index, maintain the package README docs pointer, and extend applicable architecture checks if shared internals are introduced.
- [x] Complete the mandatory phase gate: `composer test` in each changed project, followed by `composer test:browser` in docs after all project checks pass.

Verification: package `composer test` passed (32 tests, 179 assertions), docs `composer test` passed (24 tests, 106 assertions), then docs `composer test:browser` passed (15 tests, 168 assertions). Both asset builds passed. See PHASE_2.md for architecture, native semantics, asset setup, and browser coverage.

## Phase 3 — Currency input

- [x] Implement digits, decimal separator, grouping separator, paste normalization, and automatic thousand grouping. Default grouping is comma and decimal separator is dot.
- [x] Keep the display value separate from the submitted canonical decimal string: display `1,234.50`, submit `1234.50`.
- [x] Keep empty input empty; never coerce it to zero. Support configurable precision and opt-in negative values; reject a sign when negative values are disabled.
- [x] Reject conflicting separators and malformed input predictably; avoid binary floating-point conversion for monetary normalization.
- [x] Specify rounding/excess-precision behavior explicitly in docs before implementing it; default to validation rather than silently losing digits.
- [x] Preserve caret behavior during editing and grouping. Forward relevant min/max and other attributes while documenting enforcement for the formatted text input.
- [x] Test separator reversal, very large values, zero, fractions, invalid paste, leading/trailing separators, precision, empty values, negative opt-in, reset, and Livewire synchronization.
- [x] Add currency docs and complete the mandatory phase gate.

Verification: package `composer test` passed (56 tests, 277 assertions), docs `composer test` passed (59 tests, 262 assertions), followed by docs `composer test:browser` (34 tests, 367 assertions). Both asset builds passed. Currency rendering/configuration tests also passed on the existing Laravel 12 compatibility fixture (15 tests, 43 assertions). See PHASE_3.md for decimal semantics, integration coverage, and limitations.

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

## Phase 7 — Textarea editor

- [ ] Enable the verified editor through `textarea editor=true`; preserve native textarea mode as the default.
- [ ] Expose toolbar, height, placeholder, readonly/disabled, locale, and compatible free editor options.
- [ ] Synchronize HTML for ordinary form submission and Livewire, including initial content, empty content, validation errors, and resets.
- [ ] Keep image upload outside version one. Ensure toolbar configuration does not imply an unsupported upload feature.
- [ ] Demonstrate server-side sanitization and safe output rendering in docs; test malicious markup and unsafe URLs through that integration.
- [ ] Browser-test editing, formatting, form submission, programmatic updates, teardown/remount, and multiple editors without duplicate initialization.
- [ ] Extend textarea docs and complete the mandatory phase gate.

## Phase 8 — Slider

### 8.1 Single-value and range contracts

- [ ] Implement `slider` using the shared field contract, with a single numeric `value` by default and numeric `min`, `max`, and positive `step`.
- [ ] Enable two handles with `range=true`; require exactly two numeric values and exactly two numeric entries in each of `min`, `max`, and `step`. Index 0 configures the first handle; index 1 configures the second. Reject scalar limits/steps in range mode rather than silently expanding them.
- [ ] Use one visual scale spanning both configured handle domains. Each handle respects its own bounds and step grid anchored at its own minimum. Require finite numbers, positive steps, valid ordered bounds, and a configuration admitting at least one ordered pair; reject invalid configuration clearly.
- [ ] Keep the first value less than or equal to the second. Handles cannot cross; constrain movement to the nearest permitted step without crossing the other value. Reject invalid supplied/programmatic values with clear feedback rather than silently swapping handles.
- [ ] Support keyboard, pointer, and touch interaction, accessible names for both handles, value announcements, visible focus, disabled/readonly semantics, and responsive light/dark styling.
- [ ] Define ordinary Blade names/payloads for a scalar and an ordered pair, array binding in Livewire/Alpine, server updates, native reset, and single group-level label/helper/error output.

Agreed range example:

```blade
<x-sirius::slider
    range
    :value="[20, 80]"
    :min="[0, 0]"
    :max="[100, 100]"
    :step="[1, 5]"
/>
```

### 8.2 Verification and documentation

- [ ] Test scalar/array shape validation, invalid bounds/steps, decimal steps, independent handle constraints, equal values, and crossing prevention. Cover canonical native submission and Livewire server/client updates.
- [ ] Browser-test both modes, keyboard/touch/pointer movement, reset, readonly/disabled states, validation, and multiple instances. Verify debounce/re-renders do not erase an in-progress value.
- [ ] Add matching real-world Blade/Livewire demos and separate copyable usage for single/range modes; document the per-handle array contract and complete the mandatory phase gate.

## Phase 9 — Ordinary Blade form

Prerequisite: complete all form-control phases through Phase 8, including Slider. This component simplifies ordinary Blade form markup and browser submissions; it does not manage Livewire submissions.

### 9.1 Native form contract

- [ ] Implement `<x-sirius::form>` with a default slot for form contents and a required, explicit `action` URL. Keep route generation in the consuming application.
- [ ] Default `method` to `GET`. Accept GET, POST, PUT, PATCH, and DELETE case-insensitively; reject unsupported methods with a clear configuration error.
- [ ] Render GET and POST as native HTML form methods. Render PUT, PATCH, and DELETE as POST with exactly one hidden `_method` containing the requested method.
- [ ] Automatically render exactly one CSRF field for every non-GET method; render no automatic CSRF or method-spoofing field for GET. Document that consumers should not add duplicate `@csrf` or `@method` directives inside the slot.
- [ ] Accept boolean `sending-file`, defaulting to `false`, including explicit `:sending-file="false"`. When true, render `enctype="multipart/form-data"` and consume the prop rather than forwarding it as an HTML attribute.
- [ ] Reject `sending-file=true` with GET or an explicitly conflicting `enctype`. Accept an explicitly matching multipart enctype. When `sending-file=false`, preserve native enctype behavior and any explicit HTML enctype.
- [ ] Forward applicable HTML5 form attributes, including `id`, `name`, `target`, `autocomplete`, `novalidate`, `accept-charset`, and `rel`, plus `data-*` and `aria-*`. Merge consumer classes safely and prevent duplicated generated method/enctype attributes.
- [ ] Keep submission native: no AJAX, automatic loading state, or Livewire submission integration. Document that native submit-button overrides retain their HTML meaning and must remain consistent with the configured form method and upload encoding.
- [ ] Leave validation, authorization, redirects, `old()` values, error bags, and persistence to application controllers and existing field controls. Do not introduce form-owned model state, automatic error summaries, upload endpoints, or dependencies.

### 9.2 Verification and documentation

- [ ] Add rendering tests for default GET, mixed-case methods, explicit action, missing action, unsupported methods, CSRF presence/absence and uniqueness, spoofed methods, slot content, escaped attributes, and attribute/class forwarding.
- [ ] Test `sending-file` true/false, automatic multipart encoding, matching/conflicting explicit enctype, GET rejection, and absence of leaked component props.
- [ ] Add ordinary Blade docs examples for GET search, POST submission, PUT/PATCH/DELETE method spoofing, and multipart file submission using the package controls. Use CRUD-oriented controllers; use invocable controllers for single-action resources.
- [ ] Test actual request methods and payloads, application validation redirects and error bags, restored `old()` values, and uploads using isolated test storage. Include valid and missing/invalid CSRF cases with CSRF protection explicitly active; default test middleware bypass is not sufficient evidence.
- [ ] Browser-test native GET/POST submission, a spoofed update/delete request, file submission, and validation feedback without Livewire submission handling. Assert no JavaScript errors and verify canonical submitted control values.
- [ ] Add a Form docs menu/page, document all defaults and rejected combinations, and update the docs README/index. Keep the package README as a minimal docs pointer.
- [ ] Update applicable architecture tests only if necessary, then complete the mandatory phase gate: `composer test` in every changed project, followed by `composer test:browser` in docs after all checks pass, waiting for completion.

Acceptance: consumers can compose a native form with an explicit action, receive GET behavior by default, submit other supported methods with automatic CSRF/method spoofing, and enable multipart file submission with `sending-file` without introducing Livewire or AJAX submission behavior.

## Phase 10 — Icon, button, button group, badge, and message

- [ ] Implement Message, Badge, and Button variants `info`, `success`, `danger`, `warning`, `secondary`, `ghost`, and `outline`. Preserve the four semantic color mappings; define secondary as a neutral treatment, ghost as a minimal background treatment, and outline as a bordered treatment using shared theme tokens.
- [ ] Implement a reusable `icon` wrapper around the chosen Blade Icons set, with name, size, styling, and accessible/decorative semantics; use it across components and later docs migration.
- [ ] Give Button an optional `icon` prop and an accessible name requirement for icon-only buttons. Add `variant="link"` as a visual style independent of `tag="a"`; preserve focus and disabled semantics.
- [ ] Implement `button-group` as a visual grouping of buttons with shared borders/radii and appropriate group labeling. Do not introduce selection state or toggle behavior.
- [ ] Implement button `tag=button|a`, validating the allowed tag list. Default real buttons to `type=button`; require explicit submit behavior.
- [ ] Support icons, sizes, loading, focus, and disabled behavior. A disabled anchor must prevent mouse and keyboard activation and expose an accessible disabled state.
- [ ] Implement badge content and variants, with readable contrast in light/dark themes.
- [ ] Implement message content, variants, appropriate announcement semantics, and `closable` with an accessible dismiss control and documented dismissal state.
- [ ] Test icon accessibility, button-group composition, every variant, link styling versus anchor semantics, escaped content, attributes, loading/disabled states, and Message dismissal through Livewire updates.
- [ ] Add icon, button, button-group, badge, and message docs entries and complete the mandatory phase gate.

## Phase 11 — Card and collapsible

- [ ] Implement card string shorthands, named header/footer slots, and default body slot. Slots override corresponding string shorthands; document precedence.
- [ ] Give rendered sections `{id}-header`, `{id}-body`, and `{id}-footer` IDs; generate a random five-character root ID when omitted, following the shared ID contract; require explicit IDs when stable identity across server renders is needed.
- [ ] Allow section-specific styling without overwriting stable IDs. Omit empty optional header/footer sections with documented behavior.
- [ ] Implement `collapsible` with accessible trigger, controlled open state, expanded/controls attributes, optional transition, and reduced-motion support.
- [ ] Test slot precedence, section IDs, multiple instances, keyboard toggling, hidden content focus behavior, and Livewire-driven state changes.
- [ ] Add card and collapsible docs entries and complete the mandatory phase gate.

## Phase 12 — Dialog

- [ ] Reuse the agreed card-like content contract and section ID scheme for dialog header/body/footer.
- [ ] Define open/close binding and events, sizing, initial focus, focus containment, focus return, body scroll handling, and accessible dialog naming. Preserve the originally planned Modal behavior under the public name `dialog`; do not add a parallel `modal` alias.
- [ ] Preserve scrollbar space while locking background scrolling, using a stable gutter and an appropriate fallback where needed. Opening/closing must not shift page or fixed-position content; restore previous styles after close/removal/navigation. Share this behavior with Slideover.
- [ ] Support Escape and backdrop dismissal with explicit options to prevent each; prevent unintended form submission by close controls.
- [ ] Preserve state correctly during validation and re-renders; clean up listeners and scroll locks after removal/navigation.
- [ ] Cover multiple dialog instances; scope version one to one active dialog at a time and document nested/stacked dialogs as unsupported.
- [ ] Browser-test keyboard behavior, prevented close, focus restoration, Livewire-triggered opening/closing, widgets mounted inside a dialog, and unchanged page/fixed-content position with and without a scrollbar.
- [ ] Add dialog docs and complete the mandatory phase gate.

## Phase 13 — Alert and slideover

Prerequisite: Dialog and its shared focus/scroll-lock lifecycle are complete.

- [ ] Implement the new `alert` as a Dialog-based prompt inspired by SweetAlert presentation, without installing that library. Content consists only of optional `icon`, escaped `text`, and a consumer-controlled `footer` slot.
- [ ] Reuse Dialog open/close bindings, focus management, dismissal options, and scrollbar preservation. Do not add toast, timer, queue, or automatic business actions; footer actions belong to the consumer.
- [ ] Implement `slideover` with `side=top|right|bottom|left`, reusable header/body/footer composition, and simple reduced-motion-aware entry/exit transitions.
- [ ] Preserve scrollbar space for every side, restore focus and scroll styles on dismissal/removal/navigation, and share the one-active-overlay rule across Dialog, Alert, and Slideover. Nested/stacked overlays remain outside version one.
- [ ] Test Alert content escaping and arbitrary footer actions; browser-test focus, Escape/backdrop options, every Slideover side, Livewire updates, cleanup, and lack of layout shift.
- [ ] Add separate Alert and Slideover docs pages, distinguish Alert from inline Message, and complete the mandatory phase gate.

## Phase 14 — Avatar, separator, and skeleton

- [ ] Implement Avatar with image source, `alt`, configurable `size`, `variant=rounded|circle`, and `fallback` string for initials. Show fallback when the source is absent or fails, reserve image space, and avoid repeated error handling loops.
- [ ] Implement Separator as a theme-consistent horizontal rule by default with vertical orientation support and appropriate decorative/semantic behavior.
- [ ] Implement Skeleton with configurable dimensions/shape and a gentle flashing/fading effect; respect reduced motion and keep placeholders out of accessible content while allowing the parent to announce loading.
- [ ] Test Avatar fallback and image recovery after updates, size/shape output, separator semantics, and Skeleton accessibility; verify themes, layout, and reduced-motion behavior in docs.
- [ ] Add all three component docs entries and complete the mandatory phase gate.

## Phase 15 — Breadcrumb, menu, and dropdown

### 15.1 Shared navigation items

- [ ] Implement Breadcrumb with slotted items, configurable text/icon separator, navigation labeling, and current-page semantics. Decorative separators are hidden from assistive technology.
- [ ] Establish a shared Menu/Dropdown item contract: optional `icon`, `name`, optional `link`, optional `trailing`, `disabled`, and `active`. `trailing` accepts a plain string or named slot for shortcuts/badges; the slot takes precedence.
- [ ] Use links for navigation and non-submitting buttons for items without links that invoke Alpine/Livewire actions. Preserve consumer directives and prevent disabled mouse/keyboard activation.
- [ ] Support nested submenus and consumer-supplied item content without duplicating the item API. Document navigation semantics for Menu and action-menu semantics for Dropdown, including any semantic differences.

### 15.2 Interaction and verification

- [ ] Implement Dropdown trigger/open state, outside click and Escape dismissal, focus return, keyboard navigation, submenu navigation, and touch operation. Use simple entry/exit animations and reduced-motion support; nested items must not require hover.
- [ ] Keep submenus within the viewport and support long/scrollable menus, active items, and multiple instances. Clean up listeners and synchronize state through Livewire updates/navigation.
- [ ] Test names/links escaping, trailing string versus slot, nested structure, disabled/active states, action forwarding, and Breadcrumb separator/current item.
- [ ] Browser-test keyboard and touch submenus, dismissal/focus return, shortcut/count content, and Livewire-driven changes. Add all three docs pages and complete the mandatory phase gate.

## Phase 16 — Tooltip and popover

- [ ] Share positioning behavior that keeps overlays visible within the viewport; expose `variant=default|primary|secondary|warning|success|danger` with theme tokens and accessible contrast.
- [ ] Implement Tooltip with escaped text, hover/focus activation, Escape dismissal, and accessible trigger-description association. Do not place interactive content inside Tooltip.
- [ ] Implement Popover with an HTML content slot, click activation, Escape/outside-click dismissal, and support for interactive controls. Define focus entry/return without trapping focus as a modal dialog would.
- [ ] Preserve trigger attributes/events and handle overlays inside Dialog/Slideover without clipping, broken focus, or conflicting dismissal. Use one lifecycle owner and reduced-motion-aware transitions.
- [ ] Test attribute/content semantics; browser-test hover/focus versus click, keyboard use, viewport edges, HTML controls, multiple instances, Livewire lifecycle, and nested overlay interaction.
- [ ] Add separate Tooltip and Popover docs pages and complete the mandatory phase gate.

## Phase 17 — Tabs and timeline

- [ ] Implement Tabs for local content panels with stable trigger/panel associations, active-tab binding, keyboard navigation, disabled tabs, and accessible selected/hidden states. Preserve child form values when switching panels and document rendering behavior.
- [ ] Implement Timeline as a vertical sequence matching the supplied reference: connected markers, `completed`, `current`, and `upcoming` states, optional icons or numbers, title, description, and a content slot.
- [ ] Keep Timeline presentational: it does not own form validation, step progression, or automatic workflow actions. Consumer markup may provide links/actions without changing this responsibility.
- [ ] Test Tabs associations, state updates, and hidden panel focus; test Timeline states and escaping/slots. Browser-test keyboard tabs, Livewire state/value preservation, responsive rendering, and light/dark presentation.
- [ ] Add separate Tabs and Timeline docs pages and complete the mandatory phase gate.

## Phase 18 — Livewire table core

### 18.1 Consumer extension contract and rendering

- [ ] Implement the table base class and focused definitions for columns/filters, with typed extension points and consumer-owned scoped Eloquent queries.
- [ ] Support stable row keys, escaped default cells, explicit custom cell views, empty/loading states, and responsive rendering.
- [ ] Keep column identifiers server-allowlisted; never use an unchecked client string as a query column or expression.

### 18.2 Search, filtering, ordering, and pagination

- [ ] Add debounced global search, per-column search/filter controls, ordering, configurable page sizes, and pagination.
- [ ] Reset pagination when search/filter/page-size changes; specify deterministic ordering with a unique tie-breaker.
- [ ] Use server pagination and eager-loading guidance to avoid loading entire tables or hidden per-row queries.
- [ ] Isolate state for multiple table instances. Document searchable/filterable/orderable column configuration and query responsibilities.
- [ ] Test combined filters, sort allowlisting, stable pagination, query scoping, no-result states, and tampered public state.
- [ ] Browser-test interactive searches, filters, ordering, pagination, and two tables on one page.

### 18.3 Custom action definitions, row actions, and toolbar actions

- [ ] Provide typed action definitions registered server-side through the consumer's Table subclass. Each definition has a unique identifier within the table, label, optional icon, variant, visible/disabled conditions, and exactly one execution target: a link or an application handler.
- [ ] Support row actions with one scoped record (for example Edit or Approve), toolbar actions without row selection (for example Create or Import), and a shared contract that Phase 19 extends to bulk actions. Do not make toolbar actions depend on selected rows.
- [ ] Resolve links in application code and preserve navigation semantics; state-changing operations use handlers or appropriate application endpoints rather than mutation through GET links. Application endpoints retain CRUD/controller conventions.
- [ ] Dispatch handler actions only through registered identifiers and the matching action scope. Never accept arbitrary class/method/callback names from the browser. Re-query row IDs through the consumer's authorized query; reject unknown actions, mismatched scopes, stale/inaccessible records, and tampered input.
- [ ] Re-check action availability and authorization on the server at execution time, including after confirmation. Visible/disabled conditions improve presentation but never replace authorization; link destinations enforce their own authorization.
- [ ] Support optional simple confirmation through Alert and additional input through a consumer-supplied slot/view in Dialog. Expose the action/record context; the application owns form fields, validation, authorization, and business logic. Reuse overlay focus/dismissal behavior and avoid stacking Alert over Dialog.
- [ ] Provide loading/duplicate-submit protection, validation and success/failure feedback, cancellation, and table refresh after successful handler completion. Preserve table search/filter/order state and keep pagination valid after changes. Clear action-specific input/errors on close or action switch; isolate multiple Table instances.
- [ ] Test action registration and invalid definitions, link versus handler semantics, visibility/disabled enforcement, identifier/scope tampering, row re-querying, revoked authorization between opening and execution, validation failures, and result refresh.
- [ ] Browser-test custom row approval, a toolbar Create link, and a handler with additional input, including confirmation/cancellation, loading, failed validation, focus return, and multiple tables.
- [ ] Add Table docs with copyable subclass/action definitions and realistic row/toolbar demos, document application responsibilities and the upcoming bulk extension, and complete the mandatory phase gate.

## Phase 19 — Table selection, built-in/custom bulk actions, and CSV

### 19.1 Selection and mutations

- [ ] Reuse the shared checkbox component for per-row selection and the indeterminate header checkbox; add a visible selection count across pages.
- [ ] Header selection applies to the current page; selection persists across page navigation and resets when search/filter changes. Selecting all matching results is outside version one.
- [ ] Make delete, restore, force delete, and CSV independently opt-in. Provide no implicit write permissions.
- [ ] Re-query selected IDs through the consumer's authorized/scoped query and authorize every row at execution time. Reject tampered, stale, or inaccessible IDs without expanding scope.
- [ ] Enable restore/force-delete only for supported soft-deleted records. Application handlers own domain side effects and transactions.
- [ ] Add confirmation UX for destructive actions, duplicate-submit protection, success/failure feedback, and selection cleanup.
- [ ] Default built-in and custom bulk database mutations to atomic execution: validate and authorize the whole selection before changes, then execute mutations within one database transaction. Application handlers own domain operations; the action contract must make transaction ownership explicit. External effects such as email or remote API calls cannot be rolled back by that transaction and remain application-owned.

### 19.2 Custom bulk actions and outcome handling

- [ ] Extend the Phase 18 action definition and registration contract to selected rows. Allow consumers to add actions such as Approve or Reject independently of delete, restore, force delete, and CSV. Built-in actions remain independently opt-in.
- [ ] Require a non-empty selection for a bulk action; never reinterpret an empty selection as all rows. Preserve the existing current-page select-all and cross-page selection rules. Resolve selected IDs through the authorized/scoped query again at execution time, including after confirmation or additional input.
- [ ] Reuse labels/icons/variants, visible/disabled conditions, allowlisted dispatch, server authorization, Alert confirmation, Dialog input, validation, loading, and duplicate-submit protection. Consumers supply handlers and input views; the package does not assume application model methods.
- [ ] Permit partial success only when explicitly configured by the custom handler contract. Report a result for each selected record (success, failure, or skipped) and an aggregate summary. Do not silently switch an atomic action to partial mode or treat unauthorized records as authorized; return safe reasons without disclosing inaccessible record data.
- [ ] Define selection cleanup by outcome: clear successfully processed IDs, retain eligible failed/skipped IDs for review or retry, and remove stale/inaccessible IDs. Atomic failure preserves still-eligible selection; cancellation leaves selection unchanged. Refresh table data and selection counts after completion without losing filters/order.
- [ ] Document application-owned handling of external effects, retries, and idempotency. Do not claim an all-or-nothing guarantee for external services or multiple database connections.
- [ ] Test custom action coexistence with optional built-ins, empty selection, cross-page selected IDs, tampering, scoped authorization, authorization changes after confirmation, atomic rollback, explicit partial results, input validation, repeated submission, and selection cleanup.
- [ ] Browser-test custom bulk Approve, Reject with a required reason, confirmation cancellation, atomic failure feedback, explicit partial success, and retry of remaining eligible rows. Include no-JavaScript-error assertions and multiple Table instances.
- [ ] Extend Table docs with separate copyable custom bulk examples and document transaction/partial-result contracts alongside built-in actions.

### 19.3 CSV export

- [ ] Export selected authorized rows through configured exportable columns. Do not silently export all results when selection is empty.
- [ ] Stream/chunk output where appropriate, escape CSV correctly, mitigate spreadsheet formula injection, and document encoding and selection limits.
- [ ] Keep queued exports and exports of all matching results outside version one.
- [ ] Test cross-page selection, filter reset, unauthorized rows, stale selections, soft-delete/restore/force-delete behavior, transaction failure, CSV escaping, and formula-like cells.
- [ ] Browser-test selection, confirmation, completion/failure feedback, and CSV download.
- [ ] Extend table docs and complete the mandatory phase gate.

## Phase 20 — Livewire calendar

- [ ] Implement the agreed month view using native Livewire unless Phase 0 demonstrates a clear benefit from a free library.
- [ ] Default to the current month in the configured application timezone; provide previous/next month, month/year selectors, and return-to-today.
- [ ] Support localized labels, configurable week start, selected/today styles, optional date bounds, and disabled dates.
- [ ] Render a consistent grid across month boundaries with a documented treatment of adjacent-month days.
- [ ] Expose a typed day action/event with a canonical date; consumer application code handles authorization and domain behavior.
- [ ] Add accessible keyboard navigation and labels without making every day an unrelated tab stop.
- [ ] Test leap years, year transitions, timezone-sensitive today, bounds, invalid navigation state, and day-action payloads using deterministic time.
- [ ] Browser-test navigation, selecting month/year, keyboard operation, day actions, and Livewire updates.
- [ ] Add calendar docs and complete the mandatory phase gate.

## Phase 21 — Livewire chart

- [ ] Evaluate Chart.js or an equivalent against current official documentation during implementation. Verify the required features are free, record exact versions/licenses/notices, and prove Livewire integration before committing to a library; this plan does not claim a verified dependency selection.
- [ ] Bundle the selected library and any approved plugins internally. Do not require a runtime CDN or paid service; read application settings through config and follow the existing key-handling rule if applicable.
- [ ] Provide common props for chart type, data/datasets, and sizing, plus an `options` bag covering all serializable options supported by the selected library/version. Preserve precedence: defaults, options bag, explicit props.
- [ ] Provide a documented local JavaScript extension point for callbacks, formatter functions, and plugins. Do not evaluate JavaScript strings received from Livewire; keep internal synchronization/cleanup hooks protected and compose consumer callbacks where compatible.
- [ ] Document the full supported configuration surface, plugin registration, and any lifecycle-owned exceptions explicitly. Support data/config updates, chart-type replacement when necessary, resizing, empty/loading states, multiple instances, and teardown on removal/navigation.
- [ ] Keep data queries and authorization application-owned. Provide accessible chart naming and a text/table alternative for the example data; respect reduced-motion preferences.
- [ ] Test option forwarding/precedence and server payloads; browser-test real rendering, callbacks/plugins, data/type updates, hidden-to-visible resizing in Tabs/Dialog, repeated mount/unmount, and no duplicate instances or JavaScript errors.
- [ ] Add Chart docs with working data examples, copyable configuration and local callback examples, an options reference, lifecycle guidance, and complete the mandatory phase gate.

## Phase 22 — AI agent skill for package consumers

Prerequisite: complete all component phases through Phase 21 and their documentation. This skill teaches agents how to use the installed Sirius UI release in a consuming application; it must describe implemented APIs rather than planned features.

### 22.1 Portable skill and supported agents

- [ ] Create a portable `SKILL.md` entry point with a clear activation description and focused reference files. Keep the entry point concise and load component details only when relevant.
- [ ] Target Codex and Claude Code initially. Verify their current project-local skill discovery and installation requirements during this phase; document tested agent versions and any differences. Claim support for other agents only after testing them.
- [ ] Require Laravel Boost integration through its supported third-party package skill discovery. Ship the canonical entry point at `resources/boost/skills/sirius-ui-development/SKILL.md`, with valid `name` and `description` frontmatter and adjacent references. Include these files in the Composer distribution and verify the convention against the supported Boost version during implementation.
- [ ] Ensure consumers can select and install the skill through `php artisan boost:install` and refresh it through `php artisan boost:update`. Verify the installed skill can be discovered, activated, and used by the selected agent; Boost installs/distributes the skill, while the agent executes its instructions. Keep standalone usage available without requiring Boost as a production dependency.

### 22.2 Structure, component usage, and application boundaries

- [ ] Explain package structure, configurable namespaces, configuration, assets, published resources, supported framework versions, and the distinction between package internals and consumer extension points.
- [ ] Provide a component-selection guide and references for every shipped Blade and Livewire component, including props, slots, attributes, events, options, defaults, and supported customization points.
- [ ] Include working ordinary Blade and Livewire examples covering bindings, validation/error bags, helper text, accessibility, stable IDs, reset, and widget lifecycle behavior. Explain the ordinary Blade `form` component's GET default, explicit action, CSRF/method spoofing, multipart contract, and separation from Livewire submission handling.
- [ ] Explain application-owned responsibilities for table queries, authorization, custom row/bulk/toolbar action registration, confirmation/input views, transaction and partial-result handling, CSV export, calendar day actions, editor sanitization, and uploads. Preserve CRUD controller design and the invocable-controller rule for single actions.
- [ ] Cover local asset installation/builds, Tailwind tokens and themes, Blade Icons, troubleshooting, and relevant test commands. Use only the selected free dependency features.
- [ ] Instruct agents to inspect the installed package version and configuration, prefer existing components, and avoid inventing APIs or editing `vendor`. Use documented publishing and extension mechanisms; never access `.env` directly or expose secrets.
- [ ] Bundle version-matched references and examples with each package release so essential usage guidance works without access to the docs repository or a hosted website. Document how to refresh an installed skill after a package upgrade.

### 22.3 Explicit installation and updates

- [ ] Use the same canonical skill source for Boost and standalone installation. Provide an Artisan command to install or update project-local skill files for explicitly selected supported agents without Boost, plus documented manual installation instructions. Avoid duplicate skill names or conflicting ownership when Boost already manages the destination; direct users to the appropriate update mechanism.
- [ ] Show destination paths and planned changes before applying them. Do not automatically write agent configuration or skill files during Composer installation or service-provider boot.
- [ ] Make repeated installation idempotent. Track package-managed files, detect user modifications, and require explicit confirmation before replacing customized files. Non-interactive execution must preserve conflicts and report how to resolve them.
- [ ] Restrict generated paths to the selected project-local skill destinations. Preserve unrelated skills and agent configuration, and provide a documented recovery/update procedure.
- [ ] Extend applicable architecture checks for the console command and installer boundaries without coupling the package to a specific agent runtime.

### 22.4 Verification and documentation

- [ ] Test clean installation, repeated installation, upgrades, modified-file conflicts, non-interactive behavior, unsupported targets, destination containment, and inclusion of every referenced file in the distribution.
- [ ] In an isolated consumer project with Sirius UI and a supported Laravel Boost version, verify package discovery, selection through `boost:install`, refresh through `boost:update`, and preservation/resolution of customizations according to the documented ownership rules. Check that every reference survives installation and upgrades; record tested Boost versions and commands.
- [ ] Verify documented examples against the actual component APIs and execute representative examples in the docs app. Check reference links and stale API names as part of maintenance.
- [ ] Evaluate skill discovery and representative consumer tasks in clean Codex and Claude Code projects: build a validated form, customize a theme, configure a scoped table, and handle a calendar action. Record outcomes and limitations; text-file validation alone is not evidence of agent compatibility.
- [ ] Run representative agent tasks using the Boost-installed skill as well as the standalone path. Confirm activation loads Sirius UI instructions and produces working component usage; file presence alone does not satisfy Boost compatibility.
- [ ] Add an AI Agent Skill docs page and navigation entry covering supported agents, installation, activation, updates, customization conflicts, troubleshooting, and version compatibility. Update the docs README while preserving the package README's minimal docs pointer.
- [ ] Document the required Boost integration with copyable installation/update commands, agent activation examples, skill-selection guidance, and troubleshooting for an undiscovered or stale skill. Reference the [official third-party package skills documentation](https://github.com/laravel/docs/blob/13.x/boost.md#third-party-package-skills).
- [ ] Complete the mandatory phase gate: run `composer test` in every changed project, then `composer test:browser` in docs after all project checks pass, and wait for completion.

Acceptance: a consumer can install and refresh the bundled skill through Laravel Boost, and a tested agent can discover and activate that installed skill, understand the package structure, and produce working usage examples without relying on unpublished APIs or modifying vendor code. The standalone installation path must also work. Phase 22 is incomplete until both paths pass their integration checks.

## Phase 23 — Replace Flux throughout docs with Sirius UI

Prerequisite: all component phases and the AI agent skill are complete. This is the final implementation phase before release validation.

- [ ] Inventory every Flux component, directive, helper, stylesheet, JavaScript integration, icon, and dependency across docs layouts, navigation, component pages, demos, and development fixtures; map each use to a Sirius UI component or supported native behavior.
- [ ] Resolve missing reusable package functionality before replacing its callers, including Icon, Menu/Dropdown, Breadcrumb, dialogs, buttons, and responsive navigation needs. Add docs/tests and refresh AI skill references for any package API introduced here.
- [ ] Replace all Flux usage with Sirius UI functionality while preserving routes, content, themes, responsive/mobile navigation, accessibility, form behavior, and the existing documentation layout contract.
- [ ] Update affected tests to assert user-visible behavior using the new package components, retaining meaningful regression coverage. Do not merely delete failing Flux-specific tests.
- [ ] Once no Flux functionality is required, remove its docs dependencies, asset imports, configuration, and obsolete instructions. Keep necessary Livewire/Alpine behavior intact and ensure package components are consumed through the local Composer installation.
- [ ] Audit remaining Flux references, distinguishing historical records from active code/dependencies. Verify clean installation/builds and no missing assets, duplicate initialization, or JavaScript errors.
- [ ] Browser-test desktop/mobile navigation, theme switching, content navigation, copy controls, dialogs/menus, and representative native/Livewire form demos. Update the docs README and complete the mandatory phase gate.

## Phase 24 — Cross-component validation and release readiness

- [ ] Exercise representative forms combining label, helper, error, checkbox, radio, switch, currency, date, upload, editor, select, and both Slider modes inside a Dialog or Slideover.
- [ ] Verify repeated components, multiple instances, validation failures, form reset, conditional rendering, and Livewire navigation without state loss or leaked listeners.
- [ ] Review keyboard access, focus, light/dark contrast, mobile layouts, and reduced-motion behavior across docs examples, including nested menus, Tabs, Timeline, Skeleton, Tooltip/Popover, and Chart. Confirm Dialog/Slideover preserve scrollbar space.
- [ ] Verify custom row, toolbar, and bulk Table actions alongside built-ins, including confirmation/input, authorization changes, atomic rollback, explicit partial outcomes, and selection cleanup.
- [ ] Confirm the completed Flux migration covers the entire docs application and any migration-driven additions are included in the AI skill references.
- [ ] Verify the ordinary Blade `form` component and a separate Livewire form submit the documented canonical values, including disabled/readonly behavior. Cover the Blade form's GET default, non-GET CSRF, spoofed methods, and multipart file submissions.
- [ ] Verify internal assets load with no runtime CDN requests and no duplicate Alpine/widget initialization.
- [ ] Verify package distribution includes compiled assets and license notices; validate a clean docs installation against the local dependency instructions.
- [ ] Verify the release also includes the version-matched AI agent skill and all references, and repeat a clean consumer installation using the documented skill setup.
- [ ] Finish compatibility checks for the supported Laravel/PHP combinations and record limitations. Do not claim browser/OS support without evidence.
- [ ] Audit docs navigation, prop tables, events, slots, options, examples, config instructions, and the minimal package README pointer.
- [ ] Record a release checklist/changelog and any deferred work. Publishing or deploying is outside this plan unless separately requested.
- [ ] Complete the mandatory phase gate and confirm every promised version-one component is represented in docs.

## Progress record

For each phase, append its outcome here when it is actually executed:

| Phase | Status | Changed projects | `composer test` results | Docs browser result | Evidence or blockers |
| --- | --- | --- | --- | --- | --- |
| 0 | Complete | Package and docs | Both passed: package 5 tests / 31 assertions; docs 6 tests / 21 assertions; lint, types, refactoring passed | Passed: 4 tests / 31 assertions | Both asset builds passed; isolated Laravel 12 suite passed (5 tests / 31 assertions); architecture negative control confirmed; npm/Composer audits passed. See PHASE_0.md. |
| 1 | Complete | Package and docs | Both passed: package 17 tests / 95 assertions; docs 10 tests / 48 assertions; lint, types, refactoring passed | Passed: 8 tests / 59 assertions | Both asset builds passed; label and shared field docs completed. See PHASE_1.md. |
| 2 | Complete | Package and docs | Both passed: package 32 tests / 179 assertions; docs 24 tests / 106 assertions; lint, types, refactoring passed | Passed: 15 tests / 168 assertions | Both asset builds passed; native and Livewire interaction, keyboard/readonly, reset, and mobile themes verified. See PHASE_2.md. |
| 3 | Complete | Package and docs | Both passed: package 56 tests / 277 assertions; docs 59 tests / 262 assertions; lint, types, refactoring passed | Passed: 34 tests / 367 assertions | Both asset builds passed; Laravel 12 currency suite passed (15 tests / 43 assertions). Native/Livewire/Alpine values, editing, reset, and mobile themes verified. See PHASE_3.md. |
| 4–24 | Not started | None | Not run for implementation | Not run for implementation | Awaiting further implementation instruction |

Planning-document verification on 2026-09-12: only this Markdown file was added. In docs, `composer test` passed (Pint, PHPStan, Rector, and 1 existing test with 4 assertions), followed by `composer test:browser` passing (1 existing test with 2 assertions). These baseline checks do not validate unimplemented components or complete any phase. The package was unchanged, so its suite was not run for this documentation-only change.

Any additional implementation detail that changes the agreed public behavior must be surfaced before coding that behavior. Routine implementation choices and dependency verification within this plan do not require repeating already-granted approval.
