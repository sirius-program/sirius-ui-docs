# Phase 20 — Livewire Table core

## Consumer API and query boundaries

Extend `Sirius\Ui\Livewire\Table` and implement `query(): Builder` or `query(): Collection`, plus `columns(): array`. Optional `filters()`, `rowActionsView()`, and `pageSizes()` customize the component. `Column` and `Filter` definitions live in `Sirius\Ui\Table` and validate server-provided keys and fields. Consumer subclasses remain application-owned; the package does not register a concrete model-specific Table.

The query defines tenancy, permissions, selected fields, and initial ordering. For Builder sources, searchable fields are grouped in one OR constraint; filter callbacks are grouped so their OR conditions cannot escape the base query. Count and page queries stay in the database. Keep the primary key available and eager-load relationships used by custom views. Client sort keys resolve only through sortable definitions. Directions, filter values, search lengths, and page sizes are validated. The record key provides a deterministic ordering tie-breaker.

Collection sources run search, filtering, compound sorting, and pagination in memory. They may contain models, arrays, or objects, including records from an Eloquent Collection. Collection search uses case-insensitive literal text matching on searchable fields; dot paths address nested values. Filter callbacks receive the Collection and validated string value and must return the filtered Collection. Models use their primary key; other records require a unique, nonempty string or integer `id`, with `recordKey()` available for another key. Source order returns when all sorting is removed. Original records reach formatters and cell/action views unchanged. This path is for already-loaded datasets, not a replacement for database pagination on large tables.

State is isolated per instance and is not synchronized with the URL. Search, filters, sorting, and page-size changes reset to page one. Explicit refresh retains those settings and clamps pages after records disappear. Dispatch `table:refresh.{tableId}` or call `refreshTable()` after an application change. IDs default to five random characters; specify an ID for stable identity and targeted events.

Sorting uses an ordered `sorts` map of column keys to `asc`/`desc`. Ordinary clicks keep one column; Shift-click adds or cycles a column while preserving the others. Each column cycles ascending → descending → removed. Removing the last sort restores the consumer query's default order. Visible priority numbers and translated direction/priority labels describe compound sorting; `aria-sort` identifies the primary column. All keys and directions remain server-validated.

## Actions stay outside Table

An optional row-action Blade view receives the scoped `$record`. Default cells escape their values; custom cell views receive `$record` and `$column`. Full models, hidden attributes, and relationships are not automatically serialized. Consumer markup chooses fields for event payloads and links.

The application separately renders Dialog, Alert, and Slideover, opens them using the shared `dialog:show` event, and owns handlers, fresh scoped queries/authorization, validation, feedback, transactions, and exports. Table has no action dispatcher, handler registry, automatic confirmation, built-in mutation/export, or arbitrary toolbar-action view.

The invoice demo passes only IDs, re-queries the workspace scope, validates a review note, provides feedback, and explicitly refreshes. Sample invoices use an isolated in-memory SQLite connection. It writes no permanent database records. Selection, `$selectedIds`, and the bulk ellipsis dropdown remain Phase 21 work.

## Toolbar, footer, and loading

The filter icon opens a Dropdown containing all registered filters and Reset filters. Search fills the remaining width; tables without filters omit the dropdown. Dropdown adds `content-role="dialog"` for ordinary form controls, retaining menu semantics by default. Table filters close only by outside click or filter-button activation; native Tab navigation stays available.

Cells have row and column borders using shared theme tokens. The footer places count/range/displayed information left, page size centrally, and bounded numeric pagination right. First/last pages and ellipses appear for larger page counts. On mobile the footer stacks and rows scroll horizontally. `record-label` is used literally, defaults to the translated `data`, and appears in count and empty messages through `:label`.

Back/Next flank the numeric pages and are disabled at the boundaries, including empty results. Actions, Search, Reset filters, Back/Next, and sorting hints/announcements resolve through the Table translation group. Column/filter labels and row-action text are supplied by consumer code; applications translate those labels themselves. The docs translation example exposes the entire Table group.

