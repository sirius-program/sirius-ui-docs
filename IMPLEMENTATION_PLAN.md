# Sirius UI Implementation Plan


Package: `D:/Projects/sirius-ui`  
Documentation and integration application: `D:/Projects/sirius-ui-docs`

Phase 0 through Phase 19 checkboxes reflect executed work. The reusable phase gate remains an unchecked template. The expanded roadmap runs through Phase 26; Toast follows Phase 18 before the Livewire Table phases; phases 0–7 retain their completed status, Phone follows Datetime Picker; Phone and Slider precede Form, the AI skill follows all component phases, and Flux migration immediately precedes final validation. See PHASE_0.md, PHASE_1.md, PHASE_2.md, PHASE_3.md, PHASE_4.md, PHASE_5.md, PHASE_6.md, PHASE_7.md, PHASE_8.md, PHASE_9.md, PHASE_10.md, PHASE_11.md, PHASE_12.md, PHASE_13.md, PHASE_14.md, PHASE_15.md, PHASE_16.md, PHASE_17.md, PHASE_18.md, and PHASE_19.md for architecture boundaries, decisions, verification scope, and maintenance notes.

## 1. Agreed outcome and architecture

Deliver reusable Tailwind-styled Blade components and class-based Livewire components, with interactive documentation, meaningful automated tests, and no dependency on the consuming application's business models.

- Preserve Laravel 12/13 and Livewire 4 support. Verify valid PHP/framework/Testbench combinations instead of assuming every advertised PHP version supports both Laravel majors.
- Preserve the existing configurable Blade and Livewire namespaces, defaulting to `sirius`.
- Keep anonymous Blade components in `resources/views/components`, Livewire classes in `src/Livewire`, their views in `resources/views/livewire`, and JavaScript source in `resources/js`.
- Permit narrowly scoped class-backed Blade adapters in `src/View/Components` when scoped methods are necessary. Phase 1's `Field` computes one control attribute bag for both the caller's slot and the surrounding layout; `label` remains anonymous. Architecture tests require these adapters to extend Laravel's component base and prohibit database dependencies.
- Extract focused PHP helpers and JS adapters only when they remove real duplication or establish a necessary integration boundary. Avoid a generic repository/service layer for presentation components.
- Make Blade controls work on ordinary Blade pages and inside Livewire. The `form` component is specifically for ordinary browser submissions to application controllers, without Livewire submission handling. Livewire remains a package dependency; ordinary Blade usage must not require wrapping every input in a Livewire component.
- Preserve existing `sir-` styling and `--sir-` token conventions; support responsive layouts, light/dark themes, keyboard navigation, and visible focus.
- Use Blade Icons with a selected free icon set. Map `primary` to Tailwind sky, `info` to neutral, `secondary` to indigo, `success` to emerald, `danger` to red, and `warning` to amber through customizable tokens.
- The table uses a consumer-defined subclass for queries, columns, filters, and optional row/bulk action views. The package handles rendering, search, filtering, ordering, pagination, selection, and loading presentation. Action views receive `$record` for a row or `$selectedIds` for bulk buttons/links; the application creates its own Dialog/Alert/Slideover and owns action execution, authorization, validation, feedback, transactions, and exports. Table provides no action handler registry, built-in operations, automatic action overlays, or arbitrary toolbar actions.
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
- Use the same component documentation pattern: Demo, Usage, Props and attributes, followed by Shared field contract and Assets and interaction when applicable. For form controls, stack Livewire and Blade demos with matching controls and values; non-form controls use Blade demos only and demonstrate every supported variant; share Submit / Validate, Load Value, and Reset Sample buttons, with Toggle Readonly only in Livewire. Render props in minimal responsive tables (name, type, mandatory, default, description), followed by accurate HTML5/Alpine/data/ARIA/Livewire support notes. Highlight usage syntax and provide copy controls using the shared docs presentation components.
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
| `datetime-picker` | `type=date\|time\|datetime`; display format, limits, locale, timezone configuration |
| `phone` | Country/region selection through `country` (string, array, or `*`), country-code prefix, configurable display delimiter, canonical E.164 value |
| `file-upload` | Single/multiple upload, progress, cancellation, type and size limits |
| `textarea` | Native multiline text input |
| `richtext` | Formatted HTML with Tiptap UI and optional image upload |
| `select` | Single/multiple selection, local search, optional paginated server search |
| `slider` | Single numeric value by default; `range=true` uses two values and exactly two numeric entries in each of `min`, `max`, and `step` |
| `form` | Ordinary Blade submission; explicit `action`; `method=GET` by default; automatic CSRF for non-GET methods and method spoofing for PUT/PATCH/DELETE; `sending-file=false` by default |
| `card`, `dialog` | String shorthands, header/footer named slots, body default slot; stable section IDs |
| `message`, `badge`, `button` | `variant=primary\|info\|success\|danger\|warning\|secondary\|ghost\|outline`; Button also supports `link` and optional `icon`; Message preserves the former inline Alert behavior and `dismissible` |
| `icon`, `button-group` | Blade Icons wrapper; visual button grouping without selection state |
| `alert` | Dialog-based prompt with optional icon and title, escaped text, a free-form footer slot, eight standard presentation variants, and fade–bounce entry/exit |
| `toast` | Pre-rendered non-modal notification; Alert-like icon/title/text/footer; ID-based events and open binding; eight variants; six positions (default `top-end`); configurable duration, pause/resume, bounded stack/queue |
| `avatar` | Image with string fallback for initials; `size`, `variant=rounded\|circle`, `fallback`, `alt` |
| `breadcrumb` | Item slots, configurable `separator`, and current-page semantics |
| `menu`, `dropdown` | Shared nested item contract: optional `icon`, `name`, optional `link`, optional `trailing` string/slot, `disabled`, `active` |
| `tooltip`, `popover` | `variant=info\|primary\|secondary\|warning\|success\|danger` (default: `info`); text tooltip versus HTML-slot popover |
| `separator`, `skeleton` | Horizontal/vertical styled separator; fading loading placeholder with reduced-motion support |
| `slideover` | Dialog interaction contract with `side=top\|right\|bottom\|left`; preserve scrollbar space |
| `tabs` | Local panels, keyboard navigation, and active-tab binding |
| `timeline` | Vertical sequence with numbered/icon markers, title, description, content slot, and completed/current/upcoming states |
| Livewire `chart` | Library-backed chart with serializable options and a local JavaScript callback/plugin extension point |
| `accordion` | Expandable content and accessible trigger; documented initial/open state |
| Livewire `table` | Consumer subclass with query, columns, filters, row action views receiving `$record`, and bulk action views receiving `$selectedIds`; application-owned actions and overlays; `loading` state and translated `record-label` |
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
| Richtext | A free self-hostable richtext; evaluate TinyMCE or an alternative | Redistribution license, no unexpected paid requirement, sanitized HTML contract, bundled assets |
| Select | Select2 or a lighter alternative | Multiple values, remote pagination, accessibility, JS lifecycle |
| Table/calendar | Native Livewire baseline; evaluate libraries only if needed | Clear reduction in complexity without conflicting ownership or paid features |

- [x] Check current official documentation and licenses; record chosen versions and sources in docs.
- [x] Create narrowly scoped integration proofs for risky widget synchronization before implementing their full component phases.
- [x] Choose the smallest suitable dependency set. jQuery is allowed if justified and bundled internally.
- [x] Establish JS loading and teardown for both ordinary Blade and Livewire contexts, including deferred initialization and multiple instances.
- [x] Define HTML sanitization ownership: richtext output is untrusted; application validation and server sanitization are required before rendering. The docs example must demonstrate a concrete, tested sanitization path.

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

