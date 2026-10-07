# Phase 26 — Cross-component validation and release readiness

Completed on 2026-10-07 within the agreed scope. This phase verifies the implemented components and prepares a local release candidate. No version, tag, package publication, or deployment was created.

## Corrections found during validation

- Currency validity messages, Datetime Picker feedback/Clear labels, password Show/Hide labels, and Phone country/validity/no-JavaScript messages now use `sirius::sirius-ui.*` translations supplied by Blade. Explicit password and Phone labels still override translations. Currency placeholders use the current precision and bounds. Datetime Picker's `locale` still selects calendar month/day names independently of application UI translations.
- The corresponding docs have separate Translations sections or examples. Bundled skill defaults and setup instructions match these APIs. No wording-comparison tests were added.
- A test architecture expression used PHP 8.4 syntax. Parenthesizing its `new Finder` expression restores PHP 8.3 compatibility. Rector now explicitly targets PHP 8.3.
- Phone metadata builds preserve committed country labels across Node/ICU versions while updating calling codes. Newly introduced countries fall back to `Intl.DisplayNames`. CI checks generated assets and metadata, and covers PHP 8.4 alongside 8.3/8.5.

## Integration coverage

The final browser gate reuses the existing development fixtures and public demos. Additional assertions verify exactly one widget instance per enhanced field after overlay form submission, local asset requests, and translated feedback. Native Phone country prefixes are not counted as Tom Select instances.

| Area | Evidence |
| --- | --- |
| Mixed forms in Dialog and Slideover | `OverlayFormTest`: Blade/Livewire modes, all form controls, canonical submissions, validation, readonly/reset, hidden source fields, mobile themes, and anchored date pickers |
| Native submission | `FormBrowserTest`, `FormFoundationTest`, field browser tests, and feature tests: GET, CSRF, spoofed methods, multipart files, disabled/readonly behavior, and formatted versus canonical values |
| Lifecycle and accessibility | Widget, navigation, overlay, floating, Tabs/Timeline and shell suites: multiple instances, remounts/navigation, keyboard/focus, RTL, mobile themes, reduced motion, and scrollbar/fixed-element geometry |
| Toast | `ToastTest`: timing, pause/resume, queue bounds, repeated invocation, close synchronization, cleanup, and Livewire footer actions above overlays without stealing focus |
| Table | Table/bulk browser and feature suites: Builder/Collection sources, `$record`/exact `$selectedIds`, application-owned overlays, selection persistence/cleanup, checkbox requests without loading overlay, usable toolbar/filters during other loading, sorting, column widths/borders, numeric pagination, and translated record labels |
| Calendar | `CalendarBrowserTest` and feature tests: all four FullCalendar views, scoped sources, timezone conversion, recurrence context, exclusive ends, drag/resize acknowledgment and rollback, failure/retry, hidden sizing, multiple instances, loading height, themed More popup, and Sunday hover overflow |
| Chart | `ChartBrowserTest`: bundled controllers, mixed/time scales, reactive data, local callbacks/plugins, hidden sizing, errors/retry, lifecycle cleanup, reduced motion, and accessible naming |

Application code still owns authorization, persistence, uploads, sanitization, Table actions, and Calendar CRUD. FullCalendar uses Standard features; no Premium package or package action engine was introduced.

The source/navigation audit found the promised component families represented in docs. Menu labels remain alphabetical with Overview first. Prop tables, slots/events, configuration examples, split page snippets, translations, and the package's minimal README pointer were reviewed. Active code has no Flux dependency or component use; `flux.appearance` remains only as a legacy preference fallback. Historical phase reports retain their original references.

Screenshots reviewed during the gate include native controls and Chart in both themes, mobile Dialog/Slideover forms, the desktop dark docs shell/Table page, and mobile Table filters. Keyboard, geometry, and reduced-motion assertions remain in the browser suites.

## Dependency audit

With user approval, Commonmark was updated to 2.10.3 in both installed PHP dependency sets, source-map-js to 1.2.2, docs concurrently to 10.0.5, and Vite+ to 0.3.3. The official Vite+ alias and override are required for a clean npm installation with its bundled Vite core.

Two remaining vulnerable transitive dependencies were replaced through project overrides: Tailwind CLI's `@parcel/watcher` with 2.6.0, and concurrently's `shell-quote` with 1.12.0. No advisory ignores or forced peer resolution were used. Final `composer audit --format=json` and `npm audit --json` report zero advisories/vulnerabilities in both projects. This is the audit result on the validation date, not a guarantee against future advisories.

