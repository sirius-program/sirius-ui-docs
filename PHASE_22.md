# Phase 22 — FullCalendar scheduling

Completed on 2026-10-06. Calendar is implemented as an extensible Livewire component backed by FullCalendar Standard. The native date-selection implementation was rolled back before this phase.

## Public contract

- Extend `Sirius\Ui\Livewire\Calendar`; implement `events(CarbonImmutable $start, CarbonImmutable $end, string $timezone): iterable`. Return serializable event arrays from application-scoped Eloquent or Collection sources. The package does not query business models.
- Props: `id`, `label`, `initial-view`, `initial-date`, `locale`, `timezone`, `first-day`, `selectable`, `editable`, and `options`. Explicit props override options, then defaults. IDs default to a random five-character string and persist for the mounted instance.
- The default view is `dayGridMonth`. `timeGridWeek`, `timeGridDay`, and `listWeek` are also bundled. Selection/editing default to false; date and event clicks remain available. Navigation fetches fresh data by default (`lazyFetching=false`).
- Every event has a unique string/integer ID and a string title. IDs become strings. Timed dates require an explicit ISO-8601 offset; all-day values remain date-only. Ends are exclusive and missing ends remain null. Visible-range requests are limited to 370 days. Application queries must include overlapping events.
- Simple daily/weekly recurring definitions are supported and default to non-editable. `recurringEditable()` is an explicit opt-in for applications with their own series/occurrence policy. Server-expanded instances can use independent IDs. RRule, Premium resource views, external drag sources, and external calendar integrations are excluded.
- `onDateClick()`, `onSelect()`, and `onEventClick()` receive validated contexts. Defaults dispatch `calendar:date-click`, `calendar:select`, and `calendar:event-click`. Contexts include calendar `id` and `timezone`; date actions add `start`, nullable `end`, and `allDay`; event actions add `eventId` and the reloaded server `record`. Clicks also include the clicked `occurrence` span, separately from a recurring definition. Event URLs require an application redirect hook.
- `onEventDrop()` / `onEventResize()` receive `old`, `new`, and `relatedIds` as well. They must explicitly return true after authorized persistence. False, unhandled mutations, stale values, or failed requests revert the provisional change. The application owns authorization, validation, conflicts, transactions, grouped edits, and its Dialog/Alert/Slideover.
- `refreshCalendar()` and `calendar:refresh.{id}` refetch while retaining the view/date. Protected `configure()` updates server-owned settings. Browser configuration and IDs cannot replace locked state. Current interaction ranges are validated independently of the last fetch snapshot, so an obsolete response does not define the active action scope.
- `SiriusCalendar.register(id, factory)` supplies local render/callback options and returns a registration cleanup function. `SiriusCalendar.get(id)` exposes the native API. Adapter-owned event sources, persistence/lifecycle callbacks, plugins, and Premium options are rejected, including nested view overrides. No code strings are evaluated.

## Locale, timezone, assets, and lifecycle

Explicit timezone wins over `sirius-ui.timezone -> app.timezone -> UTC`. Explicit locale wins over `sirius-ui.locale -> app.locale -> app.fallback_locale -> en`. Locale names normalize to FullCalendar codes; an unavailable regional code falls back to its bundled language. Unsupported languages/timezones are rejected. Package UI text comes from `sirius::sirius-ui.calendar.*`, independently of calendar date formatting.

FullCalendar v7 supports named timezones through its Temporal dependency. The tests prove 09:00 Asia/Jakarta is 02:00 UTC even in a New York browser. All-day dates are never converted to browser-local instants.

The adapter owns one widget instance, protects its DOM from morphing, ignores obsolete fetch results, provides inline loading/error/retry feedback, and cleans up scoped Livewire interceptors and instances on removal/navigation. FullCalendar v7 handles sizing when shown inside Tabs/Dialog/Slideover. A bundle-local ResizeObserver adapter delivers measurements on the next animation frame to avoid FullCalendar layout writes during the browser's observer delivery loop. It does not replace the global API, suppress errors, or edit vendor files.

## Dependencies and size

All assets/locales/theme CSS and required license notices are bundled internally; no CDN or API key is required. Resolved versions:

| Package | Version | License |
| --- | --- | --- |
| fullcalendar | 7.1.1 | MIT |
| @full-ui/headless-calendar | 7.1.1 | MIT |
| @fullcalendar/core | 7.1.1 | MIT |
| preact | 10.29.8 | MIT |
| temporal-polyfill | 1.0.5 | MIT |
| temporal-spec | 1.0.1 | Apache-2.0 |
| temporal-utils | 1.0.3 | MIT |