Local requests and explicit external loading share one backdrop over the rows and footer. Covered content becomes inert and the Table reports `aria-busy`; toolbar search and filters, other Tables, and separately rendered overlays remain usable. Focus/caret restoration avoids taking focus from a modal. For external processing, pass reactive `loading` or dispatch `table:loading` with `{ id, loading }`; application code must clear it on completion, failure, and cancellation. The demo uses a counted Livewire message interceptor, rather than monitoring handlers inside Table.

The local `wire:loading` directive lives on the content wrapper. Putting it on the Livewire root allowed root metadata directives to enter Livewire 4's inferred target list and prevented request loading. Keeping it on the wrapper uses the framework's request counter without duplicating its lifecycle.

Event-based external loading is stored in the Table adapter's client state, so a local response cannot remove it through an HTML attribute morph. Local and external sources must both finish before interactions resume.

Event-opened overlays now preserve their client state when Livewire renders unchanged server `open` markup. A genuine server state change still applies. This prevents a failed form validation from closing an event-opened Dialog. Existing overlay regressions remain part of the full browser gate.

## Documentation and verification

Table docs have separate Overview, Query, Columns, Filters, and Row Actions pages, each with demos, copyable examples, attributes, and applicable asset guidance. Overview contains initiation guidance, links to the other topics, and Translations. The sidebar places Overview first, followed by the other topics alphabetically under Table within Livewire Components. Shared field contract is omitted because Table is not a form field. UI translations use `sirius::sirius-ui.table.*`; publish overrides under `lang/vendor/sirius/{locale}/sirius-ui.php`.

Package tests cover query scoping, grouped filters, malicious state, reset and refresh, stable paging, bounded page numbers, translations, escaping, row context, optional views, and loading. Docs tests cover scoped sample queries, overlay payloads/validation, private-field exclusion, navigation, and two instances. Five browser cases cover actual interactions, whole-Table blocking, external overlays, cancellation/navigation recovery, mobile/themes, and no JavaScript errors.

Package `composer test` passed with **530 tests / 1,702 assertions**. Docs `composer test` passed with **172 tests / 999 assertions**. Both include formatting, static analysis, and Rector checks. Both asset builds passed; existing docs build notices remain for optional Fontaine font fallbacks and the large bundled JavaScript chunk. No dependency was added to silence these unrelated notices.

Full docs `composer test:browser -- --processes=2` passed with **181 tests / 2,071 assertions**, including all five Table browser cases and their 54 assertions. Mobile rendering was visually reviewed. `git diff --check` passed in both projects.

The first full browser run exposed an existing Toast navigation regression using the removed `draft-toast` demo ID. Updating the selector to the current `report-toast` preserved the navigation/event assertion. An intermediate concurrent feature-test invocation removed Playwright's shared temporary server file; the final gate ran browser tests separately and passed. Avoid concurrent Pest invocations in the docs project.

No dependency, vendor source, or operating-system configuration is changed. Local browser verification uses Chromium on Windows; other browser engines and the remote Laravel compatibility matrix are outside this run.

## Sorting and pagination follow-up

Back/Next, three-state sorting, and Shift-click compound sorting passed the complete gate: package **535 tests / 1,727 assertions**, docs **172 tests / 999 assertions**, and browser **182 tests / 2,088 assertions**. Focused Table coverage passed **25 package tests / 80 assertions** and **6 browser cases / 71 assertions**. Tests include real ordered query results, malformed sort state, priority preservation/removal, ordinary-click exclusivity, disabled pagination boundaries, and translated controls. Both asset builds and formatting/static-analysis/refactoring checks passed.

## Filter widgets and column formatting follow-up

Global search and text filters use native `type="search"` inputs. Select filters use the package Select, converting their value/label map into its option records. An optional `searchUrl` enables remote search, option pagination, and selected-label resolution using the existing Select contract. Local selections remain allowlisted; remote values are bounded strings applied only through the consumer's scoped callback. The docs endpoint applies the same workspace scope to searches and selected-label resolution.

Date, time, and datetime filters use Datetime Picker and its global locale/timezone settings. Query callbacks receive canonical `Y-m-d`, `H:i`, or `Y-m-d H:i:s` strings. Datetimes represent local wall time; the application converts them when its database stores UTC. Invalid dates, time bounds, malformed strings, and null bytes are rejected before callbacks run. Cleared Select values are treated as empty, even when the filter has a nonempty default; Reset filters restores that default.

