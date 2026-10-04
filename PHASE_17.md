# Phase 17 — Tooltip and Popover

## Component contracts

`<x-sirius::tooltip text="...">` wraps one focusable element in its default slot. Its text is escaped and cannot contain interactive content. `<x-sirius::popover>` accepts one focusable element in a named `trigger` slot and HTML in its default slot. Existing trigger attributes and Alpine/Livewire actions stay on the original element. Consumers should use buttons for action triggers and retain accessible names on icon-only controls.

Both components accept `id`, `variant=info|primary|secondary|warning|success|danger`, and `placement=top|right|bottom|left`. IDs default to random five-character strings; panel IDs append `-content`. Tooltip defaults to top placement and Popover to bottom placement. Both default to the neutral `info` variant; the other variants use their matching theme tokens.

Popover also accepts `label`, boolean `open`, and `wrapper-class`. The `class` attribute styles the content panel; `wrapper-class` styles the outer wrapper. Its accessible name defaults to `sirius::sirius-ui.popover.label`; published overrides belong in `lang/vendor/sirius/{locale}/sirius-ui.php`. The panel uses nonmodal dialog semantics. Other root attributes go on the wrapper; trigger attributes belong on the slotted element. These are not form fields and do not use `wire:model`.

## Interaction and lifecycle

Tooltip activates by hover or focus and stays open when the pointer enters its panel. Escape dismisses it until the pointer/focus leaves. Its actual trigger receives an `aria-describedby` association without removing existing references. Popover opens by click, touch, Enter, or Space. Focus enters the first available control, or the panel when it has no controls. Escape and `data-sir-popover-close` actions return focus to the trigger; outside interaction and tabbing out close without stealing focus. There is no modal focus trap.

Opening a sibling Popover closes the previous one. Nested Popovers remain inside their parent's DOM hierarchy and close from the deepest panel first. Escape closes Tooltip/Popover before its containing Dialog or Slideover. Closed panels become inert during the exit fade. Entry/exit fades respect reduced motion.

One document-level owner manages positioning and lifecycle. Panels flip to the opposite side when needed and clamp to the visual viewport; long HTML content scrolls. Scroll/resize and content-size changes update their position. The native Popover API puts panels in the top layer while preserving their DOM ancestry, so Dialog/Slideover body scrolling does not clip them or break modal focus containment.

Tooltip and Popover display a decorative triangular arrow using the panel variant's background and border colors. Its side follows the resolved placement, and its offset follows the trigger after viewport clamping, staying clear of rounded corners. Only the inner content scrolls, leaving the arrow visible outside the panel.

Client state survives unrelated Livewire morphs; changes to the `open` prop update Popover state. Replaced triggers/panels reconnect their associations. Removal clears timers and observers without mutating detached elements; navigation closes panels and initializes new instances without duplicating listeners. Events `tooltip:open/close` and `popover:open/close` bubble with `{ id, reason }`.

This implementation requires a browser with the native Popover API. Unsupported browsers keep panels hidden and retain the trigger's original behavior. No JavaScript dependency, configuration key, or publishing tag was added.

## Documentation and verification

Tooltip and Popover have separate pages, demos, copyable Usage, individual attribute rows, and Assets and interaction. All six variants are demonstrated. Tooltip includes an icon-only trigger; Popover includes project access information and interactive visibility filters. Popover has State and events and Translations sections. Shared field contract is omitted.

Both appear alphabetically in the Presentation group. Livewire and nested Dialog/Slideover fixtures are part of `/development/overlays`, without another development URL.

Package tests cover escaping, trigger markup/actions, variants, IDs, translation overrides, namespace customization, managed semantics, and invalid contracts. Browser tests cover hover/focus, keyboard, touch, focus return, ordinary Tab exit, viewport edges, replacement triggers, long content, both themes, reduced motion, Livewire morphs/removal/navigation, and nested modal interaction. Every case checks JavaScript errors.

- Package `npm run build`: passed; unrelated generated country names were preserved.
- Docs `npm run build`: passed; the existing large-chunk advisory remains.
- Package `composer test`: **455 passed / 1,486 assertions**.
- Docs `composer test`: **160 passed / 914 assertions**.
- Focused floating browser tests, including arrows on all four sides and viewport clamping: **18 passed / 191 assertions**.
- Full docs `composer test:browser -- --processes=2`: **156 passed / 1,725 assertions**.
- Formatting, static analysis, Rector, architecture checks, and `git diff --check`: passed.

Mobile light/dark screenshots were visually reviewed. The integration application uses Laravel **13.31.0** and Livewire **4.4.4**; the remote CI compatibility matrix was not run in this phase.

References: [native Popover API](https://developer.mozilla.org/en-US/docs/Web/API/Popover_API/Using), [WAI Tooltip pattern](https://www.w3.org/WAI/ARIA/apg/patterns/tooltip/), and [nonmodal dialog semantics](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/dialog_role).
