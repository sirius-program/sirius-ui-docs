# Phase 16 — Breadcrumb, Menu, and Dropdown

## Component contracts

Breadcrumb uses slotted `breadcrumb.item` elements with `link` and `current`. The root accepts a translated navigation `label`, escaped text `separator`, or `separator-icon`; an icon takes precedence over text. The current item receives `aria-current="page"`, and separators are decorative. Breadcrumb uses native link navigation and requires only the package CSS.

Menu is a persistent navigation landmark with ordinary links, action buttons, and disclosure submenus. Dropdown is a button-triggered action menu with `id`, text or slotted `trigger`, boolean `open`, and `align=start|end`. A trigger slot supplies button content and attributes, without nesting another button. Dropdown and submenu associations receive random five-character IDs when needed; explicit IDs remain supported.

`menu.item` and `dropdown.item` share one internal renderer and the same public props: `id`, optional `icon`, `name`, optional `link`, optional `trailing`, `disabled`, `active`, and a `submenu` slot. Default content overrides `name`; a named trailing slot overrides its text prop. Trailing content can display a shortcut or badge. Links navigate; items without a link use `type="button"` and preserve consumer Alpine/Livewire actions. Disabled items block activation and remove link destinations. Submenu triggers are buttons and cannot also be navigation links. Nested item content must not contain additional interactive controls.

Menu preserves ordinary Tab navigation and marks active navigation links with `aria-current="page"`. Its submenus expand inline. Dropdown uses menu/menuitem roles, managed focus, and programmatic item tab stops. Disabled Dropdown items remain focusable, following the action-menu pattern, while disabled Menu items are excluded from Tab navigation. `active` highlights a Dropdown item without implying a checked or selected command.

## Interaction and lifecycle

Dropdown opens by click, touch, Enter, Space, or Up/Down. Up/Down, Home/End, and typeahead move focus. Direction-aware Left/Right arrows enter or leave submenus; Enter/Space opens a submenu. Escape closes the current submenu or Dropdown and returns focus. Tab exits; selecting an action closes the Dropdown and returns focus to its trigger. Outside interaction closes it without stealing focus. Opening another Dropdown closes the previous instance. Menu disclosure submenus support click, Enter/Space, arrows, and Escape without requiring hover.

Fixed panels remain in their original DOM hierarchy. Positioning clamps them inside the visual viewport, flips submenus when needed, supports RTL, and updates during scrolling/resizing. Long menus scroll. Entry and exit use simple opacity fades; reduced motion disables animation. Closing panels become inert immediately, preventing hidden actions from retaining focus.

One document-level owner manages listeners and targeted DOM observation. It preserves client open/submenu state through unrelated Livewire morphs, applies changes to the server `open` prop, and moves focus into a menu opened from the server. Removed instances release their state; navigation closes menus and new roots initialize without duplicate listeners. `dropdown:open` and `dropdown:close` bubble from the root with `{ id }` in their event detail. This is an initial/server-updated prop and event contract, not a `wire:model` binding.

Navigation names, link attributes, text separators, and trailing strings are escaped. Links reject unsupported executable schemes and control characters. Consumer slots retain Blade's normal trusted-markup contract. UI disabling is not server authorization; business actions and authorization remain the consuming application's responsibility.

Default accessible names use `sirius::sirius-ui.breadcrumb.label` and `sirius::sirius-ui.menu.label`. Overrides belong in published `lang/vendor/sirius/{locale}/sirius-ui.php`. No dependency, configuration key, business model, or publishing tag was added. The shared renderer has a namespace-independent internal registration. Existing architecture tests and the minimal package README are preserved.

## Documentation and verification

The three public pages contain separate Demo, Usage, Attributes, and Assets and interaction sections. Each Blade demo has its own copyable source. Breadcrumb demonstrates both separators; Menu demonstrates nested workspace navigation, badges, active/disabled items, and actions; Dropdown demonstrates invoice actions, nested exports, shortcuts, badges, and navigation. Shared field contract is omitted because these are not form fields. Default navigation names are documented in separate Translations sections; Dropdown has a State and events section. Root and item forwarding notes describe their actual attribute targets.

A new Navigation menu group lists Breadcrumb, Dropdown, and Menu alphabetically in the sidebar and docs index. Livewire lifecycle tests use `/development/navigation`, available only in local/testing environments; public demos remain Blade-only. Existing Flux shell components remain for the planned migration phase.

Package tests cover escaping, unsafe links, item/slot precedence, disabled links, managed identities/state, nested associations, current-page semantics, default translations, invalid contracts, and custom Blade namespaces. Docs feature tests render the pages and exercise fixture state. Browser tests cover keyboard, touch, nested submenus, action forwarding without duplication, disabled actions, long-menu scrolling, server open state, Livewire morphs/removal/remounting/navigation, viewport edges, RTL, both themes, mobile layouts, and reduced motion. Every browser case checks JavaScript errors. Mobile screenshots were visually reviewed.

- Package `npm run build`: passed; unrelated generated country names were preserved.
- Docs `npm run build`: passed; the existing large-chunk advisory remains.
- Package `composer test`: **424 passed / 1,398 assertions**.
- Docs `composer test`: **156 passed / 885 assertions**.
- Full docs `composer test:browser -- --processes=2`: **138 passed / 1,534 assertions**.
- Docs focused feature tests after forwarding-note cleanup: **5 passed / 36 assertions**.
- Formatting, static analysis, Rector, architecture checks, and `git diff --check`: passed.

The integration application uses Laravel **13.31.0** and Livewire **4.4.4**. The existing CI compatibility matrix remains responsible for the advertised cross-version combinations; this phase did not run that remote matrix.

Accessibility references: [WAI breadcrumb pattern](https://www.w3.org/WAI/ARIA/apg/patterns/breadcrumb/), [menu button pattern](https://www.w3.org/WAI/ARIA/apg/patterns/menu-button/), and [menu keyboard behavior](https://www.w3.org/WAI/ARIA/apg/patterns/menubar/). Framework references: [Blade components](https://laravel.com/framework/docs/13.x/blade) and [Livewire actions](https://livewire.laravel.com/docs/4.x/actions).
