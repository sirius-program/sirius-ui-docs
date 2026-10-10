# Implementation Plan — Components and Documentation Refresh

Created: 2026-10-09. Baseline: docs commit `fdbdc78` (`chore: clean up docs`).

Plan approved: 2026-10-09.

This is a new plan. Deleted implementation/phase reports will not be restored. The existing 0.1.0 components and the user's documentation cleanup are the starting point. Feature implementation starts only after the user requests a phase.

## Progress

**7 of 8 phases complete.** Phases 0–6 are complete. Phase 7 has not started.

Check a task only after its work is done and any required verification passes. Check a phase in the completion list only when all its work and acceptance criteria are complete. Approval of this plan does not mark implementation tasks complete. Update this summary and the recorded evidence as work progresses.

## Confirmed decisions

- Add **Code** and **Link** to the package. Rendered docs anchors use Link, not Code.
- Code supports inline and block modes. Block mode preserves existing highlighting, whitespace, and clipboard behavior in `x-docs-code`.
- Both components support `primary`, `info`, `secondary`, `success`, `danger`, and `warning`. Code defaults to `info`; Link defaults to `primary` with an underline. Font size follows its surrounding content.
- Use **Menu.category** and **Menu.item** with a named submenu slot to compose titled/icon-bearing sections and stateful submenus. Existing Menu/Menu.item APIs remain compatible. Native list markup remains inside package components, not in `docs-navigation.blade.php`.
- Keep the existing plural **examples** directories. Add corresponding locations for Getting Started, Other, and shared snippet rendering.
- Changelog is one page with **Package** and **Documentation** tabs. Read the two existing Markdown files directly; do not invent or duplicate release entries.
- Welcome becomes a separate landing page **without the docs sidebar**, with a short introduction and lightweight interactive demos.
- Fix the labeled-icon accessibility defect before documenting it as supported behavior. Document verified behavior and limitations, not WCAG certification.

## Boundaries

- Preserve the current menu order and grouping choices; do not restore alphabetical ordering. Existing component submenus that have Overview keep it first.
- Preserve Introduction, Installation, and AI Agent Skill and the current Keyword table heading. Do not reintroduce mandatory Shared field contract or Asset/interaction sections.
- Do not change native anchors inside other package components, including Button, Menu/Dropdown, Breadcrumb, widgets, and vendor code.
- Migrate rendered docs markup, not quoted snippets, nowdocs, escaped native HTML examples, or JavaScript source strings. Actual demo markup can use the new components where appropriate.
- Code/Link CSS is scoped to their classes. Do not apply global selectors that restyle anchors/code inside unrelated package components.
- Keep the existing syntax highlighter and Copy implementation. Code does not add a second highlighter, copy button, or external library.
- Keep package namespaces configurable and use internal aliases for package composition. New UI strings, if any, follow the existing translation contract.
- No new dependency is presently needed. Use installed Blade Icons and CommonMark APIs. Additional icon packs are consumer installation examples, not new package requirements.
- Do not read/edit the user's environment files, patch vendor source, or alter Windows configuration. Keep evaluation installations and generated audit artifacts inside ignored project caches.
- Changelog rendering uses fixed local paths and safe Markdown options; never compile authored Markdown or its generated HTML as a Blade template.
- Do not publish, tag, or deploy as part of these phases. Existing deferred direct Claude Code evaluation stays deferred.

## Phase 0 — Baseline and obsolete rules

### Work

- [x] Inspect the last docs commit and remove obsolete rule clauses rather than replacing them with a new ordering/template policy.
- [x] Remove alphabetical ordering and preservation of the old menu groups, mandatory Shared field contract/Asset and interaction sections, and the outdated prescribed table header.
- [x] Retain applicable rules for examples/demos, concise descriptions, individual keyword rows, native form demos, namespaces/translations, and active navigation state.
- [x] Update stale navigation tests to check the active link and absence of hidden/collapsed ancestors; Getting Started is currently an ordinary category, not an accordion.
- [x] Preserve the completed Installation page and its literal, escaped asset examples.
- [x] Review the current project baseline and identify existing failures. The recorded project gate below establishes the starting point.
- [x] Review the browser baseline and resolve existing failures before starting feature work; do not weaken assertions or recreate UI intentionally removed by the user.
- [x] Remove README/release-checklist links and claims that depend on deleted historical phase documents. Keep current setup/API information and real verification evidence. Link to this new plan.