Calendars inside filter dropdowns stay within the dropdown DOM and use viewport positioning. Keyboard focus skips hidden native widget controls. Escape closes the active Select/calendar while preserving the filter dropdown. Datetime bindings use `wire:model.live.change`, which sends completed changes in Livewire 4 without requesting on every keystroke.

`Column::format` receives the raw value and record to format a displayed cell without another view. Ordinary strings are escaped, an explicit cell view takes precedence, and search/sorting still use database fields. The invoice amount demo now uses a closure; its status badge retains a custom view.

The final gate passed: package **553 tests / 1,767 assertions**, docs **173 tests / 1,013 assertions**, and full browser suite **185 tests / 2,121 assertions**. Formatting, static analysis, refactoring checks, and both asset builds passed. Regression coverage includes remote search/pagination/scoped label resolution, all temporal filters, clear/reset, escaped formatting with record context, view precedence, keyboard focus/Escape, and validation independent of the server's daylight-saving timezone. The first parallel browser run hit Chromium `ERR_NO_BUFFER_SPACE`; the final full run used one process and passed without operating-system changes.

## Calendar ownership follow-up

Dropdown click and focus handling recognizes a calendar's input owner through `data-sir-date-calendar`. Calendars rendered outside the dropdown DOM are treated as part of that dropdown, so choosing a date does not dismiss the filters. Clicking elsewhere still closes the dropdown. The regression test moves the widget calendar to a body portal and checks the entered value, server-side filter results, dropdown state, and outside-click behavior; it failed before the fix and passed afterward.

Both asset builds and `composer test` gates passed: package **553 tests / 1,767 assertions**, docs **173 tests / 1,013 assertions**. The full browser suite passed with **186 tests / 2,127 assertions** using one process. Manual verification on the local docs page confirmed that the selected date reaches the Table query and the filter dropdown remains open.

## Date selection focus follow-up

Calendar interaction no longer commits a blur/change while focus moves into the widget or the Table becomes inert. Date selection focuses its display input before publishing the canonical change. Table restores the saved focus on the next animation frame, after Livewire morphing and dropdown synchronization have revealed the filter panel again. The regression test uses a held pointer click and checks exactly one canonical change, query results, the open dropdown, and the active input after loading; the focus assertion failed before this fix. Local browser verification confirmed the focus returns to the date input after the response.

Package and docs builds passed. Both `composer test` gates passed with **553 tests / 1,767 assertions** in the package and **173 tests / 1,013 assertions** in docs. Focused Table/Datetime Picker/navigation coverage passed **26 browser tests / 270 assertions**; the full browser suite passed **187 tests / 2,133 assertions** using one process. `git diff --check` passed in both projects.

## Persistent filter dropdown follow-up

Table's filter dropdown now uses click dismissal. Focus changes, Tab navigation, and Livewire updates leave the panel open. Clicking outside or activating the filter button closes it; Enter/Space activation of the button also works. Escape closes an active nested Select or calendar without dismissing the Table filters. Ordinary dropdowns retain their existing focus-out and keyboard dismissal behavior. Browser coverage checks focus moving outside without a click, filter updates, nested Escape handling, trigger activation, outside clicks, and ordinary dropdown behavior. The keyboard focus test follows the updated demo filter order, which now starts with Customer.

Both builds and `composer test` gates passed: package **553 tests / 1,767 assertions**, docs **173 tests / 1,013 assertions**, with formatting, static analysis, and refactoring checks. Focused Table/navigation coverage passed **22 browser tests / 217 assertions**. The full browser suite passed **188 tests / 2,146 assertions** using one process. `git diff --check` passed in both projects.

## Loading scope follow-up

Toolbar search and filters now sit outside the results region. The loading backdrop and inert state cover only rows, actions, sorting, and footer pagination/page size. A positioned, isolated results region keeps the backdrop below the toolbar and filter widgets. The same scope applies to local requests, parent loading, and event-driven external loading; overlapping sources still keep results blocked until all finish. Tests cover rendered parent loading, opening a calendar during a held request, choosing a date/resetting filters/searching during external loading, continued blocking of row actions and pagination, and recovery when loading clears.

