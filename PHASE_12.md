# Phase 12 - Card and accordion

## Card

`<x-sirius::card>` accepts escaped `header`, `body`, and `footer` strings. Named header/footer slots override their text props, including empty slots. A nonempty default slot replaces the body string. Empty header/footer sections are omitted; the body is always rendered.

The root ID defaults to a random five-character string. Rendered sections use `{id}-header`, `{id}-body`, and `{id}-footer`. Header/footer slot attributes and the three section class props merge with package styling. Slot IDs cannot replace the generated section IDs. Use explicit IDs when selectors or Livewire identity must remain stable.

Card requires package CSS only. It does not impose heading levels, field validation, variants, or application behavior. No architecture boundary or dependency changed.

## Accordion

`<x-sirius::accordion>` uses native details/summary. `trigger` text is required unless a named trigger slot supplies it; keep links and buttons inside content rather than the trigger. The default slot is the body. `open` and `transition` are booleans, both false by default. `trigger-class` and `content-class` customize the two sections. Stable root IDs produce `{id}-trigger` and `{id}-content` associations.

Native disclosure supports keyboard activation and remains usable without JavaScript. Package JavaScript adds explicit aria-expanded synchronization and inert content, focus restoration when closing focused content, and a bubbling `accordion:toggle` event with `{id, open}`. An optional 160ms opacity/translation animation runs when opening. Closing is immediate so content leaves keyboard navigation promptly; reduced-motion preferences skip animation. Removed elements are held only in a WeakMap and document listeners are installed once.

`open` can be controlled through Alpine x-bind:open or server-rendered :open. In Livewire, synchronize user events back to the application's boolean property and use stable IDs/keys. Guard the event handler against nested events and unchanged values to avoid redundant requests. Direct wire:model is not supported. Unrelated server updates restore the supplied open value if the application does not synchronize user toggles.

Native behavior reference: [MDN details](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/details).

## Documentation and verification

Accordion items with the same nonempty `name` form a native exclusive group: opening one closes the others, and all can be closed. Names must be unique per group across the page; set `open` on at most one item. The Order help demo includes a separate copyable example. Browser coverage checks keyboard activation, group exclusivity, closing all items, and independence from ungrouped items. The former Collapsible component, event, selectors, and docs route are now named Accordion.

Attribute tables use one row per attribute, including Card sections, section classes, and Datetime Picker bounds. This convention is recorded in AGENTS.md.

Both pages have Blade-only demos, one copyable Usage per demo, Attributes, and Assets and interaction. Card demonstrates text shorthand and slots; Accordion demonstrates independent closed/open disclosures and custom trigger content. Neither component has variants or a Shared field contract. Sidebar, breadcrumbs, routes, and the component index are updated. A development-only Livewire fixture checks state updates, removal/remounting, and card content changes.

Rendering tests cover escaping, slot precedence and empty slots, section styling and protected IDs, generated IDs, native open defaults, and invalid inputs. Browser tests cover independent keyboard operation, hidden-content focus exclusion and return, event uniqueness, server changes, user-to-server synchronization, and remounting.

Completed verification: package `composer test` passed (305 tests, 972 assertions); docs `composer test` passed (138 tests, 724 assertions); docs `composer test:browser -- --processes=4` passed (83 tests, 864 assertions). Both asset builds passed. Existing optional Fontaine/large-chunk build notices and the Windows Testbench file-already-exists notice remain; no test warnings or JavaScript errors were reported.