### Acceptance

- [x] No alphabetical ordering rule remains.
- [x] Current Introduction/Installation/AI pages have correct routes, breadcrumbs, active links, and unique IDs.
- [x] Installation snippets render as code and do not load extra scripts/styles.
- [x] Baseline failures, if any, have an identified cause and are resolved before Phase 1.

### Baseline evidence recorded during planning

- Obsolete rule clauses have been removed. The focused shell suite passes 8 tests / 41 assertions after adapting active-link checks and adding Introduction.
- The full docs gate passes formatting, static analysis, and refactoring, but its current feature run is not green: 221 scenarios, 208 passed, 12 failed, and one error.
- Failures include tests still requesting the old redirecting Getting Started route, tests requiring asset sections intentionally removed in the cleanup, and development fixture responses that now return errors. The Field fixture cannot find its `livewire.examples.field-example` view, and the navigation fixture references the unregistered `blade-components.navigation` breadcrumb. Inspect fixture/breadcrumb failures separately from outdated UI assertions; do not dismiss an HTTP 500 as a wording change.
- These were the Phase 0 failures identified during planning. The verified outcome after repairs is recorded below; no new component implementation has started.

### Verification after baseline repairs — 2026-10-09

- Restored the existing Field Livewire view/demo used by the development fixture and corrected Navigation integration's breadcrumb parent to Layout.
- Updated stale route, section, and navigation assumptions while retaining validation, reset, focus, escaping, and interaction assertions. Added section-link checks; repaired Introduction's missing target and removed obsolete Table Query targets.
- Removed deleted phase-report references from README/release checklist. Kept the 2026-10-08 audit as dated historical evidence and linked the current plan.
- Browser tests now use two workers, matching CI, with Composer's process timeout disabled for this script. Native Form tests use single Playwright clicks for submissions, and the Chart overlay test waits for Dialog closure before opening Slideover.
- Real-server upload tests allow 20 seconds for queued uploads. The multiple-file case explicitly waits for both completion statuses and verifies two Livewire files, then one after removal, rather than relying on a positional FilePond state selector.
- `composer test` passes: 221 tests / 1,366 assertions, plus formatting, static analysis, and refactoring checks. Composer metadata and whitespace checks pass.
- `composer test:browser` passes in local Windows Chromium with two workers: 251 tests / 2,748 assertions, without warnings, in 299 seconds. The entire suite ran after the final repairs.
- Final gate logs are retained in ignored `.phpunit.cache/phase-0-project-gate.log` and `.phpunit.cache/phase-0-browser-baseline.log`. No vendor source, environment files, or Windows settings were edited. Remote CI and the deferred direct Claude Code evaluation are not claimed.

## Phase 1 — Code and Link

### Work

- [x] Add public `<x-sirius::code>` and `<x-sirius::link>` Blade components and scoped, theme-aware styles.
- [x] Code renders a native `code` element. Use `block` to opt out of inline background/padding/tone treatment within a `pre`; preserve the supplied text and line breaks.
- [x] Code defaults to the `info` tone. Block mode inherits its enclosing code-block/highlighter colors and spacing.
- [x] Link renders a native `a` element, defaults to the primary text tone and an underline, and has a visible keyboard focus treatment.
- [x] Forward class, data/ARIA, native link attributes, Alpine directives, and supported Livewire attributes. Preserve fragment navigation, downloads, and external target/rel behavior. Reject executable URL schemes/control characters consistently with existing navigation URL validation.
- [x] Support the six confirmed tones; do not add syntax highlighting, copy controls, routing helpers, loading state, or an action engine.
- [x] Add dedicated Code and Link documentation with Blade demos, copyable examples, separate keyword rows, and all supported tones. Do not add Livewire public demos for these presentation components.
- [x] Update bundled skill references and regenerate assets after the public APIs are final.

### Acceptance

- [x] Text/source escaping, slot content, attributes, safe URLs, focus treatment, configurable namespaces, and light/dark styles work.
- [x] Inline and block Code are visually distinct in the intended way; block source copies byte-for-byte as before.
- [x] Styles do not affect existing package-owned native anchors or unrelated code elements.

### Verification — 2026-10-09