Measured against the pre-phase compiled assets: JavaScript adds 367,017 bytes (103,998 bytes gzip), and CSS adds 20,500 bytes (3,875 bytes gzip). This is approximately 101.6 KiB additional JavaScript gzip and 3.8 KiB CSS gzip. Notices are included in `dist/third-party-notices.txt` and the existing publishing contract.

Primary references: [release](https://github.com/fullcalendar/fullcalendar/releases/tag/v7.1.1), [Standard license](https://fullcalendar.io/license), [v7 installation](https://fullcalendar.io/docs/vanilla-js), [timezone](https://fullcalendar.io/docs/timeZone), [selection](https://fullcalendar.io/docs/select-callback), [drag acknowledgment](https://fullcalendar.io/docs/eventDrop), [resize](https://fullcalendar.io/docs/eventResize), and [simple recurrence](https://fullcalendar.io/docs/recurring-events).

## Documentation and verification

Public docs: `/livewire-components/calendar`. Development fixture: `/development/calendar`. The main team-scheduling example uses browser-session data and application-owned create/edit/delete forms. A separately tested Eloquent example maps the scoped docs invoice model; no production package model or migration is introduced. Demos, copyable usage, and attribute tables are separate files. Calendar appears before Table in navigation.

The public documentation is split into Overview, Actions, Events, and Options, following Table's submenu pattern. Overview keeps the base URL; the other pages use `/livewire-components/calendar/actions`, `/events`, and `/options`. Each has a separate demo, usage partial, attributes partial, and content navigator. Actions owns the interactive form demo, Events renders both Eloquent and Collection examples, and Options renders a localized work-week example. Translations remain on Overview, separate from Options' global configuration.

Loading now covers the entire calendar, including its toolbar, using Table's backdrop/spinner styles. Event fetches, date/event actions, and drag/resize saves make the calendar controls inert; successful saves keep the overlay through the subsequent event refresh. Errors unlock the controls and expose inline retry. Keyboard focus is restored only when the user has not moved to another control or application form. Browser tests hold actual request responses until explicitly released to verify overlay coverage, save-to-refresh loading, failure recovery, focus, and instance isolation.

Loading overlay verification: package `composer test` passed with 633 tests / 1,971 assertions; docs `composer test` passed with 200 tests / 1,168 assertions; the full browser gate passed with 224 tests / 2,514 assertions and no test warnings, including 20 Calendar browser cases. Both asset builds passed.

Calendar preserves its last height while fetching a different view and releases that height after rendering completes. More-event popups inherit the package theme through a dedicated class even when FullCalendar portals them outside the widget; their header and scrollable content stay separate. Monarch resize handles are contained within event bounds to prevent Sunday-ending events from creating hover scrollbars. Three regression cases reproduce and cover these failures.

Layout follow-up verification: both builds passed; package `composer test` passed with 633 tests / 1,971 assertions; docs `composer test` passed with 200 tests / 1,164 assertions, reflecting the concurrent docs refactor; the full browser gate passed with 227 tests / 2,549 assertions and no test warnings, including all 23 Calendar browser cases.

Documentation split verification: docs `composer test` passed with 200 tests / 1,168 assertions; full `composer test:browser -- --processes=2` passed with 221 tests / 2,468 assertions and no test warnings. The docs asset build passed. Browser coverage now includes navigation through all Calendar submenus, both event-source demos, option rendering, and cleanup of the previous page's widget instances. The package implementation was unchanged by this documentation update.

- Package `composer test`: passed, 633 tests / 1,971 assertions, including Pint, PHPStan max, Rector, and architecture checks.
- Docs `composer test`: passed, 195 tests / 1,140 assertions, including Pint, PHPStan, and Rector.
- Both asset builds: passed. Existing docs optional Fontaine/chunk-size build notices remain. The npm audit reports five pre-existing build-tool advisories; none concern the new Calendar dependencies.
- Full docs `composer test:browser -- --processes=2`: passed, 220 tests / 2,450 assertions, including all 16 Calendar browser cases. The final gate emitted no test warnings. One earlier run stalled during browser startup before workers launched; only its owned test process tree was stopped, and the fresh run completed normally.

Coverage includes source overlap/scope, Collection/Eloquent mapping, IDs and serialization, fallbacks/precedence, invalid payloads, unsupported configuration/recurrence, leap/year/DST/fractional dates, read-only and stale mutations, application acknowledgment, all-day validation, and application persistence/isolation. Browser coverage exercises real views, keyboard editing, date-range selection, drag/resize success/rejection, failed requests/retry, stale fetches, local render hooks, navigation/remount, RTL, hidden layouts, mobile themes, and title escaping.

Compatibility evidence is Chromium on Windows with Laravel 13.31.0 and Livewire 4.4.4 in docs. Other browser/OS and release matrices remain Phase 26 work. No `.env`, vendor source, Windows files, or external project files were edited.