- [x] Implement `datetime-picker` using the verified library and `type=date|time|datetime`.
- [x] Render a calendar icon prefix for date/datetime and a clock icon prefix for time. Place Clear in the suffix and reuse the shared input adornment styles, including password-style action borders, hover/focus, and disabled behavior.
- [x] Use canonical values `Y-m-d`, `H:i`, and `Y-m-d H:i:s` respectively; configure display format separately.
- [x] Resolve global `sirius-ui.locale` and `sirius-ui.timezone`, defaulting to null with render-time fallback chains `sirius-ui.locale` → `app.locale` → `app.fallback_locale` → `en` and `sirius-ui.timezone` → `app.timezone` → `UTC`; permit per-component overrides. Do not silently convert submitted wall-clock values to UTC; application code owns persistence conversion and ambiguous/nonexistent DST-time validation.
- [x] Expose compatible min/max dates or times, locale, week start, minute increment, disabled dates, clearability, and supported additional options.
- [x] Test leap days, month/year boundaries, bounds, invalid typed input, clear/reset, disabled/readonly, and native Blade submission.
- [x] Browser-test selection and server updates through re-renders, conditional mounting, navigation, and multiple widget instances.
- [x] Add type-specific examples under datetime-picker docs and complete the mandatory phase gate.

## Phase 5 — Phone input

### 5.1 Component, dependency, and country configuration

- [x] Implement `<x-sirius::phone>` using the shared form contract and a native `type="tel"` display input. Reuse Tailwind input/prefix styling, Blade Icons when needed, helper/errors, required, readonly/disabled behavior, HTML5/Alpine/data/ARIA attributes, and supported Livewire bindings.
- [x] Use `libphonenumber-js` for country metadata, parsing, formatting, and validation. Verify and pin a compatible release and metadata variant before implementation; bundle all required assets internally, preserve its MIT license, and require no hosted service, API key, or runtime CDN. Reference: https://github.com/catamphetamine/libphonenumber-js and its LICENSE file.
- [x] Accept `country` as one supported country/region code (`ID`, `US`, `GB`), a regional locale (`en-GB`, `id-ID`), a non-empty array of these values, or the standalone string `*` for all supported countries. Normalize case and locale separators, deduplicate countries while preserving array order, and reject invalid values, empty arrays, or wildcard mixed into an array.
- [x] Distinguish numbering countries from UI languages: a country controls the calling code and numbering rules, not the language of all labels. Resolve regional locales to their country; resolve language-only values through an explicit, documented mapping, including `id → ID` and `en → US`. Reject unmapped or unsupported values rather than guessing a country.
- [x] Add global `sirius-ui.phone_country` with an optional `env('SIRIUS_UI_PHONE_COUNTRY')` override and null default in the publishable config. Document the fallback chain: explicit component `country` → `sirius-ui.phone_country` → `sirius-ui.locale` → `app.locale` → `app.fallback_locale` → `US`. Resolve fallbacks at render time. PHP configuration may hold a string, array, or `*`; document environment overrides as strings, without inventing implicit comma-separated array parsing. Never access `.env` directly.
- [x] Resolve the initial country from the single country or the first country of an array. With `*`, use the global phone country/default chain; if a global value is also `*`, continue to the next fallback for the initial country, and use the first country when a global array is selected. Do not use IP geolocation or require a network request.

### 5.2 Prefix, display formatting, and canonical values

- [x] Show the selected calling code (for example `+62`) in the shared styled prefix. Use a fixed prefix for one resolved country; use an accessible country select for multiple countries or `*`. Format option labels as `+62 - Indonesia`; sort wildcard options numerically by calling code, then country name for ties. Keep explicit array order. Multi-country prefixes use a fixed five-character text area with ellipsis while the dropdown retains full labels.
- [x] Expose `delimiter`, defaulting to a space. Support space, hyphen, period, and the empty string. Derive digit grouping from each country's metadata; the delimiter replaces group separators rather than imposing fixed groups of three. Keep the calling code in the prefix rather than duplicating it in the editable national-number display.
- [x] Build a presentation adapter for custom delimiters; the library's conventional formatter does not supply an arbitrary delimiter option. Preserve caret position, selection, paste, deletion, and incomplete drafts. Normalize national trunk prefixes through the library rather than manually stripping leading zeroes.
- [x] Submit and bind only a valid international E.164 string such as `+6281234567890`, with the leading plus and country calling code and no display delimiters. Never submit a formatted national number as the canonical value. Keep display/draft state separate from canonical state.
- [x] Use a null canonical value for empty or incomplete/invalid input while preserving the typed draft visibly. Ordinary HTML submits an empty string for a null control value; document Laravel's empty-string-to-null normalization. Trigger user-facing validation on blur/submit instead of every keystroke; retain the draft through validation errors and Livewire re-renders. Define native failed-validation draft restoration without binding invalid text to the canonical field.
- [x] Treat the prefix alone as an empty number. Exclude phone extensions in the initial release and show clear validation feedback rather than silently dropping an extension. Application-side validation remains authoritative; syntactic numbering-plan validity does not prove ownership or that a number is reachable.
- [x] When a complete international value is pasted or supplied by the server, detect its country only when unambiguous and permitted by the configured list. Do not silently switch to a disallowed country or guess between countries sharing a calling code; keep ambiguous/unsupported input visible and request an allowed country selection or show an error.
- [x] On manual country changes, retain the national digits and then reformat/revalidate using the newly selected country's rules. Update the canonical value accordingly or set it to null if invalid; explain that changing country changes the interpretation of the number.

### 5.3 Blade, Alpine, and Livewire integration

- [x] Define initial canonical values, programmatic updates, ordinary submission, native reset, and Livewire/Alpine two-way synchronization. Submit exactly one canonical field under the consumer's name; do not send an additional country or draft field as that same value.
- [x] Preserve draft text, caret, selected country, errors, and focus during in-flight Livewire updates. Explicit server loads/resets must still replace the appropriate state. Cover multiple controls, conditional removal/remount, and navigation without duplicate initialization or listeners.
- [x] Disable both number entry and country changes for disabled/readonly controls. Disabled controls are omitted from native submission; readonly controls retain canonical submission. Forward native attributes to their appropriate control and document which restrictions apply to the display rather than canonical value.

### 5.4 Verification and documentation

- [x] Test country resolution and precedence, string/array/wildcard configuration, initial country, deduplication, language mappings, regional locales, shared calling codes, invalid configuration, and globally configured fallback values.
- [x] Test national/international input, trunk prefixes, all supported delimiters, incomplete/invalid/empty values, extensions, country changes, allowed/disallowed international paste, and exact E.164 payloads. Include server-supplied values and required/optional validation without treating a calling code alone as a number.
- [x] Browser-test ordinary Blade, Alpine, and Livewire flows: typing/paste/deletion and caret behavior, prefix selection, keyboard accessibility, mobile input, light/dark themes, readonly/disabled, validation draft preservation, load/reset, re-renders, remount/navigation, and multiple instances. Confirm delayed updates do not erase typing.
- [x] Add a Phone docs menu/page with matching real-world Blade and Livewire demos for single-country, limited-country, and all-country modes. Include separate copyable Blade usage per demo, a minimal props/attributes table, shared field contract, assets/interaction notes, country mapping and fallback documentation, canonical examples, and server-validation guidance.
- [x] Update the docs README/component index and applicable architecture tests; keep the package README as a docs pointer. Complete the mandatory phase gate: `composer test` in every changed project, then `composer test:browser` in docs after all project checks pass.

