# Phase 5 — Phone input

## Implemented contract

`<x-sirius::phone>` uses the shared field contract and internally bundled libphonenumber-js 1.13.13 with full validation metadata. The pinned dependency's MIT license and metadata Apache 2.0 notice ship with the assets. No CDN, hosted service, API key, or additional Alpine instance is required.

The public prop is `country`: a country or regional locale string, a non-empty list, or `*`. Explicit country takes priority over `sirius-ui.phone_country`, `sirius-ui.locale`, `app.locale`, `app.fallback_locale`, and finally `US`. Null entries fall through at render time. Published configuration exposes `SIRIUS_UI_PHONE_COUNTRY`. Regional locales resolve to their country; documented language mappings support inherited application locales. Invalid settings produce configuration errors.

Single-country controls show a fixed calling-code prefix. Multiple countries use an accessible native select sharing input adornment styles, with a fixed five-character text area and ellipsis. Options retain full labels such as `+62 - Indonesia`. Wildcard options sort numerically by calling code, then by name; explicit arrays retain order and remove duplicates. Wildcard initial country follows the global chain, skipping wildcard entries. Arrays start with their first country.

The delimiter defaults to a space and also accepts a hyphen, period, or empty string. Grouping and trunk-prefix normalization come from country metadata. Valid values submit and bind E.164 strings such as `+6281234567890`; invalid or incomplete drafts produce null models while remaining visible. Native forms represent null as an empty string, which Laravel normally normalizes to null. Extensions are rejected. Complete international values can select an allowed detected country. Manual country changes retain national digits and reinterpret them using the new country.

## Integration and validation

The visible input owns native attributes, labels, helpers, and validation feedback. One hidden field submits the canonical value. A separate model bridge preserves actual null values for Alpine and Livewire. Invalid feedback appears on blur or validation; partial typing survives debounced updates and morphs. Explicit loads replace state, and `reset-key` clears drafts even when the model was already null.

Readonly controls retain submission and disable country changes. Disabled controls omit submission. Native reset includes externally associated controls. Remounts and navigation do not duplicate listeners. Without JavaScript the control does not submit a canonical value and explains the requirement.

Native failed-validation restoration is opt-in through `draft-name` and `draft`. The docs controller bounds and validates that separate JSON payload before flashing it back. Application-side validation remains authoritative. The optional package rule `Sirius\Ui\Rules\PhoneNumber`, also used by both docs demos, checks international syntax and permitted calling-code prefixes only; it is not full server-side numbering-plan validation. Applications requiring that assurance should validate with maintained server metadata. Number validity does not prove ownership or reachability.

## Documentation and architecture

The Phone page contains matching Livewire and Blade delivery, supplier, and travel contact demos, separate copyable Blade examples, attributes, shared field contract, assets, and global configuration guidance. An invocable controller handles ordinary submissions without persistence. Development fixtures exercise native forms and isolated Alpine/Livewire instances.

`Support/PhoneCountry` resolves configuration against generated bundled metadata; architecture tests prohibit database dependencies in package support classes. Presentation stays in anonymous Blade, and JavaScript owns formatting and lifecycle. The package README remains a docs pointer.

## Verification

- Package `composer test`: 146 tests / 491 assertions; Pint, PHPStan, and Rector passed.
- Docs `composer test`: 77 tests / 356 assertions; Pint, PHPStan, and Rector passed.
- Docs `composer test:browser`: 46 tests / 503 assertions, including six phone browser cases.
- Both asset builds passed. Browser coverage includes canonical payloads, delimiters, country changes, paste, drafts, extensions, reset/load, readonly/disabled behavior, caret deletion, Alpine null binding, Livewire delayed updates, remount/navigation, fixed prefix width, and mobile light/dark layouts.
- Local checks use PHP 8.5 / Laravel 13; existing CI covers the other supported combinations.

The [official libphonenumber-js repository](https://github.com/catamphetamine/libphonenumber-js) and installed source/license files were reviewed. Rebuild metadata and recheck licenses when updating the dependency.