- Added Code (`variant=info`, `block=false`, `text=null`) and Link (`variant=primary`), plus namespace-independent internal aliases. Code's optional escaped `text` preserves source whitespace; authored token markup remains available through its slot.
- Added scoped light/dark/forced-colors CSS using the existing six semantic tones. Link preserves native attributes and checks static destinations using the existing navigation URL policy; application code owns dynamic href validation.
- Added separate Code/Link pages, demo/example/attribute partials, routes, breadcrumbs, active navigation, and Introduction entries. Existing package-owned anchors and the docs highlighter/Copy renderer remain unchanged; broad markup migration belongs to Phase 3.
- Updated package/docs README and bundled skill references. Package assets were built before docs assets; both builds pass, and the compiled CSS is refreshed.
- Package quality gate passes: 769 tests / 2,443 assertions. Docs quality gate passes: 224 tests / 1,401 assertions. Both include formatting, static analysis, and refactoring checks.
- Full local Chromium browser gate passes with two workers: 254 tests / 2,770 assertions, without warnings, in 208 seconds. Coverage includes both themes, native styling isolation, whitespace, exact Copy, navigation/download attributes, and keyboard focus.
- Gate/build logs are retained in each project's ignored `.phpunit.cache/phase-1-*.log`. No dependency changes, vendor-source edits, Windows changes, release publication, or remote CI execution are claimed.

## Phase 2 — Composable Menu categories and submenu items

### Public composition

```blade
<x-sirius::menu label="Documentation">
    <x-sirius::menu.category title="Getting Started">
        <x-sirius::menu.item icon="heroicon-s-rocket-launch" :link="route('started.introduction')">
            Introduction
        </x-sirius::menu.item>
    </x-sirius::menu.category>

    <x-sirius::menu.category title="Blade Components">
        <x-sirius::menu.item name="Form Control" icon="heroicon-o-pencil-square" :open="true">
            <x-slot:submenu>
                <x-sirius::menu.item :link="route('blade-components.input')">Input</x-sirius::menu.item>
            </x-slot:submenu>
        </x-sirius::menu.item>
    </x-sirius::menu.category>
</x-sirius::menu>
```

### Work

- [x] `menu.category` owns its section/list markup and accepts a title and optional icon.
- [x] `menu.item` owns its submenu/disclosure markup and supports `open`, `transition`, and stable ID directly on submenus. Keep button/list markup and existing keyboard navigation.
- [x] Use the shared navigation submenu controller for declared state, opening transitions and immediate closing, ARIA, reduced motion, and focus/state synchronization. Keep the standalone Accordion component independent.
- [x] Retain Menu.item's current link/action/submenu APIs and navigation semantics. Preserve Dropdown-specific action menu semantics and positioning.
- [x] Refactor docs navigation to component composition only: no handwritten `ul`/`li`. Preserve user ordering, routes, icons, desktop/mobile prefixes, active state, and mobile close/focus restoration.
- [x] Update Menu demos, examples, keyword documentation, and skill references.

### Acceptance

- [x] Existing Menu/Dropdown/Accordion usage still works with default and custom namespaces.
- [x] Generated HTML lists are valid. IDs and associations stay unique across desktop/mobile rendering and Livewire updates.
- [x] All current menu links remain available; submenu items remain keyboard accessible.

### Recorded evidence

- Added Menu.category and stateful Menu.item submenus. Updated per the user decision on 2026-10-10: remove the separate group and accordion mode APIs. Use the existing button/list submenu structure with open/transition, trigger attributes and Alpine state binding; preserve custom namespaces.
- Docs navigation now contains only Menu components. All 52 existing links, their order, routes, icons, desktop/mobile IDs, and active-state expressions remain intact. Added a Blade composition demo and a development Livewire lifecycle fixture.
- Package quality gate passes: 788 tests / 2,498 assertions; lint, PHPStan, and Rector pass. Docs quality gate passes: 225 tests / 1,483 assertions, with the same checks passing.
- Package and docs production builds pass. Full local Chromium browser gate passes with two workers: 259 tests / 2,818 assertions, without warnings, in 218 seconds. Coverage includes initial submenu state, sibling collapse, keyboard navigation, focus restoration, opening transitions and immediate closing, rapid reopening, Alpine binding, reduced motion, disabled activation, Livewire updates/removal, sidebar/mobile navigation, and existing Dropdown interactions. Inspected the mobile dark-theme demo screenshot.
- Logs are retained in each project's ignored `.phpunit.cache/menu-*.log`. No dependency changes, vendor-source edits, system changes, publication, or remote CI execution were performed.

