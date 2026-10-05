# Phase 21 — Table selection and external bulk actions

Table selection is opt-in through `bulkActionsView(): ?string`. Without it, no selection checkboxes or bulk dropdown are rendered. With it, the shared Checkbox handles row selection and the current-page header checkbox, including indeterminate state. The ellipsis dropdown precedes filters and search, and is disabled when no IDs are checked.

`selectedIds` is locked Livewire state containing the original integer/string keys. `toggleSelection()` resolves submitted IDs against the current page of the consumer's scoped query, normalizing browser strings to their original types. The header only changes that page. Selection persists across pagination, per-page changes, sorting, and refresh, and clears when search or registered filters change or reset. There is no select-all-results mode or automatic cleanup of missing records.

The consumer's bulk Blade view receives the exact checked IDs across pages as `$selectedIds`. It constructs its own buttons, event payloads, and links. Table never executes an action or creates its overlays. IDs received by an application handler still require validation, a scoped re-query, and fresh authorization.

Applications explicitly call `clearSelection()` / `removeSelection(array $ids)`, or dispatch `table:clear-selection.{id}` / `table:remove-selection.{id}` with `ids`. Refresh uses the existing `table:refresh.{id}` contract. Cancellation and failure preserve selection until the application chooses otherwise. Duplicate removal IDs are harmless; malformed removal values are rejected.

Loading covers rows and footer, and separately disables the bulk menu. Search and filters remain outside this blocking region. Both the reactive `loading` prop and `table:loading` event participate in the existing combined loading state, preventing a local response from clearing an external operation. Application-owned overlays remain usable.

Row and current-page checkbox requests are excluded from the local loading overlay. They still update selection on the server. Search, sorting, pagination, and external application loading retain the backdrop; an overlapping selection response never clears external loading.

The docs add Table → Bulk Actions after Overview and before Columns. The page separates demos, usage, Functions and variables, assets, selection, and application responsibilities. Functions and variables lists each selection method/property in its own table row and has a matching navigator entry. It demonstrates Dialog review with validation and explicit start/completion/failure, Alert reminder preparation, Slideover inspection, cancellation, scoped ID navigation, and explicit selection cleanup. No invoices change and no emails are sent. `/development/table` also contains two independent bulk hosts. The demo's permission boundary is its workspace scope; production applications must supply their own policies or gates.

Component labels live in `sirius::sirius-ui.table.*`: `bulk_actions`, `select_page`, `select_record` (with `:id`), and `selected_count` (with `:count`). The Table translations example documents overrides alongside existing strings.

The follow-up fixes on 2026-10-06 give the checkbox column a fixed 3rem width and share the remaining width equally among data/action columns. Content wraps inside stable columns, and narrow screens scroll within the Table region. Header and row checkbox properties are synchronized from server-rendered selection state after Livewire morphs. This fixes the header remaining checked when navigating from a fully selected page to an unselected page; partial selection and application cleanup also restore the correct checked/indeterminate state.

## Verification

Package regression coverage includes current-page selection, partial selection, cross-page persistence, search/filter resets, key types and deduplication, Collection sources, scoped/current-page rejection, locked state, explicit cleanup, translation forwarding, empty selection, and external loading. Docs tests cover all overlay payloads, normalization, validation, scope changes at completion, failure/cancellation, and navigation input. Browser cases exercise keyboard selection, actual indeterminate state, cross-page payloads, all three overlays, links, loading recovery, cleanup events, two instances, and mobile light/dark layouts.

The mandatory gates passed on 2026-10-06:

- Package `composer test`: 583 tests / 1,883 assertions, plus Pint, PHPStan, and Rector.
- Docs `composer test`: 188 tests / 1,089 assertions, plus Pint, PHPStan, and Rector.
- Full docs browser suite after the follow-up fixes: 204 tests / 2,349 assertions, including all eleven bulk browser cases.
- Both package and docs asset builds passed. Both Git whitespace checks passed.

The first full browser run reached Composer's 300-second process limit. The successful rerun used `COMPOSER_PROCESS_TIMEOUT=0` for that command only and completed in about 311 seconds. The latest documentation follow-up used the same command-level override with two browser processes and passed in about 191 seconds. Docs `composer test` also passed again (188 tests / 1,089 assertions). Browser evidence covers Chromium on Windows; other browser engines and operating systems were not tested in this phase. No dependencies, vendor sources, or operating-system settings were changed.
