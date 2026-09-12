# Phase 2 — Basic form controls

This phase implements `input` (text, number, password), plain `textarea`, `checkbox`, `radio`, and `switch`. Following the user's documentation refinement, Password shares the Input page, and Checkbox, Radio, and Switch share a combined page. Each retains its own independent example and options section; former individual URLs redirect to the combined pages.

## Architecture and public contract

All five public components are anonymous Blade views. A shared internal control partial composes the existing class-backed `Field` through a static internal alias, preserving configurable public namespaces. The partial reuses label, helper, errors, IDs, and attribute routing. No business services or application model dependencies were added to the package.

Provide an explicit stable unique ID. All controls support the shared field props and forward remaining native HTML, data, ARIA, Alpine, and Livewire attributes to the real control. Visual sizing uses `size=sm|md|lg`; `control-size` maps the native size attribute. Classes customize the control; `wrapper-class` customizes the field.

Input adornments accept strings or named slots, with slots taking precedence. Adornments never alter the submitted value. Password visibility uses Blade Heroicons and an accessible non-submit button. The native textarea accepts rows, cols, wrapping, length limits, resize direction, and initial value/slot content. Richtext remains reserved for Phase 7.

Checkbox supports boolean and array bindings, explicit values including string `0`, checked state, and independent indeterminate state. Radio options use distinct IDs and shared names/bindings. Switch uses a native checkbox with `role="switch"` and no mixed state. No duplicate hidden values are inserted; application code normalizes unchecked boolean fields.

## JavaScript and lifecycle

The package owns a small dependency-free script in `resources/js/sirius.js`, copied to `dist/sirius.js` by `npm run build` and included in the existing asset publish tag. Docs imports the built script from the local package. Consumers may import it or load the published asset once; no runtime CDN or second Alpine instance is needed.

Document-level delegated handlers and one guarded MutationObserver support later insertion and Livewire navigation without per-control event registrations. A WeakSet tracks password visibility without retaining removed nodes. Toggling preserves input value and selection and restores focus. Existing inputs preserve visibility through server updates; native reset or remount starts masked.

Readonly choice controls block user click/Space/arrow changes while preserving focus and native submission. Server updates remain possible. A readonly radio locks its same-name/form group; applications should apply readonly consistently to every option. This is a UI restriction, not an authorization boundary, and requires the package script. Native disabled semantics remain unchanged.

Indeterminate changes are applied to the native DOM property. User activation clears the mixed state; changed server attributes or remounts reapply it. Native reset restores the declared mixed state independently of checked state and submitted value.

## Documentation and verification scope

Docs routes with application logic use focused invocable controllers. Ordinary POST examples validate a named error bag and normalize an omitted switch without persisting records. Password examples use demonstration values, never output password state, and advise against repopulating real secrets from old input.

Package feature tests cover native attributes, adornment slots, escaping, icons, error bags, checked/readonly/disabled state, unsupported configurations, namespaces, native sizing, and textarea content. Docs tests cover every page and each control's validation integration. Browser tests cover client/server synchronization, selection retention, boolean/array values, radio and switch behavior, readonly keyboard/label activation, native resets/submission, independent instances, conditional remounts, navigation, and standalone operation with neither Livewire nor Alpine loaded.

The existing architecture rules continue to apply; this phase adds no new PHP layer requiring an architecture exception. Visually reviewed browser screenshots at 390px cover light/dark layouts and long adornments.

## Final phase gate

Completed on 2026-09-12:

- Package `npm run build`: passed, producing CSS and JavaScript assets.
- Docs `npm run build`: passed, consuming the built local package assets.
- Package `composer test`: passed, 32 tests and 179 assertions; Pint, PHPStan, Rector, and architecture checks passed.
- Docs `composer test`: passed, 24 tests and 106 assertions; Pint, PHPStan, and Rector checks passed.
- After both project checks passed, docs `composer test:browser`: passed, 15 tests and 168 assertions, including prior-phase coverage.

Phase 2 is complete. Phase 3 has not started. The package README retains its minimal documentation pointer.
