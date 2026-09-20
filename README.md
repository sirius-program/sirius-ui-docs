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

Each component follows **Demo → Usage → Attributes**, with **Shared field contract** and **Assets and interaction** where applicable. Livewire and ordinary Blade demos are stacked with matching controls and sample values. Both provide **Submit / Validate**, **Load Value**, and **Reset Sample**; only Livewire provides **Toggle Readonly**. Demos use workspace scenarios such as project setup, billing details, member access, and subscription selection. Each Usage block displays the exact source of its rendered Blade demo partial, with a separate Copy control for each scenario. Syntax highlighting runs locally, with a selection fallback when clipboard access is denied. Named session keys in these snippets are supplied by the docs demo controller; adapt the value bindings and validation bag to your application. A right-hand content navigator links to sections on wide screens and moves above the content on smaller screens. Documentation pages end with a simple footer. Props tables include types, defaults, descriptions, and component-specific attribute support notes.

Open `/getting-started` through **Getting Started**; component pages are grouped under **Blade Components**. The **Label** page is available at `/blade-components/label`. Shared field behavior is explained on the relevant component pages; the former Form Conventions page has been removed. Field validation regression fixtures are available at `/development/fields` only in local/testing environments.

Use `<x-sirius::label>` for standalone labels and `<x-sirius::field>` to compose a native control with labels, helpers, validation messages, and accessible IDs. Controls and fields generate a random five-character ID when omitted or null; provide a unique explicit ID when it must remain stable across server renders. Apply the field's scoped `$component->controlAttributes()` to the actual control. Inline and fieldset/legend layouts prepare the foundation for choice controls.

Phase 2 provides **Input** (text, number, and password) at `/blade-components/input`, **Textarea** at `/blade-components/textarea`, and **Checkbox, Radio & Switch** at `/blade-components/choices`. Each control has its own example and options section within the combined page. Former Password, Checkbox, Radio, and Switch URLs redirect to the appropriate combined page. Pages include interactive Livewire examples, native Blade usage, props, errors, readonly/disabled semantics, and keyboard guidance. Each control has an ordinary POST demo with isolated validation and sample values. A combined native form remains in the development integration fixture.

Textarea uses `editor=false` by default. The `editor=true` mode is reserved for Phase 7 and is currently rejected explicitly.

Phase 3 provides **Currency** at `/blade-components/currency`: configurable grouping/decimal separators, exact canonical decimal strings, maximum precision with validation (no rounding or truncation), optional negative amounts, and string-based min/max checks. The paired project-budget and invoice-adjustment demos share exact copyable Blade sources. No additional dependency is required. Currency JavaScript is bundled into the same `dist/sirius.js` entry point, including published-asset usage. The native `/development/currency` and `/development/currency-bindings` fixtures cover editing, resets, modifiers, Alpine, and multiple Livewire instances in local/testing environments.

Phase 4 provides **Datetime Picker** at `/blade-components/datetime-picker` with `type="date|time|datetime"`, calendar/clock prefixes, and a Clear suffix using the shared input adornment styles. Display formats are separate from canonical wall-clock values (`Y-m-d`, `H:i`, and `Y-m-d H:i:s`). Flatpickr 4.6.13, locales, styles, and license notices are bundled in the package assets. The trip-planning demos cover date/time bounds, disabled dates, locale, server validation, reset, readonly/disabled behavior, and Livewire synchronization. Native-only and multiple-instance/Alpine fixtures live at `/development/datetime-picker` and `/development/date-bindings`. Global `locale` and `timezone` can be set in `config/sirius-ui.php` (publish with `php artisan vendor:publish --tag=sirius-ui-config`). Both default to null. At render time, timezone falls through `sirius-ui.timezone` → `app.timezone` → `UTC`, and locale through `sirius-ui.locale` → `app.locale` → `app.fallback_locale` → `en`; missing or null entries are skipped. Individual picker props may override them. Applications own timezone conversion and DST validation.

Development-only integration fixtures are available at `/development/integrations` and `/development/plain-blade` when the application environment is `local` or `testing`. These are experiments for later components, not public component APIs.

Checkbox and radio options inside `<x-sirius::field group>` share the group's error key, error bag, and accessible descriptions. Put `required` on the group to show a single required marker alongside a single set of validation messages. Required radio groups preserve native validation; validate minimum checkbox selections on the server.

Phase 2 integration fixtures at `/development/basic-controls` and `/development/standalone-controls` verify multiple Livewire instances and native controls without Livewire or Alpine. They are available only in local/testing environments.

The expanded roadmap in the implementation checklist runs through Phase 25. Planned additions include single/range Slider, Message and Dialog naming, new display/navigation/overlay components, and Livewire Chart. Table phases also include custom row, bulk, and toolbar actions, with confirmation/input forms and explicit atomic or partial-result handling. The AI agent skill follows all component phases; replacing Flux throughout docs precedes final release validation. These are planned APIs, not shipped components.

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
