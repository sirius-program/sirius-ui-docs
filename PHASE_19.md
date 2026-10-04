# Phase 19 — Toast

## Component contract

`<x-sirius::toast>` renders a notification before it is shown, following Alert's ID-based model. It accepts required escaped `text`, optional escaped `title`, optional Blade `icon`, and a named `footer` slot for application actions. Default content is rejected. The eight variants are primary, info (default), secondary, success, danger, warning, ghost, and outline. IDs default to five random characters; explicit IDs and `wire:key` provide stable Livewire identity.

`position` defaults to `top-end` and accepts all six top/bottom start/center/end positions. Start/end follow the component's LTR/RTL direction. The default uses `sirius-ui.toast_position`, configured with `env('SIRIUS_UI_TOAST_POSITION', 'top-end')`; an explicit component position takes precedence. `duration` defaults through `sirius-ui.toast_duration`, configured with `env('SIRIUS_UI_TOAST_DURATION', 5000)`. An explicit value takes precedence, including zero for a persistent notification. Durations must be integers from zero to 2147483647 milliseconds. `closable` defaults to true and controls the translated Close button and Escape dismissal while focus is inside the Toast.

Class, style, and accessible label attributes apply to the visible content; other attributes, Alpine events, and `wire:key` apply to the wrapper. Footer slot attributes apply to the footer; its controls can use their own Blade, Alpine, or Livewire actions. The Close label shares `sirius::sirius-ui.dialog.close` with Dialog, Alert, and Slideover, using the existing `sirius-ui-translations` publishing tag. Applications supply content and action labels.

## State, timing, and queue

Use `open`, Alpine `x-bind:data-open`, `data-sir-toast-open="id"`, or `toast:show` with `{ id }` to open a rendered Toast. Close with `data-sir-toast-close` or `toast:hide`. Livewire uses `$this->dispatch('toast:show', id: 'saved-toast')`, following its [event API](https://livewire.laravel.com/docs/4.x/events). There is no public host or payload-generated notification API; unknown IDs do nothing.

`toast:open` and `toast:close` bubble from the original wrapper with `{ id, reason }`. Close reasons include button, escape, api, state, timeout, overflow, removed, and navigation. Bound Alpine/Livewire state should follow close events; the docs show this synchronization. Local visibility remains separate from the server's declared state, so unrelated renders neither dismiss an event-opened Toast nor revive an expired one. Content and footer updates remain live while visible or queued.

At most three notifications are visible across all positions. Up to 20 more wait in FIFO order. Overflow closes the oldest waiting item, preserving visible notifications. Repeated queued requests do not duplicate entries; repeated visible requests restart the timer. Timers start only when shown, pause their remaining duration during hover, focus, or a hidden browser tab, and resume when all pause conditions end. Removal and navigation cancel pending work; navigation clears the stack.

## Accessibility and overlay integration

Toast uses the browser's [native Popover API](https://developer.mozilla.org/en-US/docs/Web/API/Popover_API/Using), requiring a browser that supports it. It does not lock scrolling, trap focus, or take focus when shown. Separate live regions announce title/text politely, with assertive danger announcements; footer actions are not part of the live region. Closing a focused Toast returns focus to its connected trigger when possible. Escape inside the Toast is consumed so it cannot also close an underlying modal.

Native modal inertness depends on DOM ancestry. An active Toast panel is temporarily placed inside the active Dialog or Slideover while its original wrapper remains in place. Alpine's existing teleport ancestry protocol preserves its original Alpine/Livewire context, including footer `wire:click`. Panels return home before Livewire morphs and are placed again afterward. This integration was checked against installed Livewire **4.4.4** and its bundled Alpine runtime; framework upgrades should retain the modal footer regression tests. Livewire lifecycle hooks follow its [JavaScript integration documentation](https://livewire.laravel.com/docs/4.x/javascript).

Entry uses a 160 ms fade and short slide; exit uses 140 ms. Reduced motion disables animation. Closing panels become inert immediately and release capacity once after exit. Three long notifications can scroll individually while fitting in the viewport.

## Documentation and verification

The public `/blade-components/toast` page provides Blade demos for all variants, all positions, timing, and persistent footer actions, each with exact-source copyable Usage. Attributes, Assets and interaction, State and events, Global configuration, and Translations follow the docs contract. Toast is alphabetically placed between Timeline and Tooltip in Presentation. Livewire, Alpine, queue, and modal fixtures remain at `/development/toast`, restricted to local/testing environments.

Package tests cover escaping, slots, forwarding, generated/explicit IDs, translations, variants, positions, position/duration config precedence, and invalid definitions. Browser tests exercise actual timers, pause/resume, FIFO limits/overflow, duplicate requests/IDs, queued content morphs, bound and event-based state, footer actions, removal/navigation, animations, reduced motion, mobile LTR/RTL themes, long content, and Toasts shown before or after Dialog/Slideover opening.

- Package and docs asset builds: passed. Unrelated generated phone country data was preserved.
- Package `composer test`: **506 passed / 1,640 assertions**.
- Docs `composer test`: **167 passed / 972 assertions**.
- Full docs `composer test:browser -- --processes=2`: **176 passed / 2,017 assertions**, including all 11 Toast browser cases.
- Formatting, static analysis, Rector, architecture checks, and `git diff --check`: passed.

Follow-up configuration update: `composer test` passed in the package (**507 tests / 1,644 assertions**) and docs (**167 tests / 972 assertions**). The two affected browser cases passed (**135 assertions**). Position tests cover the global default, explicit overrides, and invalid configuration; Toast now shares the Close translation with Dialog, Alert, and Slideover.

Mobile light/dark screenshots and Toasts above Dialog/Slideover were visually reviewed. The integration app uses Laravel **13.31.0** and Livewire **4.4.4**. Browser verification uses Chromium on Windows; other browsers/operating systems and the remote Laravel 12/13 compatibility matrix were not run locally. No dependency, vendor source, or operating-system configuration was changed.