## Phase 3 — Docs markup, examples, Introduction, and Icons

### Work

- [x] Replace docs-owned rendered inline `code` with Code and anchors with Link, preserving all existing attributes and text.
- [x] Make the reusable docs code-block renderer use block Code without changing its source escaping, highlighting, clipboard text, or error feedback.
- [x] Move every `x-docs-code` invocation into an `examples` partial. Include the helper invocation currently inside `docs-example` in this audit; the public wrapper can delegate to a shared example partial.
- [x] Keep `blade-components/examples` and `livewire-components/examples`. Add `getting-started/examples`, `other/examples`, and shared `resources/views/examples` only where needed. Pass snippet data explicitly through `@include`.
- [x] Pages include snippet partials; shared prose remains literal page content, following the existing wording rule. Avoid copying large variable definitions across pages.
- [x] Complete Introduction with a concise overview, Blade versus Livewire use, bundled widgets/themes, and application-owned validation/persistence/uploads. Keep the component directory on Introduction.
- [x] Expand the existing Icon page: only Heroicons ships by default; explain outline `heroicon-o-*` (24px), solid `heroicon-s-*` (24px), mini `heroicon-m-*` (20px), and micro `heroicon-c-*` (16px).
- [x] Distinguish source icon family from Sirius `size`. Explain installing a separately chosen Blade Icons pack, its registered prefix, custom sets, and icon-cache refresh. Link official pack documentation; do not imply every Blade Icons catalog set is preinstalled.

### Acceptance

- [x] Rendered docs code/link markup consistently uses the new components; example strings/native HTML demonstrations remain correct.
- [x] Page templates and helper components have no direct `x-docs-code` invocation outside an examples partial.
- [x] Syntax highlighting and exact Copy behavior survive ordinary navigation, Livewire navigation, and clipboard denial.
- [x] Introduction retains all current component links, and Icon documentation matches installed support.

### Markup migration verification — 2026-10-09

- Converted rendered docs-owned anchors/code in 62 templates to Link/Code, including supporting layouts, development pages, and rendered demos. Package-owned native tags and literal source examples remain untouched.
- Preserved every existing pre opening/closing tag and its attributes, as explicitly requested. The shared docs-code renderer replaces only its inner code element with Code block mode; highlighting and Copy retain their original implementation.
- No raw a/code elements remain in docs Blade templates. A renderer regression confirms exact leading/trailing whitespace and safely escaped literal anchor/code examples.
- Docs build and quality gate pass: 225 tests / 1,405 assertions, including formatting, static analysis, and refactoring checks. Full local Chromium browser gate passes: 254 tests / 2,770 assertions, without warnings, in 211 seconds.
- Evidence is retained in ignored `.phpunit.cache/docs-tags-*.log`. Examples extraction, Introduction expansion, and Icon guidance remain pending; this does not complete Phase 3.

### Examples and reference verification — 2026-10-10

- Extracted 24 page-level code snippets plus the shared docs-example renderer into examples partials. All x-docs-code invocations now live in an examples directory. Existing pre tags, highlighting, clipboard behavior, and literal source examples remain intact.
- Expanded Introduction while retaining every current component-directory destination. Expanded Icon with outline/solid/mini/micro demos, source versus display dimensions, optional pack installation, custom sets, and cache instructions verified against installed packages and official sources. No optional icon dependency was installed.
- Updated README and the bundled presentation skill reference. Inspected mobile light/dark screenshots; section navigation, viewport containment, exact copied snippets, and Livewire navigation are covered by passing tests.
- Moved stale Menu regression scenarios into the existing development Navigation page after the user compacted its public demo. Preserved the public demo and every existing test. A reproducible Livewire morph regression also exposed loss of inert on a closed submenu; Menu now observes inert changes and updates it only when needed, avoiding observer loops. The regression fails before the fix and passes after it, including unrelated Livewire updates.
- Package production build and quality gate pass: 788 tests / 2,498 assertions, with formatting, PHPStan, and Rector passing. Docs production build and quality gate pass: 229 tests / 1,554 assertions, with the same checks passing.
- Full local Chromium browser gate passes with two workers: 262 tests / 2,841 assertions, without warnings, in 217 seconds. Logs are retained in each project's ignored .phpunit.cache/phase-3-*.log. The build retains existing non-fatal optional-font and chunk-size notices.
- Phase 4 labeled-icon accessibility work remains pending. No vendor-source edits, dependency changes, system changes, publication, or remote CI execution were performed.

