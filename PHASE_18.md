# Phase 18 — Tabs and Timeline

## Component contracts

`<x-sirius::tabs>` accepts a non-empty `items` array keyed by tab name. Each item is a label string or an array with `label`, optional `icon`, and boolean `disabled`. Supply one `panel-{name}` named slot per tab. Blade normalizes slot names to camel case; names must map to distinct slots. The root ID defaults to five random characters; triggers use `{id}-tab-{name}` and panels use `{id}-panel-{name}`. Explicit IDs and `wire:key` provide stable Livewire identity.

`active` selects a tab, falling back to the first enabled item for a missing, unknown, or disabled name. All-disabled lists have no selected panel. `orientation` defaults to horizontal; `activation` defaults to automatic. `class` styles the wrapper, `list-class` the list, and `panel-class` every panel. Named panel slot attributes merge into their panel while managed IDs, roles, associations, and hidden/inert state remain protected.

All panels render server-side and stay mounted when switching. Hidden panels are inert and cannot receive keyboard focus; their form values remain available for native and Livewire submission. There is no lazy rendering or automatic validation navigation. Applications select the panel containing an invalid field and own validation rules.

`<x-sirius::timeline>` renders an ordered vertical sequence with an accessible `label`. Each `<x-sirius::timeline.item>` accepts `title` text or a named title slot, optional text `description`, `state=completed|current|upcoming` (default upcoming), optional Blade `icon`, and a positive integer `number`. Marker precedence is named `marker` slot, icon, number, then state marker. The default slot accepts additional content/actions. Markers are decorative; translated state text and `aria-current="step"` communicate progress.

Timeline owns presentation only. Consumers determine progression and supply links, actions, and validation. No form-field contract or automatic workflow is imposed.

## Interaction and lifecycle

Tabs follows the [WAI-ARIA Tabs pattern](https://www.w3.org/WAI/ARIA/apg/patterns/tabs/): tablist/tab/tabpanel roles, selected states, reciprocal ARIA references, roving tab stops, and horizontal Left/Right or vertical Up/Down navigation. Horizontal direction respects RTL. Home/End select the first/last enabled tab. Automatic activation selects on arrow-key focus; manual activation waits for Enter, Space, or click. Tab moves to the selected panel and its controls. Disabled items are skipped; arrow navigation wraps.

When state changes hide focused content, focus moves to the newly selected trigger. If no enabled item remains, focus moves to the wrapper. A single delegated JavaScript owner reconciles DOM mutations and Livewire morphs, removes detached instances, and reinitializes on navigation. Nested Tabs own only their own triggers/panels.

`tabs:change` bubbles from the root with `{ id, value, previous, reason }`. Use `:active` plus the event for Livewire state, or `x-bind:data-active` plus the event for Alpine. Direct `wire:model` is not supported. Filter nested events with `$event.target === $el`. Local selection survives an unrelated server render; changed server/Alpine active state takes precedence. Invalidated local selections fall back and emit a change so bound state can follow.

Tabs requires package CSS and JavaScript. Without JavaScript, the server-selected panel remains visible. Timeline needs CSS only. No dependency or configuration key was added. Accessibility strings are grouped under `tabs` and `timeline` in `resources/lang/en/sirius-ui.php`; consumers override them under `lang/vendor/sirius/{locale}/sirius-ui.php` using the existing publishing tag.

## Documentation and verification

Separate pages include Demo, Usage, Attributes, Assets and interaction, and Translations; Tabs also has State and events. Public demos use Blade only. Each demo has its own exact-source copyable Usage. Tabs shows project sections and manual vertical settings; Timeline shows onboarding and delivery with custom markers/actions. Menus and the component index place Tabs alphabetically in Layout and Timeline in Presentation.

Development fixtures at `/development/tabs-timeline` exercise native form values, nested Tabs, Livewire bound/local state, dynamic disabled/removal/remounting, Alpine, Dialog, and navigation. Package tests cover associations, escaping, fallback/all-disabled states, slot precedence, translations, custom namespaces, and invalid definitions. Browser tests cover keyboard behavior, hidden-panel focus, form value preservation, Livewire synchronization/morphs, dynamic changes, Alpine, nested/Dialog contexts, navigation, and both themes on mobile.

- Package `npm run build`: passed; unrelated generated country data was preserved.
- Docs `npm run build`: passed; docs imports the current package assets through its local Composer junction.
- Package focused feature tests: **22 passed / 82 assertions**.
- Docs focused feature tests: **4 passed / 34 assertions**.
- Package `composer test`: **477 passed / 1,568 assertions**.
- Docs `composer test`: **164 passed / 948 assertions**.
- Focused browser tests: **9 passed / 64 assertions**.
- Full docs `composer test:browser -- --processes=2`: **165 passed / 1,789 assertions**.
- Formatting, static analysis, Rector, architecture checks, and `git diff --check`: passed.

Mobile screenshots were visually reviewed in both themes. The integration application uses Laravel **13.31.0** and Livewire **4.4.4**. The remote Laravel 12/13 compatibility matrix was not run locally. No dependency, vendor source, or operating-system configuration was changed.