## Phase 6 — Searchable select

### 6.1 Local options

- [x] Implement single/multiple values, placeholder, clearability, disabled options, groups where supported, and local searching.
- [x] Define stable option value/label serialization, retaining values such as `0` and distinguishing empty single selection from an empty multiple array.

### 6.2 Server search

- [x] Add an opt-in consumer-provided search provider with debounce, pagination, loading/empty/error states, and resolution of labels for preselected values.
- [x] Ignore stale responses; preserve selected options when later search results omit them.
- [x] Keep data access and authorization in the consuming application. Do not accept arbitrary client-provided model or query definitions.
- [x] Provide an ordinary-Blade remote integration contract when server search is used outside Livewire; document the host application's endpoint responsibility.
- [x] Test single/multiple submit/reset, keyboard selection, updates to options and values, paginated results, authorization boundaries, race conditions, and repeated mounting.
- [x] Add select docs and complete the mandatory phase gate.

- [x] Keep enhanced native selects hidden through Livewire morphs and render optgroups explicitly.
- [x] Place translated search status opposite the label through reusable Label status/status-id props; use Clear and Retry suffix icons.
- [x] Group component UI translations under component keys in sirius-ui.php; keep validation translations in validation.php and record the convention in project rules.

## Phase 7 — File upload

- [x] Implement the verified upload widget with single/multiple mode, accept/type restrictions, size/count limits, progress, cancel, retry, and remove controls.
- [x] Connect Livewire temporary uploads and propagate loading, validation, completion, failure, and cancellation states.
- [x] Keep permanent storage, disk/path selection, authorization, and server validation in the application. Removing an existing file must never delete permanent data without an explicit application handler.
- [x] Support ordinary Blade multipart forms with a verified native file-input submission path. Do not silently require a Livewire upload endpoint on ordinary pages.
- [x] Expose applicable free widget options and document temporary file cleanup responsibility, existing-file representation, and browser limitations.
- [x] Test rejection of invalid/oversized files, upload failure, cancel/retry, multiple upload, reset, and server validation. Use isolated fake storage where appropriate.
- [x] Browser-test real file selection, progress/result state, remove, re-render, and duplicate-request prevention.
- [x] Add upload docs with permanent-storage examples and complete the mandatory phase gate.

- [x] Add image/PDF previews, metadata-only value records, safe existing-file removal events, and sample image/PDF demos; verify native source remains hidden after Livewire updates.

## Phase 8 — Richtext

- [x] Implement standalone `richtext`; keep native `textarea` separate.
- [x] Expose toolbar, height, placeholder, readonly/disabled, and compatible free richtext options. Use application translation strings without a locale prop.
- [x] Synchronize HTML for ordinary form submission and Livewire, including initial content, empty content, validation errors, and resets.
- [x] Support optional image upload through a consumer-owned same-origin endpoint, multipart image, CSRF, and JSON url response. Default to JPEG/PNG/WebP up to 2 MiB; applications own authorization and cleanup.
- [x] Demonstrate server-side sanitization and safe output rendering in docs; test malicious markup and unsafe URLs through that integration.
- [x] Browser-test editing, formatting, form submission, programmatic updates, teardown/remount, and multiple richtexts without duplicate initialization.
- [x] Provide separate Textarea and Richtext docs with per-field usage, shared sections, translations, and complete the mandatory phase gate.

## Phase 9 — Slider

### 9.1 Single-value and range contracts

- [x] Implement `slider` using the shared field contract, with a single numeric `value` by default and numeric `min`, `max`, and positive `step`.
- [x] Enable two handles with `range=true`; require exactly two numeric values and exactly two numeric entries in each of `min`, `max`, and `step`. Index 0 configures the first handle; index 1 configures the second. Reject scalar limits/steps in range mode rather than silently expanding them.
- [x] Use one visual scale spanning both configured handle domains. Each handle respects its own bounds and step grid anchored at its own minimum. Require finite numbers, positive steps, valid ordered bounds, and a configuration admitting at least one ordered pair; reject invalid configuration clearly.
- [x] Keep the first value less than or equal to the second. Handles cannot cross; constrain movement to the nearest permitted step without crossing the other value. Reject invalid supplied/programmatic values with clear feedback rather than silently swapping handles.
- [x] Support keyboard, pointer, and touch interaction, accessible names for both handles, value announcements, visible focus, disabled/readonly semantics, and responsive light/dark styling.
- [x] Define ordinary Blade names/payloads for a scalar and an ordered pair, array binding in Livewire/Alpine, server updates, native reset, and single group-level label/helper/error output.

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

### 9.2 Verification and documentation

- [x] Test scalar/array shape validation, invalid bounds/steps, decimal steps, independent handle constraints, equal values, and crossing prevention. Cover canonical native submission and Livewire server/client updates.
- [x] Browser-test both modes, keyboard/touch/pointer movement, reset, readonly/disabled states, validation, and multiple instances. Verify debounce/re-renders do not erase an in-progress value.
- [x] Add matching real-world Blade/Livewire demos and separate copyable usage for single/range modes; document the per-handle array contract and complete the mandatory phase gate.

## Phase 10 — Ordinary Blade form

Prerequisite: complete all form-control phases through Phase 9, including Phone and Slider. This component simplifies ordinary Blade form markup and browser submissions; it does not manage Livewire submissions.

### 10.1 Native form contract

- [x] Implement `<x-sirius::form>` with a default slot for form contents and a required, explicit `action` URL. Keep route generation in the consuming application.
- [x] Default `method` to `GET`. Accept GET, POST, PUT, PATCH, and DELETE case-insensitively; reject unsupported methods with a clear configuration error.
- [x] Render GET and POST as native HTML form methods. Render PUT, PATCH, and DELETE as POST with exactly one hidden `_method` containing the requested method.
- [x] Automatically render exactly one CSRF field for every non-GET method; render no automatic CSRF or method-spoofing field for GET. Document that consumers should not add duplicate `@csrf` or `@method` directives inside the slot.
- [x] Accept boolean `sending-file`, defaulting to `false`, including explicit `:sending-file="false"`. When true, render `enctype="multipart/form-data"` and consume the prop rather than forwarding it as an HTML attribute.
- [x] Reject `sending-file=true` with GET or an explicitly conflicting `enctype`. Accept an explicitly matching multipart enctype. When `sending-file=false`, preserve native enctype behavior and any explicit HTML enctype.
- [x] Forward applicable HTML5 form attributes, including `id`, `name`, `target`, `autocomplete`, `novalidate`, `accept-charset`, and `rel`, plus `data-*` and `aria-*`. Merge consumer classes safely and prevent duplicated generated method/enctype attributes.
- [x] Keep submission native: no AJAX, automatic loading state, or Livewire submission integration. Document that native submit-button overrides retain their HTML meaning and must remain consistent with the configured form method and upload encoding.
- [x] Leave validation, authorization, redirects, `old()` values, error bags, and persistence to application controllers and existing field controls. Do not introduce form-owned model state, automatic error summaries, upload endpoints, or dependencies.

### 10.2 Verification and documentation

