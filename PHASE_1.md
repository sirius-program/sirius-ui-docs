# Phase 1 — Shared form foundation and label

Implemented on 2026-09-12 at the user's request. This phase ships `label` and the low-level `field` composition API. Dedicated inputs, checkbox, radio, and switch remain in Phase 2.

## Public behavior

- `label` renders escaped slot content with an optional red, decorative required marker. It supports `for`, merged HTML attributes/classes, and `as="legend"` for groups.
- `field` renders stacked or inline layouts and fieldset/legend groups, helper text, all matching validation messages, and stable accessibility associations. Helpers remain visible alongside errors.
- Supply a stable unique `id`; helper and error IDs append `-helper` and `-error`. Repeated fields need record-specific IDs. Generated random IDs are intentionally avoided across Livewire renders.
- Error lookup prefers `error-key`, then `wire:model` including modifiers, then a bracket-normalized HTML name. Named Laravel bags and an explicit `ViewErrorBag` override are supported. An empty explicit error key suppresses lookup.
- Apply `$component->controlAttributes()` exactly once inside the field's direct slot. It routes native HTML, data, ARIA, Alpine, and Livewire attributes to the actual control. Wrapper styling uses `wrapper-class`; control styling uses `class`.
- Group controls receive their own IDs, names, and bindings. Shared helper/error descriptions belong to the fieldset; required marks the legend without forcing every checkbox to be selected. Group disabled uses native fieldset semantics.
- Shared `sir-` classes and `--sir-` tokens cover three sizes, spacing, focus, invalid, disabled, readonly, light/dark themes, and narrow layouts. Native readonly applies only where HTML supports it; choice-control readonly behavior is reserved for Phase 2.

## Architecture refinement

`label` remains an anonymous Blade component. `Field` lives in `src/View/Components` and extends Laravel's `Illuminate\View\Component`: the class exposes scoped attribute and error methods so a control slot and the surrounding label/helper/error layout share one implementation. Templates remain in `resources/views/components`. No application models, queries, business services, or new JavaScript dependencies were introduced.

The architecture suite now requires class-backed Blade adapters to extend Laravel's component base and prohibits database dependencies. Existing independence, strict typing, environment-access, and PSR-4 rules still apply. The provider registers the public field under the configured Blade namespace, with a private static alias for the shared label view; a custom-namespace render test covers this boundary.

A temporary adapter calling `DB::select()` was rejected by the new architecture rule with `Expecting 'Sirius\Ui\View\Components' not to use 'Illuminate\Support\Facades\DB'`. The probe was removed before the final gate; no intentionally invalid source remains.

## Documentation and tests

The docs sidebar and component index expose `/components/label` and `/components/forms`. Examples cover ordinary POST validation with a named error bag, nested names and old input, Livewire validation, corrected values, reset, readonly, inline controls, and accessible groups. Demonstration values are not persisted. The package README retains its documentation pointer.

Package render tests cover required true/false, escaping, attribute routing, error precedence, named bags, stable IDs, multiple fields, group semantics, and configurable namespaces. Docs feature tests exercise both validation paths; the ordinary redirect test explicitly carries the session cookie, matching a real browser with Laravel's JSON session serialization.

Browser tests exercise real POST redirects, old input, Livewire error/helper updates, reset, readonly, label activation, navigation, and light/dark layouts at 390px. Mobile screenshots are generated in the ignored browser screenshot directory for visual review.

## Verification

- Package `npm run build`: passed.
- Docs `npm run build`: passed.
- Package `composer test`: passed, 17 tests and 95 assertions; formatter, PHPStan, and Rector checks also passed.
- Docs `composer test`: passed, 10 tests and 48 assertions; formatter, PHPStan, and Rector checks also passed.
- After both project gates passed, docs `composer test:browser`: passed, 8 tests and 59 assertions, including the existing Phase 0 widget coverage.
- Visually reviewed the desktop label page and both 390px form screenshots. Fields remain inside the viewport and labels, helpers, group legends, and controls remain readable.

Phase 1 is complete. Phase 2 has not started.
