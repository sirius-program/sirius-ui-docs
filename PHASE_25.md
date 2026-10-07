# Phase 25 — Sirius UI documentation shell

The docs application now uses Sirius UI throughout. The website palette follows Sirius surfaces, borders, text, focus rings, and primary accents, with slate utilities for documentation panels and code examples in both themes.

## Migration

| Former Flux usage | Replacement |
| --- | --- |
| Sidebar groups and links | Sirius Menu/Accordion inside a semantic sidebar |
| Mobile sidebar toggle | Sirius Button and left Slideover |
| Breadcrumbs | Sirius Breadcrumb/item |
| Demo and fixture buttons | Sirius Button, preserving native form attributes and Livewire bindings |
| Appearance dropdown and settings choices | Sirius Dropdown, Field, and Radio |
| Logo, headings, main, and spacer | Native semantic HTML and app-local layout components |
| Unused persisted toast containers | Removed; existing Sirius Toast demos remain |

No new public package API was needed. Responsive shell composition and theme ownership are documented in the bundled skill setup reference. Documentation routes, menu groups, alphabetical ordering, Overview-first submenus, sample forms, copy controls, and development fixtures remain available.

The shell shares a navigation component between desktop and mobile, using separate ID prefixes. Active routes open their matching Accordion. Mobile navigation closes after Livewire navigation, Escape, or resizing to desktop, and releases focus/inert/scroll-lock state. The header and desktop sidebar stay fixed while page content scrolls.

Appearance initializes before styles load, supports Light/Dark/System, and synchronizes Radio choices after navigation. The application owns persistence under `sirius-docs.appearance`. The old `flux.appearance` key is read as a migration fallback; no Flux runtime is loaded. System changes and blocked storage are handled without breaking the page.

## Dependency and reference audit

Removed `livewire/flux` from Composer requirements and lock packages, Flux asset imports/directives, published Flux view overrides, and the obsolete Flux development skill/Boost selection. Livewire scripts still load once; no extra Alpine runtime was introduced.

Remaining Flux mentions are historical phase records, the documented legacy preference fallback and its regression test, generic optional-library advice in unrelated tooling skills, and upstream Blaze `conflict`/`require-dev` metadata in the lock file. They do not install or use Flux in this application.

Composer validation and a fresh installation into an empty project-local vendor directory passed. The normal docs installation also passed. The temporary installation remains in ignored `.phpunit.cache/phase25-install` because automatic approval review rejected cleanup with “blocked by policy”; its Sirius junction points to the source package and must not be traversed when cleaning it manually. Docs Vite build passed with the existing optional-fontaine and large-chunk notices.

Composer audit reported two existing advisories for `league/commonmark` 2.10.1: [raw-HTML filtering bypass](https://github.com/advisories/GHSA-97jj-33gv-5xf9) and [GFM table parsing denial of service](https://github.com/advisories/GHSA-3q6v-r5mr-hxv8). No unrelated dependency upgrade was made in this migration.

## Verification

- Package `composer test`: passed, 682 tests / 2,186 assertions, including lint, types, and refactoring.
- Docs `composer test`: passed, 218 tests / 1,312 assertions, including lint, types, and refactoring.
- Targeted browser checks: passed, 15 tests / 125 assertions, covering theme persistence, System appearance, blocked storage, preference migration, mobile dismissal/navigation/resize, native and Livewire form actions, copy fallback, and content navigation.
- Date/upload replay: passed, 11 tests / 132 assertions. The native-date scenario now waits for widget formatting after a native response before typing, avoiding a race with initialization. Real-server upload fixtures use a scoped 10-second browser timeout; their validation, cancellation, and upload assertions remain intact.
- Full docs browser gate: passed, 245 tests / 2,709 assertions, without warnings, using one worker (408 seconds). The first two-worker run had five date/upload/navigation failures; targeted replay identified the date initialization race and real-server timing limits. After the readiness/timeout adjustments, the final full suite passed with every scenario retained.
- Desktop light/dark and mobile dark screenshots were inspected. Existing browser tests retain their assertions with selectors updated for the new shell.

Phase 26 release validation and the previously deferred direct Claude Code evaluation remain separate work.

## Appearance dropdown follow-up

The header's backdrop blur created a containing block for the fixed Appearance panel, shifting viewport coordinates and adding horizontal overflow. The header now uses an opaque Sirius surface without backdrop-filter. The regression checks open Appearance after scrolling at 390px and 1440px, verify alignment and viewport bounds, switch themes, and dismiss it with Escape. This correction is limited to the docs shell.

CSS behavior reference: [MDN containing blocks](https://developer.mozilla.org/en-US/docs/Web/CSS/Guides/Display/Containing_block).

Follow-up verification passed: docs build; `composer test` with 218 tests / 1,312 assertions and lint/types/refactoring; six shell browser scenarios / 43 assertions; and the final full browser suite with 247 tests / 2,722 assertions, without warnings, using two workers (247 seconds).

The first follow-up full run passed 246 of 247 scenarios; a native currency POST test filled the display field before its canonical input had been enabled after a validation response. The test now waits for that observable readiness state, retaining its canonical payload and successful POST assertions. Its targeted replay passed all four Form browser scenarios (24 assertions).
