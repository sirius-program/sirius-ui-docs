# Phase 9 - Slider

## Contract

`<x-sirius::slider>` accepts a numeric value, min (0), max (100), and positive step (1). The default scalar value is min. `range` requires exactly two numbers in each of value, min, max, and step. Bounds may differ per handle; both handles share the scale from the smallest min to the largest max. Steps are anchored at each handle's min. The last selectable value is the greatest grid point at or below max.

Values remain ordered, including equality where both grids allow it. Pointer and keyboard moves clamp to each handle's current valid grid interval. PHP configuration errors throw an exception. Invalid programmatic binding values retain the last valid selection, display a translated error, and set native custom validity; a valid update clears the error. Consumers must validate untrusted requests on the server.

Numbers must be finite and within JavaScript's safe numeric bounds. Step counts must also fit a safe integer and steps must be representable at the minimum. This control uses JavaScript numbers; use Currency when exact financial arithmetic is needed.

## Integration

Single mode submits one field; range mode submits two ordered `name[]` entries. Bind a number or numeric array with Livewire or Alpine; coercion modifiers are rejected. Readonly values remain in submissions, disabled values are omitted. Native reset includes externally associated form controls. Ordinary numeric inputs remain usable without JavaScript.

The shared Field adapter renders one label, required marker and helper/error area. Range validation may use an error-key wildcard to include array-entry errors. Each handle has an accessible name and current min/max/value; dependent bounds update when its neighbor moves. Keyboard support includes arrows, Home/End and Page Up/Down. Pointer events cover mouse, pen and touch. Native inputs retain form ownership while an ignored model bridge and UI subtree support Livewire updates, Alpine, teardown and navigation.

The implementation adds no dependency. UI translations live in `sirius::sirius-ui.slider.*`. The existing architecture tests cover the new stateless PHP helper and keep it independent of application persistence.

## Documentation and verification

Paired Blade/Livewire demos use seasonal discounts and nightly budgets, with independent copyable examples, attributes, Shared field contract, assets, and translations. The controller validates scalar limits/steps and both range entries. Invalid requests do not re-render malformed values as component configuration.

Tests cover malformed configurations, decimal and per-handle grids, equal/crossing values, canonical payloads, invalid programmatic values, Livewire/Alpine updates and resets, readonly/disabled, form association, navigation, drag, touch, keyboard, and mobile light/dark layouts.

Accessibility reference: [WAI-ARIA multi-thumb slider pattern](https://www.w3.org/WAI/ARIA/apg/patterns/slider-multithumb/).

Completed verification: package `composer test` passed (246 tests, 682 assertions); docs `composer test` passed (109 tests, 606 assertions); then docs `composer test:browser -- --processes=4` passed (71 tests, 773 assertions). Both production asset builds passed. No dependency or architecture boundary changes were needed.
