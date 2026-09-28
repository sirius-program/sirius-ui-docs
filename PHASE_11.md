# Phase 11 - Icon, button, button group, badge, and message

## Contract

All five components are anonymous Blade views. They retain configurable Blade namespaces and require no new dependency. The icon wrapper uses the installed Blade Heroicons 2.7.0 set through Blade Icons; names such as `heroicon-o-check` identify icons. Other registered sets can also be used. Icons are decorative by default; `label` gives a meaningful icon an accessible name. Sizes are `sm`, `md`, and `lg` (16, 20, and 24 pixels); consumer classes can override styling.

Button, Badge, and Message share `primary`, `info`, `success`, `danger`, `warning`, `secondary`, `ghost`, and `outline`. Primary uses Tailwind sky, info uses neutral surface/text/border tokens, and secondary uses indigo. Success, danger, and warning use emerald, red, and amber. Semantic styles use `--sir-{variant}-bg`, `--sir-{variant}-text`, and `--sir-{variant}-border`, with light/dark values. Button also supports `link` independently of its HTML tag.

Button defaults to `as=button`, `type=button`, `variant=info`, and `size=md`. Only `button` and `a` tags are accepted. Explicit submit/reset types retain native behavior. `icon` is optional; icon-only buttons require `aria-label` or `aria-labelledby`. `loading` shows a decorative spinner, sets `aria-busy`, and prevents activation. Disabled anchors omit href, expose `aria-disabled`, and leave the tab order. Delegated capture listeners prevent click, auxiliary-click, Enter, and Space actions while locked, including consumer Alpine/Livewire handlers. Native disabled buttons work without JavaScript; custom anchor handlers and Message dismissal require package JavaScript. Livewire loading directives are forwarded; loading state itself is explicit, not inferred from arbitrary requests.

Button Group connects directly nested Button borders and corners, including RTL logical corners. It requires a group label or accessible labeling attributes. It adds no selection state, keyboard navigation model, or toggling.

Badge displays slotted content with optional decorative icon and three sizes. It has no automatic live-region behavior. Message icons and dismiss controls are vertically centered with the content. Message defaults to `role=status`, or `role=alert` for danger; consumers can override the announcement role. Its `dismissible` prop defaults to false. The dismiss control uses `sirius::sirius-ui.message.dismiss`. Message IDs default to five random characters; use explicit stable IDs in Livewire. Slot output follows Blade escaping rules; callers remain responsible for intentionally supplied HTML.

## Message lifecycle

Dismissal hides the current DOM element and dispatches a bubbling `message:dismiss` event with `detail.id`. A WeakMap retains dismissal while Livewire updates that element, without retaining removed DOM nodes. A changed `reset-key` restores visibility; remounting also creates a fresh message. Dismissal does not persist across navigation or update application models automatically. A single document-level listener owner avoids duplicate handlers during navigation. Reduced-motion preferences stop loading animation.

## Documentation and verification

Each component has its own route, page, attributes, Blade demo partials, and Usage block. Examples use invoice actions, payment statuses, and billing feedback. Non-form demos show all variants and omit Shared field contract; Livewire regression fixtures live at `/development/presentation` in local/testing environments only. Message translations have a separate section. Sidebar, breadcrumbs, and the component index include all five components. Existing architecture boundaries remain sufficient: no persistence or application dependency was introduced.

Rendering tests cover variants, escaping, icon names and accessibility, invalid configuration, native versus link semantics, forwarding, loading/disabled behavior, group naming, generated IDs, translation overrides, and announcement roles. Browser tests cover native actions, Livewire updates, disabled links, independent dismissal/reset events, connected group corners, and theme changes.

Completed phase gates: package `composer test` passed (289 tests, 917 assertions); docs `composer test` passed (135 tests, 711 assertions); docs `composer test:browser -- --processes=4` passed (79 tests, 830 assertions). Both production asset builds passed. Existing docs build notices about optional Fontaine and large chunks remain. Package Testbench emitted its existing Windows file-already-exists notice; all checks still completed successfully.