Commonmark advisory references: [HTML filtering bypass](https://github.com/advisories/GHSA-97jj-33gv-5xf9), [table parsing denial of service](https://github.com/advisories/GHSA-3q6v-r5mr-hxv8). Vite+ alignment follows the [official local CLI guide](https://viteplus.dev/guide/local-cli) and the installed package migration instructions.

## Compatibility matrix

Each row ran the entire package Pest suite with independent Laravel-major dependency installations. All rows passed **686 tests / 2,199 assertions**.

| Laravel | Testbench | Livewire | PHP |
| --- | --- | --- | --- |
| 12.69.3 | 10.12.0 | 4.4.7 | 8.3.33 |
| 12.69.3 | 10.12.0 | 4.4.7 | 8.4.26 |
| 12.69.3 | 10.12.0 | 4.4.7 | 8.5.10 |
| 13.35.0 | 11.3.0 | 4.4.7 | 8.3.33 |
| 13.35.0 | 11.3.0 | 4.4.7 | 8.4.26 |
| 13.35.0 | 11.3.0 | 4.4.7 | 8.5.10 |

These are Windows executions using dependency locks resolved for PHP 8.3. PHP 8.4 came from an official Windows archive verified against its published SHA-256, with a project-local configuration under ignored test cache. Existing PHP 8.3/8.5 executables were used. No system configuration or vendor source was modified. The exact oldest allowed Laravel patches were not separately tested. Ubuntu CI has the six combinations configured but was not dispatched in this task.

Local build/install tooling was Node 24.12.0 and Composer 2.9.2. The docs browser runner uses Playwright 1.63.0 with its installed Chromium engine.

## Distribution and clean installation

`composer archive --format=zip` produced a 217-file, 937,251-byte candidate from a clean source snapshot. It includes CSS, JavaScript, third-party license notices, translations, the canonical skill, and all ten adjacent references. It excludes vendor, node_modules, tests, CI, and temporary caches. Asset/translation/skill hashes match both the source and the installed consumer copy.

A fresh consumer installed the extracted archive through a non-linked Composer path repository, then ran:

```shell
php artisan sirius:skills:install --agent=codex --agent=claude-code --no-interaction
php artisan vendor:publish --tag=sirius-ui-assets --force --no-interaction
php vendor/bin/pest --compact
```

The existing representative consumer scenarios passed **23 tests / 112 assertions**. Both agent destinations contain the eleven Markdown files without hash mismatches. Skill installation/update and asset publishing succeed. This is an installation and usage replay, not a new native agent evaluation; Phase 24 remains the evidence for Boost/native Codex activation.

A separate fresh docs directory used its own Composer and npm installations with the documented linked local package repository. `npm ci`, the production build, and **218 feature tests / 1,312 assertions** passed. These checks did not read/copy the user's environment file. Known test settings were supplied locally; ignored temporary installations remain available for inspection.

## Final gates

- Package `composer test`: **686 tests / 2,199 assertions**, with formatting, static analysis, and refactoring checks passed.
- Docs `composer test`: **218 tests / 1,312 assertions**, with formatting, static analysis, and refactoring checks passed.
- Package and docs `npm run build`: passed. The docs build still reports the optional-fontaine notice and its existing large-chunk notice (main chunk about 595 KB gzip); these are build notices, not browser errors.
- Full docs `composer test:browser -- --processes=2` gate: **251 tests / 2,746 assertions**, passed without warnings in 325 seconds. Composer's process timeout was disabled for this run.

The first full browser run passed 247 of 249 scenarios; native Checkbox navigation and a PDF/image preview assertion timed out. The two affected files subsequently passed all 17 scenarios / 159 assertions. A later one-worker full run passed 250 of 251, with retry-upload completion failing. Investigation found that Pest's high-level action wrapper can retry a click after its short internal timeout; the Remove failure screenshot already showed the selected file gone. Retry/Remove now invoke Playwright's click once with the existing upload timeout, followed by the same result assertions. The entire upload file then passed all six scenarios / 65 assertions without warnings. The docs project gate was repeated before the successful final full browser gate. Assertions were retained; no test was removed or weakened to obtain a pass.

## Limits and deferred work

Browser evidence is from local Chromium on Windows with desktop/mobile viewport emulation. Firefox, WebKit, physical touch devices, screen-reader certification, and Linux execution are not claimed. Keyboard/focus and visual/theme checks are regression coverage, not formal WCAG certification.

Direct Claude Code runtime evaluation remains deferred by the user's Phase 24 instruction. Its installation directory and skill contents are verified. Publishing, deployment, release numbering, and remote CI results require separate work. See [Release checklist](RELEASE_CHECKLIST.md) and [Unreleased changelog](CHANGELOG.md).