- [x] Add rendering tests for default GET, mixed-case methods, explicit action, missing action, unsupported methods, CSRF presence/absence and uniqueness, spoofed methods, slot content, escaped attributes, and attribute/class forwarding.
- [x] Test `sending-file` true/false, automatic multipart encoding, matching/conflicting explicit enctype, GET rejection, and absence of leaked component props.
- [x] Add ordinary Blade docs examples for GET search, POST submission, PUT/PATCH/DELETE method spoofing, and multipart file submission using the package controls. Use CRUD-oriented controllers; use invocable controllers for single-action resources.
- [x] Test actual request methods and payloads, application validation redirects and error bags, restored `old()` values, and uploads using isolated test storage. Include valid and missing/invalid CSRF cases with CSRF protection explicitly active; default test middleware bypass is not sufficient evidence.
- [x] Browser-test native GET/POST submission, a spoofed update/delete request, file submission, and validation feedback without Livewire submission handling. Assert no JavaScript errors and verify canonical submitted control values.
- [x] Add a Form docs menu/page, document all defaults and rejected combinations, and update the docs README/index. Keep the package README as a minimal docs pointer.
- [x] Update applicable architecture tests only if necessary, then complete the mandatory phase gate: `composer test` in every changed project, followed by `composer test:browser` in docs after all checks pass, waiting for completion.

Acceptance: consumers can compose a native form with an explicit action, receive GET behavior by default, submit other supported methods with automatic CSRF/method spoofing, and enable multipart file submission with `sending-file` without introducing Livewire or AJAX submission behavior.

## Phase 11 — Icon, button, button group, badge, and message

- [x] Implement Message, Badge, and Button variants `primary`, `info`, `success`, `danger`, `warning`, `secondary`, `ghost`, and `outline`. Use primary sky, info neutral, secondary indigo, success emerald, danger red, and warning amber; define ghost as a minimal background treatment, and outline as a bordered treatment using shared theme tokens.
- [x] Implement a reusable `icon` wrapper around the chosen Blade Icons set, with name, size, styling, and accessible/decorative semantics; use it across components and later docs migration.
- [x] Give Button an optional `icon` prop and an accessible name requirement for icon-only buttons. Add `variant="link"` as a visual style independent of `as="a"`; preserve focus and disabled semantics.
- [x] Implement `button-group` as a visual grouping of buttons with shared borders/radii and appropriate group labeling. Do not introduce selection state or toggle behavior.
- [x] Implement button `as=button|a`, validating the allowed tag list. Default real buttons to `type=button`; require explicit submit behavior.
- [x] Support icons, sizes, loading, focus, and disabled behavior. A disabled anchor must prevent mouse and keyboard activation and expose an accessible disabled state.
- [x] Implement badge content and variants, with readable contrast in light/dark themes.
- [x] Implement message content, variants, appropriate announcement semantics, and `dismissible` with an accessible dismiss control and documented dismissal state.
- [x] Test icon accessibility, button-group composition, every variant, link styling versus anchor semantics, escaped content, attributes, loading/disabled states, and Message dismissal through Livewire updates.
- [x] Add icon, button, button-group, badge, and message docs entries and complete the mandatory phase gate.

## Phase 12 — Card and accordion

- [x] Implement card string shorthands, named header/footer slots, and default body slot. Slots override corresponding string shorthands; document precedence.
- [x] Give rendered sections `{id}-header`, `{id}-body`, and `{id}-footer` IDs; generate a random five-character root ID when omitted, following the shared ID contract; require explicit IDs when stable identity across server renders is needed.
- [x] Allow section-specific styling without overwriting stable IDs. Omit empty optional header/footer sections with documented behavior.
- [x] Implement `accordion` with accessible trigger, controlled open state, expanded/controls attributes, optional transition, and reduced-motion support.
- [x] Support exclusive groups through a shared `name`, with a grouped demo and keyboard regression coverage.
- [x] Test slot precedence, section IDs, multiple instances, keyboard toggling, hidden content focus behavior, and Livewire-driven state changes.
- [x] Add card and accordion docs entries and complete the mandatory phase gate.

## Phase 13 — Dialog

- [x] Reuse the agreed card-like content contract and section ID scheme for dialog header/body/footer.
- [x] Define open/close binding and events, sizing, initial focus, focus containment, focus return, body scroll handling, and accessible dialog naming. Preserve the originally planned Modal behavior under the public name `dialog`; do not add a parallel `modal` alias.
- [x] Preserve scrollbar space while locking background scrolling, using a stable gutter and an appropriate fallback where needed. Opening/closing must not shift page or fixed-position content; restore previous styles after close/removal/navigation. Share this behavior with Slideover.
- [x] Support Escape and backdrop dismissal with explicit options to prevent each; prevent unintended form submission by close controls.
- [x] Preserve state correctly during validation and re-renders; clean up listeners and scroll locks after removal/navigation.
- [x] Cover multiple dialog instances; scope version one to one active dialog at a time and document nested/stacked dialogs as unsupported.
- [x] Browser-test keyboard behavior, prevented close, focus restoration, Livewire-triggered opening/closing, widgets mounted inside a dialog, and unchanged page/fixed-content position with and without a scrollbar.
- [x] Add dialog docs with Blade and Livewire project-form demos covering every shipped form control, and complete the mandatory phase gate.

## Phase 14 — Alert and slideover

Prerequisite: Dialog and its shared focus/scroll-lock lifecycle are complete.

- [x] Implement the new `alert` as a Dialog-based prompt inspired by SweetAlert presentation, without installing that library. Content consists only of optional `icon`, optional escaped `title`, escaped `text`, and a consumer-controlled `footer` slot. Support the eight standard presentation variants and reduced-motion-aware fade–bounce entry/exit animations.
- [x] Reuse Dialog open/close bindings, focus management, dismissal options, and scrollbar preservation. Do not add toast, timer, queue, or automatic business actions; footer actions belong to the consumer.
- [x] Implement `slideover` with `side=top|right|bottom|left`, reusable header/body/footer composition, and simple reduced-motion-aware entry/exit transitions.
- [x] Preserve scrollbar space for every side, restore focus and scroll styles on dismissal/removal/navigation, and share the one-active-overlay rule across Dialog, Alert, and Slideover. Nested/stacked overlays remain outside version one.
- [x] Test Alert content escaping and arbitrary footer actions; browser-test focus, Escape/backdrop options, every Slideover side, Livewire updates, cleanup, and lack of layout shift.
- [x] Add separate Alert and Slideover docs pages, distinguish Alert from inline Message, demonstrate every Alert variant, and show all shipped form controls in matching Blade/Livewire right-side Slideover demos. Complete the mandatory phase gate.

## Phase 15 — Avatar, separator, and skeleton

- [x] Implement Avatar with image source, `alt`, configurable `size`, `variant=rounded|circle`, and `fallback` string for initials. Show fallback when the source is absent or fails, reserve image space, and avoid repeated error handling loops.
- [x] Implement Separator as a theme-consistent horizontal rule by default with vertical orientation support and appropriate decorative/semantic behavior.
- [x] Implement Skeleton with configurable dimensions/shape and a gentle flashing/fading effect; respect reduced motion and keep placeholders out of accessible content while allowing the parent to announce loading.
- [x] Test Avatar fallback and image recovery after updates, size/shape output, separator semantics, and Skeleton accessibility; verify themes, layout, and reduced-motion behavior in docs.
- [x] Add all three component docs entries and complete the mandatory phase gate.

## Phase 16 — Breadcrumb, menu, and dropdown

### 16.1 Shared navigation items

