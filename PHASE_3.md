# Phase 3: Currency input

Status: complete. The mandatory phase gate passed on 2026-09-13.

## Agreed implementation contract

`<x-sirius::currency>` uses a formatted text input and one canonical submission/binding input. Default `thousands-separator=","`, `decimal-separator="."`, `precision=2`, and `allow-negative=false`. Separators must differ: decimal is dot or comma; grouping is dot, comma, space, or apostrophe. Precision is an integer from 0 through 20.

**Excess precision is a validation error. No rounding, truncation, or floating-point conversion is performed.** All fractional digits remain visible and in the canonical value so application validation can reject them. Precision is a maximum; values are not automatically padded. Empty stays empty; zero stays zero. Initial values, min/max, and model values must be canonical decimal strings (integer initial values are also accepted). Use strings for monetary state, never `.number` or `.boolean` bindings.

Typing formats thousands while preserving the caret. A leading decimal is normalized to zero; a trailing decimal is retained while editing and removed on blur. A lone optional minus is an incomplete editing state with an empty canonical value. Pasting trims outside whitespace but otherwise accepts only the configured notation, with correctly placed grouping separators; currency symbols, mixed locale notation, exponent notation, malformed groups, and other characters reject the entire paste and preserve the existing amount. Rejected keystrokes likewise leave the previous amount intact.

The visible control receives labels, helpers, errors, HTML attributes, data/ARIA, and event directives. Only `name`, the `form` association, and value bindings belong to the canonical input after initialization. `wire:model` (including live/debounce, blur/change/lazy timing) and Alpine `x-model` bind canonical strings. Prefix and suffix accept strings or slots and never enter the value.

`min` and `max` use canonical decimal strings and are checked by string comparison in JavaScript. Native `required`, pattern, and length constraints apply to the formatted text; native numeric step validation is not provided by a text input. Application validation remains authoritative, particularly with `novalidate` or Livewire actions. Client validity uses the browser constraint-validation API. Disabled controls are omitted; readonly values remain submitted. With JavaScript unavailable, the visible input submits unformatted canonical text and application validation must reject noncanonical values.

One bundled vanilla JavaScript owner initializes controls, observes canonical value changes and replacement nodes, forwards input/change/blur events to the binding input, and handles native reset. No new third-party dependency or API key is needed.

## Verification

- Package `npm run build`: passed. The build combines the basic-control and currency sources into the existing published `dist/sirius.js` entry point.
- Docs `npm run build`: passed against the locally linked package.
- Package `composer test`: passed, 56 tests / 277 assertions, including architecture, rendering, escaping, invalid configuration, and canonical binding routing; Pint, PHPStan, and Rector passed.
- Docs `composer test`: passed, 59 tests / 262 assertions, including actual controller submission, isolated errors/state, and Livewire validation; Pint, PHPStan, and Rector passed.
- After both project gates passed, docs `composer test:browser`: passed, 34 tests / 367 assertions. Currency coverage includes large exact values, reversed separators, strict invalid paste rejection, leading/trailing decimals, zero/empty, negatives, precision, string-based bounds, caret and grouping-boundary deletion, native reset (including controls outside their associated form), disabled/readonly submission, server validation redirects, Livewire load/reset/remount/navigation, model modifiers, Alpine binding, multiple instances, and narrow layouts in both themes. Browser tests assert no JavaScript errors.
- The existing isolated Laravel 12 compatibility fixture passed the currency rendering/configuration suite: 15 tests / 43 assertions. This was run on the available PHP 8.5 runtime; it is not a claim of a new local PHP 8.3 or full browser/OS compatibility run.

Architecture rules required no weakening or new exception: currency is an anonymous Blade component using the existing shared Field adapter; application validation and demo state remain in docs. The package README remains the minimal docs pointer. No new dependency, CDN, or environment key was introduced.

## Maintenance and limits

Browser coverage uses the installed Chromium test runtime. JavaScript is required for formatting and client synchronization; application validation must still reject noncanonical submissions when scripts are unavailable or client checks are bypassed. Display patterns and lengths are not canonical-number constraints. Monetary state and bounds should be supplied as strings; no numeric binding modifiers or automatic rounding are supported. Demo controller length limits are application policy, not a package maximum amount.

The native reset adapter schedules formatting after the browser's default reset action; doing it in a reset-event microtask can leave externally associated controls unformatted. Keep this regression test when changing the lifecycle code.

Integration was checked against installed Livewire 4 behavior and the [official wire:model timing documentation](https://livewire.laravel.com/docs/4.x/wire-model). Canonical inputs do not participate in browser constraint validation, so validity belongs to the visible control, following [MDN hidden-input semantics](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/input/hidden) and [setCustomValidity](https://developer.mozilla.org/en-US/docs/Web/API/HTMLInputElement/setCustomValidity).


## Follow-up: debounced Livewire editing

Fixed the package currency adapter after reports that typing disappeared following the live debounce. A model-bound canonical input must not accept the empty initial `value` attribute from a server-rendered template. Only that internal input now uses `wire:ignore`; its Alpine/Livewire value binding continues to synchronize server changes. The visible field still receives ordinary morph updates for validation, readonly, and disabled state. Morph hooks restore the current display draft and caret, including a trailing decimal while editing. Name and external form association continue to follow the visible control.

The regression types real keys slowly enough to cross the 150 ms debounce, waits for network idle, and verifies the amount remains visible without submitting or loading another value. It also checks continuing a fractional edit after a response. The full currency suite retains native reset, server updates, model modifiers, Alpine, remounts, and navigation coverage.

Verification: both asset builds passed; package `composer test` passed (56 tests / 277 assertions), docs `composer test` passed (59 tests / 262 assertions), then docs `composer test:browser` passed (35 tests / 373 assertions).
