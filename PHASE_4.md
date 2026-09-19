# Phase 4 — Date, time, and datetime

## Implemented contract

`<x-sirius::datetime-picker>` implements `type="date|time|datetime"` using internally bundled Flatpickr 4.6.13 (MIT). The package build includes the vendor distribution, all bundled locales, shared-token calendar styling, and `dist/third-party-notices.txt`; publishing `sirius-ui-assets` includes the notice. No CDN, key, jQuery, or second Alpine instance is required. The package npm audit reported no known vulnerabilities at installation.

Canonical strings use `Y-m-d`, `H:i`, and `Y-m-d H:i:s`. Defaults display `d/m/Y`, `H:i`, and `d/m/Y H:i:S` (Flatpickr's uppercase `S` means seconds). `timezone` resolves from the explicit prop, then `sirius-ui.timezone`, then `app.timezone`, then `UTC` and sets the initial calendar context; values are never automatically converted to UTC. Applications own persistence conversion and ambiguous/nonexistent DST-time validation. This phase does not provide timezone arithmetic.

Date/datetime display a calendar prefix; time displays a clock prefix. Clear is a suffix action sharing the same adornment styles as the password visibility button.

Named props cover display format, locale, first weekday, minute increment, date/time limits, disabled dates, and clearability. Explicit non-null props override the documented serializable options bag, which overrides defaults. Configuration rejects invalid types/timezones/locales, malformed or reversed bounds, incompatible date/time bounds, unsupported options, lossy model casts, and invalid option shapes/ranges. Disabled dates are a list of canonical dates; function-based disabling, plugins, multiple/range dates, custom DOM placement, and lifecycle overrides are outside this release.

The shared Field owns labels, five-character generated IDs, explicit IDs, helpers, error-key inference and error bags. Visible HTML attributes and event listeners stay on the display input; model bindings attach to the canonical hidden input. Enhancement removes the visible name and enables exactly one canonical submitted field, preserving external form association. Disabled values are omitted; readonly values remain submitted. Without JavaScript, the visible text field submits canonical text supplied by the caller/user.

## Interaction and lifecycle

The adapter owns visible text and uses a detached Flatpickr input for popup state. This prevents Flatpickr's permissive parser and outside-click behavior from clearing invalid text or rolling an invalid leap day into another month. Parsing requires a format round trip and valid configured bounds. Invalid text remains visible, fails native custom validity, and reaches application validation unchanged when native validation is bypassed. The docs explicitly use `novalidate` to demonstrate server errors.

One model-owned hidden input uses `wire:ignore` when bound, so stale SSR defaults cannot overwrite Livewire/Alpine values. Visible fields continue receiving normal validation and readonly/disabled morphs; drafts and caret survive unrelated/debounced renders. Mutation handling is idempotent, including initially disabled Clear buttons. Removal/navigation destroys widget instances and body-mounted popup nodes. Native reset also handles externally associated controls.

Keyboard ArrowDown opens the calendar and focuses its date/time control; arrow keys and Enter select days. Escape closes and returns focus. The popup has dialog naming and trigger associations. Clear has an accessible name and respects readonly/disabled. Calendar styles use package tokens in light/dark themes and respect reduced motion. The custom picker runs on mobile to keep canonical formatting and constraints consistent.

## Docs and architecture

The Datetime Picker navigation entry and breadcrumb open paired trip-planning Livewire/Blade demos. Usage contains separate exact native demo sources for departure date, reminder, and consultation datetime. Attributes, shared field contract, and assets/lifecycle guidance follow the existing docs structure. An invocable controller handles ordinary submissions and isolates its error bag/session values; no data is persisted.

The existing architecture boundaries remain sufficient: anonymous Blade presentation, a focused JavaScript widget owner, the existing shared Field adapter, application-owned validation/controllers, and no package business models. No new production PHP layer or architecture exclusions were necessary.

## Verification

- Package `composer test`: 81 tests / 340 assertions; Pint, PHPStan, and Rector passed.
- Docs `composer test`: 73 tests / 325 assertions; Pint, PHPStan, and Rector passed.
- Docs `composer test:browser`: 40 tests / 439 assertions passed, including five datetime-picker browser tests.
- Both asset builds passed. Browser cases cover native canonical payloads, leap-day/bound rejection, invalid input preservation, clear/reset/external forms, server loads, debounced typing, readonly/disabled, keyboard selection, time controls, Alpine, multiple instances, conditional remounts, navigation cleanup, and mobile light/dark layouts. Browser tests assert no JavaScript errors.
- Local execution uses the available PHP 8.5 / Laravel 13 environment. The existing Laravel 12/13 CI matrix remains in place; this phase does not claim a new local PHP 8.3 or Laravel 12 compatibility run.

## Sources checked during implementation

- [Flatpickr configuration](https://flatpickr.js.org/options/)
- [Flatpickr events and hooks](https://flatpickr.js.org/events/)
- [Flatpickr localization](https://flatpickr.js.org/localization/)
- [Livewire JavaScript lifecycle](https://livewire.laravel.com/docs/4.x/javascript)

The installed library source and license were checked before promotion from the Phase 0 proof. Flatpickr's older release cadence remains a maintenance consideration; recheck its license, advisories, and compatibility before an upgrade.

## Global localization follow-up

The published `sirius-ui` configuration now provides nullable `locale` and `timezone`. Null inherits the consuming application's `app.locale` and `app.timezone` at render time, so cached package config does not freeze a copied application default. Locale precedence is prop, options.locale, package config, app.locale, app.fallback_locale, then en. Timezone precedence is prop, package config, app.timezone, then UTC. Missing or null entries fall through; explicit invalid settings remain errors. Regional locales are normalized to an exact bundled locale or its language; unsupported languages and invalid timezones produce explicit configuration errors.

Regression coverage checks application changes between renders, global overrides, options/prop precedence, regional locales, invalid inherited settings, and missing/null fallback configuration. Package `composer test` passed with 92 tests / 365 assertions. Existing Phase 4 results above remain the original completion record.