- [x] Implement Breadcrumb with slotted items, configurable text/icon separator, navigation labeling, and current-page semantics. Decorative separators are hidden from assistive technology.
- [x] Establish a shared Menu/Dropdown item contract: optional `icon`, `name`, optional `link`, optional `trailing`, `disabled`, and `active`. `trailing` accepts a plain string or named slot for shortcuts/badges; the slot takes precedence.
- [x] Use links for navigation and non-submitting buttons for items without links that invoke Alpine/Livewire actions. Preserve consumer directives and prevent disabled mouse/keyboard activation.
- [x] Support nested submenus and consumer-supplied item content without duplicating the item API. Document navigation semantics for Menu and action-menu semantics for Dropdown, including any semantic differences.

### 16.2 Interaction and verification

- [x] Implement Dropdown trigger/open state, outside click and Escape dismissal, focus return, keyboard navigation, submenu navigation, and touch operation. Use simple entry/exit animations and reduced-motion support; nested items must not require hover.
- [x] Keep submenus within the viewport and support long/scrollable menus, active items, and multiple instances. Clean up listeners and synchronize state through Livewire updates/navigation.
- [x] Test names/links escaping, trailing string versus slot, nested structure, disabled/active states, action forwarding, and Breadcrumb separator/current item.
- [x] Browser-test keyboard and touch submenus, dismissal/focus return, shortcut/count content, and Livewire-driven changes. Add all three docs pages and complete the mandatory phase gate.

## Phase 17 — Tooltip and popover

- [x] Share positioning behavior that keeps overlays visible within the viewport; expose `variant=info|primary|secondary|warning|success|danger` (default: `info`) with theme tokens and accessible contrast.
- [x] Implement Tooltip with escaped text, hover/focus activation, Escape dismissal, and accessible trigger-description association. Do not place interactive content inside Tooltip.
- [x] Implement Popover with an HTML content slot, click activation, Escape/outside-click dismissal, and support for interactive controls. Define focus entry/return without trapping focus as a modal dialog would.
- [x] Preserve trigger attributes/events and handle overlays inside Dialog/Slideover without clipping, broken focus, or conflicting dismissal. Use one lifecycle owner and reduced-motion-aware transitions.
- [x] Test attribute/content semantics; browser-test hover/focus versus click, keyboard use, viewport edges, HTML controls, multiple instances, Livewire lifecycle, and nested overlay interaction.
- [x] Add separate Tooltip and Popover docs pages and complete the mandatory phase gate.

## Phase 18 — Tabs and timeline

- [x] Implement Tabs for local content panels with stable trigger/panel associations, active-tab binding, keyboard navigation, disabled tabs, and accessible selected/hidden states. Preserve child form values when switching panels and document rendering behavior.
- [x] Implement Timeline as a vertical sequence matching the supplied reference: connected markers, `completed`, `current`, and `upcoming` states, optional icons or numbers, title, description, and a content slot.
- [x] Keep Timeline presentational: it does not own form validation, step progression, or automatic workflow actions. Consumer markup may provide links/actions without changing this responsibility.
- [x] Test Tabs associations, state updates, and hidden panel focus; test Timeline states and escaping/slots. Browser-test keyboard tabs, Livewire state/value preservation, responsive rendering, and light/dark presentation.
- [x] Add separate Tabs and Timeline docs pages and complete the mandatory phase gate.

## Phase 19 — Toast

Prerequisite: Alert's content contract and overlay integration are complete. Toast is a separate non-modal notification component; Alert retains its existing behavior.

### 19.1 Blade API, content, and invocation

- [x] Implement `<x-sirius::toast>` using internal JavaScript and existing package styles, without a new dependency. Follow Alert's pre-rendered component model: the component must already exist in the page before an event can show it. Do not introduce a public host component or a payload-based `Sirius.toast()` API.
- [x] Match Alert's content contract: optional `icon`, optional escaped `title`, required nonempty escaped `text`, and a consumer-controlled `footer` named slot. Footer markup may contain Blade, Alpine, and Livewire actions; the application owns their behavior. Do not accept a default content slot or interpret dynamic text as HTML.
- [x] Support `variant=primary|info|secondary|success|danger|warning|ghost|outline`, defaulting to `info`, with the existing theme tokens. Preserve explicit IDs; generate the standard random five-character ID when absent. Document explicit IDs and `wire:key` for stable Livewire identity.
- [x] Follow Alert's state/event pattern with Toast-specific names: `open=false`, Alpine `x-bind:data-open`, Livewire `:open`, `data-sir-toast-open="id"`, `data-sir-toast-close`, and `toast:show`/`toast:hide` with `detail: { id }`. Support `$this->dispatch('toast:show', id: 'saved-toast')` and the corresponding hide event. Emit bubbling `toast:open`/`toast:close` events with the ID and reason; demonstrate synchronizing Livewire state after user or automatic closure.
- [x] Preserve content and footer updates during Livewire morphs. Repeated show requests for the same ID update/reuse the existing notification and restart its duration without creating duplicate notifications. Require unique IDs across rendered instances; showing an unknown ID must not create a notification from event payload text.

### 19.2 Position, timing, and stacking

- [x] Add `position=top-start|top-center|top-end|bottom-start|bottom-center|bottom-end`, defaulting to `top-end`. Resolve start/end using LTR/RTL direction and keep notifications within the viewport on desktop/mobile. Expose the default through `sirius-ui.toast_position` using `env('SIRIUS_UI_TOAST_POSITION', 'top-end')`; an explicit component position takes precedence.
- [x] Add `duration` in milliseconds, defaulting to 5000; `0` keeps the Toast visible until explicitly closed. Expose the duration default as `sirius-ui.toast_duration` in the published config, using `env('SIRIUS_UI_TOAST_DURATION', 5000)`; an explicitly supplied component duration takes precedence. Read configuration through `config()` outside config files, and reject invalid duration values.
- [x] Set `closable=true` by default, with a translated, non-submitting close button. Pause the remaining timer while hovered, while focus is inside the Toast, or while the browser document is hidden; resume only when all pause conditions end. Start timers when a queued Toast actually becomes visible, not when it enters the queue.
- [x] Show at most three Toasts at a time across positions; queue subsequent instances in FIFO order with a documented finite queue limit. Repeated requests for an already queued ID must not add duplicates. Define queue-overflow handling without removing a currently visible/focused Toast; allow explicit hide/removal to cancel a queued item and free capacity when a visible one closes.
- [x] Use fade with a short slide for entry/exit and respect reduced-motion preferences. Keep closing instances out of further interaction; release their capacity and timers exactly once after exit, with no duplicate close events.

### 19.3 Accessibility, overlays, and lifecycle

- [x] Keep Toast non-modal: do not lock background scrolling, take focus on show, trap focus, or replace the active Dialog/Alert/Slideover. Provide accessible live announcements without repeating them for unrelated re-renders; use polite status announcements by default and reserve assertive announcements for urgent danger messages.
- [x] Keep footer controls and the close button keyboard-accessible. If a manually closed Toast contains focus, return focus to the connected opening trigger where possible; never move focus elsewhere when an unfocused Toast expires. Focus inside a Toast pauses auto-close.
- [x] Ensure Toasts can appear above an open Dialog/Slideover and that their actions remain usable despite native dialog top-layer/inert behavior. Verify this with real browser integration rather than relying on a large z-index. Preserve the overlay's focus/scroll behavior and prevent Toast dismissal from accidentally dismissing its underlying overlay.
- [x] Use one lifecycle owner. Cancel timers, listeners, queued instances, and pending transitions on removal/navigation; clear the Toast stack on Livewire navigation and initialize new components once. Do not resurrect expired or dismissed notifications during unrelated morphs or leak notifications between pages.
- [x] Reuse `sirius::sirius-ui.dialog.close` for the Close label, shared with Dialog, Alert, and Slideover in package `resources/lang/{locale}/sirius-ui.php`. Consumer title/text remain application-owned.