## Phase 4 — Accessibility, License, and Changelog

### Accessibility

- [x] Fix labeled Icon SVG output so `role="img"`/its accessible name are not negated by inherited `aria-hidden="true"`. Preserve decorative icons and avoid duplicate/conflicting effective attributes. Do not modify vendor SVG files.
- [x] Add a Getting Started Accessibility page covering verified labels/helpers/errors, keyboard/focus, overlay focus restoration, native disclosures, tabs, sliders, tooltip/popover distinctions, announcements, reduced motion, and forced-colors behavior.
- [x] Explain consumer responsibilities: useful names, sensible color overrides, validation/error routing, and accessible Chart alternatives. Do not claim screen-reader certification or audited WCAG conformance.

### License

- [x] Add a Getting Started License page using package `LICENSE.md` and the generated bundled dependency notices as authoritative sources.
- [x] Identify package MIT terms and relevant runtime dependency licenses; distinguish included dependencies from optional icon packs and application-added packages.
- [x] Retain third-party notices/provenance. Do not invent a docs copyright owner or a new license text; docs currently declares MIT in Composer but has no root license file.

### Changelog

- [x] Add one Getting Started Changelog page with Package and Documentation tabs using the existing Tabs component.
- [x] Resolve package root via Composer installed-package metadata and read its `CHANGELOG.md`; read the docs file via a fixed `base_path` path.
- [x] Render with installed CommonMark, stripping raw HTML and rejecting unsafe links. Handle missing/unreadable sources clearly without exposing internal paths.
- [x] Route Markdown-generated links/code through safe node rendering that uses the new presentation components. Do not execute Markdown as Blade or apply unsafe string replacement to generated HTML.
- [x] Ensure the docs changelog is included in deployment/archive sources; its current `export-ignore` conflicts with request-time rendering. Package already ships its changelog.
- [x] Render current source content on requests without copying release entries into a view or fetching GitHub. Preserve the fact that both current files may contain the same initial-release text.

### Acceptance

- [x] Meaningful icons are exposed to the accessibility tree; decorative icons remain hidden.
- [x] New pages are linked with active state, breadcrumbs, and matching content navigation.
- [x] Changelog tabs read the correct independent sources and react to file changes; unsafe HTML/links cannot execute.
- [x] License and accessibility statements are traceable to shipped behavior/files and accurately state their limits.

### Verification — 2026-10-10

- Fixed Icon accessibility at the SVG root without changing vendor SVGs. The output contains one managed declaration per attribute; labeled icons have role=img and their escaped name without inherited aria-hidden. Decorative icons remain hidden. Root attributes are processed as complete tokens, preserving unrelated values that mention accessibility attribute names. Regression tests fail before both fixes and pass afterward across all four Heroicons families and forwarded data values. Browser role/name lookup confirms meaningful icons are exposed.
- Added Getting Started Accessibility, License, and Changelog with active sidebar links, breadcrumbs, and content navigation. Accessibility describes verified labels/errors, keyboard/focus, announcements, motion and forced-colors support, and application responsibilities without claiming certification or screen-reader auditing.
- License reads the installed package license and generated package/docs notices as escaped text. Runtime dependency summaries match local Composer metadata and bundled notices. Included the official Instrument Sans SIL OFL-1.1 text and provenance in docs build notices; retained the existing package notices and license ownership. No license text or copyright owner was invented, and no dependency was added.
- Changelog reads two independent local files on each request. Composer installed-package metadata locates package sources; documentation paths are fixed. Tests cover independent updates, missing/unreadable sources, and read failures without exposing paths. Removed the docs changelog export-ignore so archives retain the request-time source. Existing release entries remain untouched, including their current matching initial-release notes.
- CommonMark 2.10.3 strips raw HTML, rejects unsafe/control-character destinations, bounds parsing, and uses typed node renderers with fixed Blade templates for Sirius Code/Link. Markdown is never compiled as Blade or rewritten as generated HTML. Tests cover nested markup, escaped literals/titles, fenced and indented code, exact code text, and adjacent inline text. Source headings are rebased within the page hierarchy.
- Package/docs production builds pass. Package formatting, PHPStan, Rector, and tests pass: 793 tests / 2,563 assertions. Docs equivalents pass: 256 tests / 1,710 assertions. Full local Chromium browser gate passes with two workers: 267 tests / 2,874 assertions, without warnings, in 227 seconds. Inspected mobile light/dark screenshots and tested Changelog keyboard activation after Livewire navigation.
- The first full browser run had one existing multiple-upload completion failure; its focused rerun and the final full suite both pass. Upload behavior/tests were not changed for this phase. Evidence is retained in each project's ignored .phpunit.cache/phase-4-*.log. Existing non-fatal build notices remain; no publication, vendor edits, Windows changes, or remote CI execution was performed.