Both builds and `composer test` gates passed: package **553 tests / 1,771 assertions**, docs **173 tests / 1,013 assertions**, with formatting, static analysis, and refactoring checks. The full browser suite passed **189 tests / 2,163 assertions** using one process. `git diff --check` passed in both projects.

## Select and filter width follow-up

Select option lists now anchor to the whole field shell, including suffix buttons. Showing Clear no longer narrows the list. Table's filter panel has a fixed width, 50 px wider than the previous minimum, and clamps to the viewport on small screens. Filter grid tracks allow controls to shrink within that width instead of expanding with their contents. Browser coverage checks desktop and 320 px screens through long search text, local/remote selections, Clear, and Reset filters.

Both asset builds and `composer test` gates passed: package **553 tests / 1,771 assertions**, docs **173 tests / 1,013 assertions**, including formatting, static analysis, and refactoring checks. Focused Table/Select/Phone coverage passed **29 browser tests / 296 assertions**. The full browser suite passed **191 tests / 2,195 assertions** using one process. `git diff --check` passed in both projects.

The Select single-line follow-up also verifies cursor alignment beside a resolved remote filter value. The complete browser gate now passes **192 tests / 2,209 assertions**; package and docs `composer test` counts remain unchanged. See [Phase 6](PHASE_6.md) for the Select behavior and regression details.

## Collection source follow-up

`query()` now accepts an Eloquent Builder or a Collection. Collections support models, arrays, and objects with the same Table state, views, row actions, and pagination controls. Search, filters, and compound sorting run in memory; callbacks return the filtered Collection rather than modifying a Builder. Stable unique IDs are validated before processing, and `recordKey()` supports another identifier. Removing all sorts restores source order. Invalid filter state and callbacks are rejected before rendering results.

The existing docs page adds a copyable Collection source and filter example; no new public demo or route was added. Existing invoice cell/action views read values with `data_get()` so both models and arrays work. Package regression coverage includes case-insensitive nested-field search, filters, escaped formatter output, row-action context, paging/reset/refresh, compound sorting and ties, malformed state, invalid/duplicate IDs, custom keys, Eloquent Collections, and invalid callback returns without querying a database.

Both `composer test` gates passed: package **569 tests / 1,841 assertions**, docs **174 tests / 1,017 assertions**, including formatting, static analysis, and refactoring checks. This follow-up changes PHP and Blade only; it adds no dependency or frontend asset code.

The complete docs browser suite passed with **192 tests / 2,209 assertions** using one process. `git diff --check` passed in both projects.

## Filter API and Table documentation submenus

The extension method is now `filters()`. All consumer examples and package fixtures use the new name; the public `$filters` property continues to hold selected values. Eloquent and Collection filter behavior, validation, and reset semantics remain covered by the existing package tests.

Table docs are grouped into five routes: Overview at `/livewire-components/table`, plus `/query`, `/columns`, `/filters`, and `/row-actions` under that path. Overview explains class initialization and links to each topic. Query has separate Eloquent and Collection demos; Columns demonstrates a qualified search/sort field, record-aware formatter, and custom status cell; Filters includes text, local/remote Select, date, time, and datetime; Row Actions keeps application-owned handlers, Dialog/Alert/Slideover, and navigation links. Every topic has its own demo, copyable Usage, Attributes, and applicable asset guidance. Examples, demo markup, and attribute tables remain separate files.

Overview stays first and the other sidebar items stay alphabetical, the Table group expands for its child routes, and breadcrumbs identify the active topic. Feature tests exercise all new routes and their demo behavior. Browser coverage navigates the submenus with `wire:navigate`, checks independent Eloquent/Collection state, and uses the new Filters and Row Actions routes for their existing regressions. Development integration retains the complete two-instance fixture.

Package `composer test` passed with **569 tests / 1,841 assertions** and docs `composer test` with **181 tests / 1,053 assertions**, including formatting, static analysis, and refactoring checks. The docs asset build passed; no dependency was added. Focused Table browser coverage passed **16 tests / 194 assertions**. Mobile rendering was visually reviewed.

The full docs browser suite passed with **193 tests / 2,223 assertions** using one process. `git diff --check` passed in both projects.