### 19.4 Documentation and acceptance

- [x] Add a Toast page in the correct alphabetical position in the Presentation menu. Provide realistic Blade demos for every variant, positions, timed/persistent notifications, and consumer footer actions, with one exact-source copyable Usage per demo. Include Attributes, Assets and interaction, State and events, Global configuration for duration and position, and separate Translations; omit Shared field contract.
- [x] Keep Livewire regression demos in a development fixture. Cover Livewire event invocation and bound state, footer actions, updates while visible/queued, multiple positions, queue draining/overflow, duplicate IDs/requests, removal, and navigation.
- [x] Add package tests for content validation/escaping, slot/attribute forwarding, variants, generated/explicit IDs, position/duration validation, config precedence including explicit zero, and translations. Browser-test actual timers and pause/resume, automatic/manual close state synchronization, repeated show requests, bounded FIFO behavior, keyboard/live announcements, reduced motion, RTL/mobile themes, and interaction over Dialog/Slideover without focus or layout disruption. Assert no JavaScript errors.
- [x] Update docs README/index and complete the mandatory phase gate before marking Toast implemented. Extend later release validation and the consumer AI skill to include the shipped Toast contract.

## Phase 20 — Livewire table core

The rejected Phase 20 implementation does not count as completed work. Implement the revised boundaries below; Phase 21 adds selection and the external bulk-action context.

### 20.1 Consumer extension contract and rendering

- [ ] Implement the table base class and focused definitions for columns/filters, with typed extension points and consumer-owned scoped Eloquent queries.
- [ ] Support stable row keys, escaped default cells, explicit custom cell views, empty/loading states, and responsive rendering.
- [ ] Keep column identifiers server-allowlisted; never use an unchecked client string as a query column or expression.
- [ ] Render borders between columns as well as rows, including optional selection and row-action columns. Keep borders consistent in light/dark themes and preserve readable horizontal scrolling on narrow screens.

### 20.2 Search, filtering, ordering, and pagination

- [ ] Add debounced global search, registered filters, ordering, configurable page sizes, and server pagination. Put all filter controls, including any column-specific search filters, inside the filter dropdown rather than adding inline toolbar fields.
- [ ] Reset pagination when search/filter/page-size changes; specify deterministic ordering with a unique tie-breaker.
- [ ] Use server pagination and eager-loading guidance to avoid loading entire tables or hidden per-row queries.
- [ ] Isolate state for multiple table instances. Document searchable/filterable/orderable column configuration and query responsibilities.

### 20.3 External row-action context

- [ ] Allow a consumer-owned Blade view to render a collection of row action buttons/links. Pass the scoped row record as `$record` so the programmer can construct links and payloads for Dialog, Alert, or Slideover triggers.
- [ ] Keep the full record in the server-side view context. Do not automatically serialize the Eloquent model, hidden attributes, or relationships into browser state. Consumer markup explicitly selects the fields needed for an overlay/event and safely encodes them.
- [ ] Require programmers to instantiate and initialize their own Dialog/Alert/Slideover outside the Table's action rendering. Reuse existing overlay invocation APIs; Table does not generate confirmations, forms, or overlays.
- [ ] Keep application handlers, authorization, input validation, duplicate-submit protection, success/failure feedback, transactions, deletion/restoration, and exports outside the reusable Table. Do not introduce a handler registry, action dispatcher, built-in operations, or automatic result/selection cleanup.
- [ ] Let the application resolve navigation links and enforce authorization at their destinations. For mutations, application handlers re-query and authorize records at execution time; visible/disabled buttons and a rendered `$record` are not authorization guarantees.
- [ ] Provide an explicit consumer-triggered Table refresh contract after external changes. Preserve search/filter/order state and clamp pagination when records disappear; do not automatically infer action completion or its business outcome.

### 20.4 Toolbar, footer, translations, and loading

- [ ] Arrange the toolbar left to right: an ellipsis icon dropdown for bulk buttons added in Phase 21, a filter icon dropdown containing all registered filters and Reset filters, then global search filling the remaining width. Omit the bulk dropdown when no bulk actions are supplied and the filter dropdown when no filters exist; search adapts to the available space. Do not offer arbitrary toolbar action views, buttons, or action registration.
- [ ] Use the existing Dropdown, Icon, Button, and appropriate form controls. Support keyboard operation, accessible icon-button names, and filter interaction without closing the dropdown on every field change. Reset filters clears registered filters and resets pagination; global search remains a separate control.
- [ ] Put matching-record totals, the visible range, and the displayed count at the footer's left; the per-page selector in the center; and numeric pagination at the right. Use a bounded page-number window with first/last pages and ellipses as needed. Stack these areas on narrow screens while preserving their order; empty results report zero counts without an invalid range.
- [ ] Add a string `record-label` attribute. Default it from the Table translation's `record_label` text (`data` in English), and use its literal value in count information and empty states without automatic pluralization. Consumers can supply translated labels such as invoice/invoices.
- [ ] Store Table UI strings in package `resources/lang/{locale}/sirius-ui.php` under `table`, resolving through `sirius::sirius-ui.table.*`. Count and empty-state messages include the `:label` token; count messages also expose their range, displayed-count, and total tokens. Pass translations from Blade to any JavaScript, and document published overrides under `lang/vendor/sirius/{locale}/`.
- [ ] Show a loading overlay with a backdrop over the entire Table, including toolbar, rows/actions, and footer. Activate it during Table requests and when the application's explicit `loading` state is true; overlapping sources keep it active until all have finished.
- [ ] Block mouse and keyboard interaction with the covered Table, expose its busy state accessibly, and restore usable focus when loading ends. Keep external Dialog/Alert/Slideover controls usable and unrelated Table instances interactive. The application sets/clears external loading on success, failure, and cancellation; Table does not execute or monitor its handlers.

### 20.5 Documentation and acceptance

- [ ] Test combined filters, reset behavior, sort allowlisting, deterministic pagination, query scoping, empty results, custom labels/translations, row-view record context, explicit refresh, and tampered public query state. Verify the package exposes no action execution or arbitrary toolbar-action contract.
- [ ] Browser-test search, filter dropdown/reset, sorting, per-page selection, numeric pagination, row buttons opening separately created Dialog/Alert/Slideover, and a navigation link. Include whole-Table loading during local and external requests, keyboard blocking, error recovery, two isolated tables, mobile layout, light/dark borders, and no JavaScript errors.
- [ ] Add Table docs with realistic demos and copyable query/column/filter definitions and row-action views. Explain `$record`, application-owned overlays/handlers, external loading and refresh, `record-label`, and separate Translations. Document the Phase 21 bulk extension without claiming it is already implemented. Update docs navigation/index and complete the mandatory phase gate.

## Phase 21 — Table selection and external bulk-action context

### 21.1 Selection state

- [ ] Reuse the shared checkbox component for per-row selection and the indeterminate header checkbox; show a selection count across pages.
- [ ] Header selection applies only to the current page. Preserve selected IDs across pagination, page-size changes, and ordering; clear selection when global search or registered filters change, including Reset filters. Selecting all matching results is outside version one.
- [ ] Normalize and deduplicate checked IDs with stable key types. Scope interactive selection to rows supplied by the consumer query and isolate each Table's selection state. IDs sent to application actions remain untrusted input, not proof of authorization.
- [ ] Expose a documented way for the application to clear all selection or remove chosen IDs after its own action, alongside the Phase 20 refresh contract. Do not infer per-record success, failure, or skipped outcomes. Cancellation leaves selection intact unless the application explicitly changes it.