## Phase 5 — Other: Colors and Customized Scrollbar

### Work

- [x] Add an **Other** navigation category with **Colors** and **Customized Scrollbar** pages.
- [x] Explain semantic variants with swatches and real examples: primary/sky, secondary/indigo, success/emerald, danger/red, warning/amber. Light presentation shades are 100/900/300; dark shades are 950/200/700 for background/text/border.
- [x] Explain info as a custom surface/border mix, not a named Tailwind shade. Cover ghost/outline as component-specific treatments rather than additional color families.
- [x] Distinguish semantic `--sir-{variant}-{bg,text,border}` tokens from global `--sir-color-primary` and other widget/layout tokens. Custom OKLCH values have no exact named Tailwind shade equivalence.
- [x] Provide copyable light/dark overrides after Sirius CSS; demonstrate both presentation tones and widget tokens without promising one token controls every component.
- [x] Document `sir-scrollbar` on an element and descendants, its four CSS variables, light/dark styling, standard thin/color fallbacks, and forced-colors behavior.
- [x] Use Code/Link and examples partials for all new documentation. Do not add a redundant scrollbar JavaScript API or alter default colors merely to document them.

### Acceptance

- [x] Displayed colors, shades, and CSS variables agree with package source and working examples.
- [x] Scrollbar examples work in both themes and narrow containers; compatibility limits are explicit.
- [x] Navigation/content links remain functional after the new category is added.

### Verification — 2026-10-10

- Added the Other category with Colors and Customized Scrollbar routes, breadcrumbs, active sidebar links, and section navigation. Existing menu order remains unchanged. Demos, examples, and token tables live in separate other partials; every x-docs-code invocation remains inside an examples directory.
- Colors demonstrates all six semantic tones and their actual light/dark Tailwind background/text/border mappings. It documents info as a surface/border mix, ghost/outline as component-specific treatments, and the distinct presentation and widget/layout tokens. The scoped cyan preview changes Badge/Code and a Switch independently without affecting the default preview.
- Customized Scrollbar demonstrates nested vertical and horizontal scrolling, the four inherited variables, and scoped cyan overrides. It documents the WebKit treatment, standard thin/color fallback, operating-system appearance limits, and native forced-colors rendering, with primary CSS documentation links. No JavaScript scrollbar API was added.
- Copyable CSS is read from the same two scoped stylesheets used by the previews, imported after Sirius CSS. Browser tests verify exact copied source, theme changes, isolated overrides, inherited scrollbar styling, keyboard scrolling, forced colors, and Livewire navigation. Mobile token tables scroll within their containers, keep token names intact, and have named keyboard focus targets. Inspected mobile light/dark screenshots.
- Package and docs production builds pass. The first package build encountered a temporary write failure for dist/sirius.js; the retry succeeded and the package working tree remains unchanged. Package runtime, defaults, dependencies, and existing tests were not changed in this phase. The package quality gate from Phase 4 remains applicable: 793 tests / 2,563 assertions.
- Docs formatting, PHPStan, Rector, and feature tests pass: 258 tests / 1,756 assertions. Full local Chromium browser gate passes with two workers: 274 tests / 2,911 assertions, without warnings, in 227 seconds. After the last token-name wrapping adjustment, the focused Other browser gate also passes: 7 tests / 37 assertions. The focused runner reports its existing two warnings without details; the full gate has none.
- Evidence is retained in each project's ignored .phpunit.cache/phase-5-*.log. Existing non-fatal build notices remain. No vendor edits, system changes, dependency updates, publication, or remote CI execution were performed.