### 21.2 Consumer bulk buttons and links

- [ ] Render a consumer-owned bulk action Blade view inside the toolbar's leftmost ellipsis dropdown. Pass the current checked IDs as `$selectedIds`, including selections from other pages; never pass all query results or silently reinterpret an empty selection as all records.
- [ ] Omit the bulk dropdown when no bulk action view is supplied; otherwise disable it when selection is empty. Search fills the space freed by an omitted dropdown. Bulk buttons remain the only action collection permitted in the toolbar.
- [ ] Let consumer markup pass `$selectedIds` to its own Dialog/Alert/Slideover or construct an application navigation link. Require programmers to instantiate these overlays themselves and use existing overlay APIs. Do not add a bulk action dispatcher or built-in delete/restore/force-delete/CSV implementation.
- [ ] Keep selected-ID validation, scoped re-querying, fresh authorization, confirmation/input forms, execution, transactions, exports, retries, feedback, and selection cleanup in application code. Document this boundary with examples rather than a package transaction or partial-result protocol.
- [ ] Demonstrate application-controlled `loading` while an external bulk action runs, followed by explicit refresh and selection updates. The Table backdrop blocks further Table actions while the application-owned overlay remains usable.

### 21.3 Documentation and acceptance

- [ ] Test current-page/indeterminate selection, cross-page persistence, search/filter resets, ID normalization, per-instance isolation, exact `$selectedIds` view context, empty-selection behavior, and explicit selection updates/refresh. Keep application-specific execution tests in docs fixtures.
- [ ] Browser-test bulk buttons opening separately created Dialog, Alert, and Slideover, plus an application navigation link carrying selected IDs. Cover cancellation, application success/failure, loading recovery, explicit selection cleanup, multiple tables, and keyboard operation with no JavaScript errors.
- [ ] Extend Table docs with separate copyable bulk action views and external application handler/overlay examples. Explain that mutations and CSV exports are application-owned and validate/authorize received IDs there. Carry this contract into the later AI skill/release phases and complete the mandatory phase gate.

## Phase 22 — Livewire calendar

- [ ] Implement the agreed month view using native Livewire unless Phase 0 demonstrates a clear benefit from a free library.
- [ ] Default to the current month in the configured application timezone; provide previous/next month, month/year selectors, and return-to-today.
- [ ] Support localized labels, configurable week start, selected/today styles, optional date bounds, and disabled dates.
- [ ] Render a consistent grid across month boundaries with a documented treatment of adjacent-month days.
- [ ] Expose a typed day action/event with a canonical date; consumer application code handles authorization and domain behavior.
- [ ] Add accessible keyboard navigation and labels without making every day an unrelated tab stop.
- [ ] Test leap years, year transitions, timezone-sensitive today, bounds, invalid navigation state, and day-action payloads using deterministic time.
- [ ] Browser-test navigation, selecting month/year, keyboard operation, day actions, and Livewire updates.
- [ ] Add calendar docs and complete the mandatory phase gate.

## Phase 23 — Livewire chart

- [ ] Evaluate Chart.js or an equivalent against current official documentation during implementation. Verify the required features are free, record exact versions/licenses/notices, and prove Livewire integration before committing to a library; this plan does not claim a verified dependency selection.
- [ ] Bundle the selected library and any approved plugins internally. Do not require a runtime CDN or paid service; read application settings through config and follow the existing key-handling rule if applicable.
- [ ] Provide common props for chart type, data/datasets, and sizing, plus an `options` bag covering all serializable options supported by the selected library/version. Preserve precedence: defaults, options bag, explicit props.
- [ ] Provide a documented local JavaScript extension point for callbacks, formatter functions, and plugins. Do not evaluate JavaScript strings received from Livewire; keep internal synchronization/cleanup hooks protected and compose consumer callbacks where compatible.
- [ ] Document the full supported configuration surface, plugin registration, and any lifecycle-owned exceptions explicitly. Support data/config updates, chart-type replacement when necessary, resizing, empty/loading states, multiple instances, and teardown on removal/navigation.
- [ ] Keep data queries and authorization application-owned. Provide accessible chart naming and a text/table alternative for the example data; respect reduced-motion preferences.
- [ ] Test option forwarding/precedence and server payloads; browser-test real rendering, callbacks/plugins, data/type updates, hidden-to-visible resizing in Tabs/Dialog, repeated mount/unmount, and no duplicate instances or JavaScript errors.
- [ ] Add Chart docs with working data examples, copyable configuration and local callback examples, an options reference, lifecycle guidance, and complete the mandatory phase gate.

## Phase 24 — AI agent skill for package consumers

Prerequisite: complete all component phases through Phase 23 and their documentation. This skill teaches agents how to use the installed Sirius UI release in a consuming application; it must describe implemented APIs rather than planned features.

### 24.1 Portable skill and supported agents

- [ ] Create a portable `SKILL.md` entry point with a clear activation description and focused reference files. Keep the entry point concise and load component details only when relevant.
- [ ] Target Codex and Claude Code initially. Verify their current project-local skill discovery and installation requirements during this phase; document tested agent versions and any differences. Claim support for other agents only after testing them.
- [ ] Require Laravel Boost integration through its supported third-party package skill discovery. Ship the canonical entry point at `resources/boost/skills/sirius-ui-development/SKILL.md`, with valid `name` and `description` frontmatter and adjacent references. Include these files in the Composer distribution and verify the convention against the supported Boost version during implementation.
- [ ] Ensure consumers can select and install the skill through `php artisan boost:install` and refresh it through `php artisan boost:update`. Verify the installed skill can be discovered, activated, and used by the selected agent; Boost installs/distributes the skill, while the agent executes its instructions. Keep standalone usage available without requiring Boost as a production dependency.

### 24.2 Structure, component usage, and application boundaries

- [ ] Explain package structure, configurable namespaces, configuration, assets, published resources, supported framework versions, and the distinction between package internals and consumer extension points.
- [ ] Provide a component-selection guide and references for every shipped Blade and Livewire component, including props, slots, attributes, events, options, defaults, and supported customization points.
- [ ] Include working ordinary Blade and Livewire examples covering bindings, validation/error bags, helper text, accessibility, stable IDs, reset, and widget lifecycle behavior. Explain the ordinary Blade `form` component's GET default, explicit action, CSRF/method spoofing, multipart contract, and separation from Livewire submission handling.
- [ ] Include Toast's pre-rendered ID-based invocation, close-state synchronization, duration/queue contract, and footer actions above Dialog/Slideover in the component references and integration examples.
- [ ] Explain application-owned responsibilities for table queries, row/bulk action views using `$record`/`$selectedIds`, separately instantiated Dialog/Alert/Slideover, authorization, validation, execution, transactions, CSV export, external loading, and explicit refresh/selection updates. Document the fixed toolbar without arbitrary actions and the translated `record-label` contract. Also cover calendar day actions, richtext sanitization, and uploads. Preserve CRUD controller design and the invocable-controller rule for single actions.
- [ ] Cover local asset installation/builds, Tailwind tokens and themes, Blade Icons, troubleshooting, and relevant test commands. Use only the selected free dependency features.
- [ ] Instruct agents to inspect the installed package version and configuration, prefer existing components, and avoid inventing APIs or editing `vendor`. Use documented publishing and extension mechanisms; never access `.env` directly or expose secrets.
- [ ] Bundle version-matched references and examples with each package release so essential usage guidance works without access to the docs repository or a hosted website. Document how to refresh an installed skill after a package upgrade.

### 24.3 Explicit installation and updates

- [ ] Use the same canonical skill source for Boost and standalone installation. Provide an Artisan command to install or update project-local skill files for explicitly selected supported agents without Boost, plus documented manual installation instructions. Avoid duplicate skill names or conflicting ownership when Boost already manages the destination; direct users to the appropriate update mechanism.
- [ ] Show destination paths and planned changes before applying them. Do not automatically write agent configuration or skill files during Composer installation or service-provider boot.
- [ ] Make repeated installation idempotent. Track package-managed files, detect user modifications, and require explicit confirmation before replacing customized files. Non-interactive execution must preserve conflicts and report how to resolve them.
- [ ] Restrict generated paths to the selected project-local skill destinations. Preserve unrelated skills and agent configuration, and provide a documented recovery/update procedure.
- [ ] Extend applicable architecture checks for the console command and installer boundaries without coupling the package to a specific agent runtime.

### 24.4 Verification and documentation

- [ ] Test clean installation, repeated installation, upgrades, modified-file conflicts, non-interactive behavior, unsupported targets, destination containment, and inclusion of every referenced file in the distribution.
- [ ] In an isolated consumer project with Sirius UI and a supported Laravel Boost version, verify package discovery, selection through `boost:install`, refresh through `boost:update`, and preservation/resolution of customizations according to the documented ownership rules. Check that every reference survives installation and upgrades; record tested Boost versions and commands.
- [ ] Verify documented examples against the actual component APIs and execute representative examples in the docs app. Check reference links and stale API names as part of maintenance.
- [ ] Evaluate skill discovery and representative consumer tasks in clean Codex and Claude Code projects: build a validated form, customize a theme, configure a scoped table, and handle a calendar action. Record outcomes and limitations; text-file validation alone is not evidence of agent compatibility.
- [ ] Run representative agent tasks using the Boost-installed skill as well as the standalone path. Confirm activation loads Sirius UI instructions and produces working component usage; file presence alone does not satisfy Boost compatibility.
- [ ] Add an AI Agent Skill docs page and navigation entry covering supported agents, installation, activation, updates, customization conflicts, troubleshooting, and version compatibility. Update the docs README while preserving the package README's minimal docs pointer.
- [ ] Document the required Boost integration with copyable installation/update commands, agent activation examples, skill-selection guidance, and troubleshooting for an undiscovered or stale skill. Reference the [official third-party package skills documentation](https://github.com/laravel/docs/blob/13.x/boost.md#third-party-package-skills).
- [ ] Complete the mandatory phase gate: run `composer test` in every changed project, then `composer test:browser` in docs after all project checks pass, and wait for completion.

Acceptance: a consumer can install and refresh the bundled skill through Laravel Boost, and a tested agent can discover and activate that installed skill, understand the package structure, and produce working usage examples without relying on unpublished APIs or modifying vendor code. The standalone installation path must also work. Phase 24 is incomplete until both paths pass their integration checks.

## Phase 25 — Replace Flux throughout docs with Sirius UI

Prerequisite: all component phases and the AI agent skill are complete. This is the final implementation phase before release validation.

- [ ] Inventory every Flux component, directive, helper, stylesheet, JavaScript integration, icon, and dependency across docs layouts, navigation, component pages, demos, and development fixtures; map each use to a Sirius UI component or supported native behavior.
- [ ] Resolve missing reusable package functionality before replacing its callers, including Icon, Menu/Dropdown, Breadcrumb, dialogs, buttons, and responsive navigation needs. Add docs/tests and refresh AI skill references for any package API introduced here.
- [ ] Replace all Flux usage with Sirius UI functionality while preserving routes, content, themes, responsive/mobile navigation, accessibility, form behavior, and the existing documentation layout contract.
- [ ] Update affected tests to assert user-visible behavior using the new package components, retaining meaningful regression coverage. Do not merely delete failing Flux-specific tests.
- [ ] Once no Flux functionality is required, remove its docs dependencies, asset imports, configuration, and obsolete instructions. Keep necessary Livewire/Alpine behavior intact and ensure package components are consumed through the local Composer installation.
- [ ] Audit remaining Flux references, distinguishing historical records from active code/dependencies. Verify clean installation/builds and no missing assets, duplicate initialization, or JavaScript errors.
- [ ] Browser-test desktop/mobile navigation, theme switching, content navigation, copy controls, dialogs/menus, and representative native/Livewire form demos. Update the docs README and complete the mandatory phase gate.

## Phase 26 — Cross-component validation and release readiness

- [ ] Exercise representative forms combining label, helper, error, checkbox, radio, switch, currency, date, upload, richtext, select, and both Slider modes inside a Dialog or Slideover.
- [ ] Verify repeated components, multiple instances, validation failures, form reset, conditional rendering, and Livewire navigation without state loss or leaked listeners.
- [ ] Review keyboard access, focus, light/dark contrast, mobile layouts, and reduced-motion behavior across docs examples, including nested menus, Tabs, Timeline, Skeleton, Tooltip/Popover, Toast, and Chart. Confirm Dialog/Slideover preserve scrollbar space.
- [ ] Verify Toast timing, queue limits, close-state synchronization, lifecycle cleanup, and interaction above Dialog/Slideover without moving focus or changing the active overlay.
- [ ] Verify Table row views receive the correct `$record` and bulk views receive exactly the checked `$selectedIds`; application-created Dialog/Alert/Slideover and navigation links use these contexts correctly. Cover selection persistence/reset, explicit refresh/cleanup, whole-Table loading without blocking external overlays or other tables, fixed toolbar/filter dropdown, column borders, numeric pagination/footer, and `record-label` count/empty-state translations. Keep authorization and action execution in consumer fixtures; confirm there is no package action engine, built-in operation, or arbitrary toolbar action API.
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
| 4 | Complete | Package and docs | Both passed: package 81 tests / 340 assertions; docs 73 tests / 325 assertions; lint, types, refactoring passed | Passed: 40 tests / 439 assertions | Both asset builds passed; date/time/datetime canonical values, Blade/Livewire/Alpine updates, bounds, keyboard, reset, remounts/navigation, and mobile themes verified. Public prop is `type`; calendar/clock prefixes and Clear suffix use shared input styling. See PHASE_4.md. |
| 5–18 | Complete | Package and docs | See PHASE_5.md through PHASE_18.md for recorded results | See individual phase reports | Completed phase checklists and phase reports are the verification record |
| 19 | Complete | Package and docs | Both passed: package 506 tests / 1,640 assertions; docs 167 tests / 972 assertions; lint, types, refactoring passed | Passed: 176 tests / 2,017 assertions | Both asset builds passed; all 11 Toast browser cases passed, including timers, queue limits, Livewire footer actions above Dialog/Slideover, navigation, and mobile RTL/themes. See PHASE_19.md. |
| 20–26 | Not started | None | Not run for implementation | Not run for implementation | Implementation awaits instruction |

Planning-document verification on 2026-09-12: only this Markdown file was added. In docs, `composer test` passed (Pint, PHPStan, Rector, and 1 existing test with 4 assertions), followed by `composer test:browser` passing (1 existing test with 2 assertions). These baseline checks do not validate unimplemented components or complete any phase. The package was unchanged, so its suite was not run for this documentation-only change.

Any additional implementation detail that changes the agreed public behavior must be surfaced before coding that behavior. Routine implementation choices and dependency verification within this plan do not require repeating already-granted approval.