## Phase 6 — Separate Welcome landing page

### Work

- [x] Build a dedicated landing layout without the docs sidebar; reuse shared head/assets, brand, appearance preference, and package components.
- [x] Add a short Sirius UI introduction and clear links to Introduction, Installation, and component documentation.
- [x] Include lightweight interactive showcases: Button/Badge variants, Card with representative form controls, and Dialog/Toast. Use local/demo state, not real uploads, database queries, authentication, or persistence.
- [x] Use the new Code/Link and menu composition where relevant. Keep docs pages on their existing documentation shell.
- [x] Support light/dark/system appearance, mobile layout, keyboard/focus, reduced motion, and viewport-contained floating controls.

### Acceptance

- [x] Welcome has no sidebar and remains usable on mobile/desktop in both themes.
- [x] Showcases interact correctly without pretending to save user data.
- [x] Appearance and navigation transitions remain consistent when moving between landing and docs pages.

### Verification — 2026-10-10

- Welcome now uses a dedicated landing layout without the docs sidebar. It reuses the shared head, assets, brand, scrollbar, appearance options, and Livewire navigation; documentation pages keep their existing shell.
- Added a short introduction, Installation/component links, all Button/Badge variants, and a Card with local Input/Switch state. Dialog previews the current values; Toast explicitly describes a demo notification. No upload, database query, authentication flow, or saved form state was added.
- Browser coverage verifies escaped preview text, keyboard controls, focus restoration, fresh form state after reload, persisted Light/Dark/System preferences across both shells, and contained Dropdown/Dialog/Toast panels at 320, 390, and 1,440 pixels with reduced motion. Inspected desktop and mobile screenshots in both themes.
- Corrected one existing navigation assertion to wait for the final `/getting-started/introduction` destination rather than the intermediate `/dashboard` redirect. The related navigation and landing suite passes 17 tests / 167 assertions.
- Package build followed by docs build passes. Package source and generated assets remain unchanged. Docs quality gate passes: 257 tests / 1,757 assertions, with Pint, PHPStan, and Rector passing.
- Full local Chromium browser gate passes with two workers: 280 tests / 2,987 assertions, without warnings, in 236 seconds. Updated README; whitespace checks pass.
- Gate/build logs are retained in the projects' ignored `.phpunit.cache/phase-6-*.log` files. No dependency changes, vendor-source edits, environment/system changes, release publication, or remote CI execution were performed.

## Phase 7 — Final validation and documentation alignment

- [ ] Review all new APIs, keyword rows, examples, translations, skill references, Introduction links, and README links against source.
- [ ] Run focused behavior tests after each change, then package/docs quality gates, package build followed by docs build, and the full docs browser suite.
- [ ] Cover Code/Link forwarding/escaping and styles; Menu composition/custom namespaces/keyboard/lifecycle; exact copied source; Icon accessibility; safe two-source Markdown rendering; and landing/navigation/theme/viewport behavior.
- [ ] Preserve existing tests. Update assumptions contradicted by intentional UI changes; do not suppress failures, delete tests, or assert matching prose.
- [ ] Recheck dependency audits, generated assets/notices, source distribution, and supported Laravel/PHP compatibility when package behavior changes warrant it.
- [ ] Complete the release checklist using actual results. Do not claim remote CI, extra browser engines, physical devices, formal accessibility certification, or direct Claude Code execution without running them.

## Implementation order and completion

- [x] Phase 0 — Baseline/rules and stale references.
- [x] Phase 1 — Code/Link APIs and docs.
- [x] Phase 2 — Menu composition and navigation migration.
- [x] Phase 3 — Existing docs markup/examples, Introduction, and Icons.
- [x] Phase 4 — Accessibility fix/pages, License, and source-driven Changelog.
- [x] Phase 5 — Other pages.
- [x] Phase 6 — Separate Welcome landing.
- [ ] Phase 7 — Final integration/release checks.

Each phase ends with concrete reviewable changes and relevant passing checks. No phase is marked complete from a plan or an assumed test result. User decisions above take priority over older conventions.
