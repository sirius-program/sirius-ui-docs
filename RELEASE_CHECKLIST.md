# Release checklist

The audit below records local candidate validation from 2026-10-08, before the documentation cleanup. These results are historical evidence, not a passing baseline for later changes. Current work and verification are tracked in the [implementation plan](IMPLEMENTATION_PLAN.md). No release has been published.

## Documentation baseline — 2026-10-09

- [x] Complete Phase 0 in the [implementation plan](IMPLEMENTATION_PLAN.md): obsolete rules/references removed, development fixtures repaired, and tests aligned with the intentional cleanup.
- [x] Docs quality gate passes: 221 tests / 1,366 assertions, including formatting, static analysis, and refactoring checks.
- [x] Full local Chromium browser gate passes: 251 tests / 2,748 assertions, without warnings, in 299 seconds. The default script uses two workers and disables Composer's process timeout; CI uses the same script.
- [x] Composer metadata and whitespace checks pass. This phase changes docs and test infrastructure; the package source remains unchanged.

Logs are retained under the ignored `.phpunit.cache` directory. Package compatibility/install/audit results below remain the dated 2026-10-08 evidence; they were not repeated in this docs-only phase. Remote CI remains pending.

## Recorded audit — 2026-10-08

- Package quality gate: 738 tests / 2,343 assertions; docs quality gate: 218 tests / 1,312 assertions. Formatting, static analysis, and refactoring checks pass.
- Final full docs browser gate after the corrections: 251 tests / 2,746 assertions, passed without warnings in 228 seconds. Browser evidence uses local Windows Chromium; remote CI is still pending.
- The current 738-test package suite passes on Windows for Laravel 12.69.3 and 13.35.0, each with PHP 8.3.33, 8.4.26, and 8.5.10. The existing independent dependency installations were reused with current source. Oldest permitted framework patches and Linux execution are not claimed.
- Composer and npm audits report zero advisories/vulnerabilities in both projects. No dependency versions or advisory ignores were changed. `composer validate` passes; strict validation reports the existing exact Heroicons 2.7.0 pin as a general warning. The pin is retained.
- Package CSS/JS hashes are identical across two consecutive builds. The compiled JS was refreshed to match committed regional-setting exception text. The public README link, Composer support metadata, and package changelog are corrected.
- The clean source archive contains 219 files, compiled assets, English translations, license notices, and the skill plus ten references. It excludes root vendor/node_modules, tests, CI, environment files, and caches. Vendored Tiptap UI source and its licenses are intentional package contents.
- A fresh mirrored consumer with Laravel 13.35.0 / Livewire 4.4.7 installs the archive, publishes assets, installs both skill destinations, and passes 23 usage tests / 112 assertions with a fresh config cache. Installed assets, regional metadata, translations, and all eleven skill Markdown files match source hashes. No direct Claude Code evaluation was resumed.
- The empty consumer fixture deliberately has no environment file. Uncached boot reports Laravel dotenv missing-file warnings; its explicit test configuration is cached before the clean gate. No environment file or vendor source was edited to suppress them.
- CI corrections are prepared: package metadata/audit steps; docs master/main triggers, exact locked package checkout in a sibling directory, Node 24, locked npm installs, package-first builds, and browser process timeout. YAML parses successfully and pinned docs action commits resolve. Remote execution still requires pushed commits.

## Technical validation — 2026-10-08 candidate

- [x] All promised component families have documentation and working examples.
- [x] Package/docs formatting, static analysis, refactoring, and feature gates pass.
- [x] PHP 8.3/8.4/8.5 package suites pass with Laravel 12 and 13.
- [x] Both asset builds pass, and generated country labels remain stable.
- [x] Composer and npm audits report no known advisories in either project.
- [x] Mixed native/Livewire overlay forms, canonical values, validation/reset, keyboard/focus, lifecycle, and multiple-instance regression coverage are present.
- [x] Table actions and Calendar persistence remain application-owned; only free dependency features are used.
- [x] Runtime assets are local and enhanced controls do not duplicate initialization after submission.
- [x] Distribution includes compiled assets, translations, license notices, skill entry point, and every referenced Markdown file.
- [x] A fresh non-linked consumer can install the distribution, publish assets, install/update both documented agent skill destinations, and run the usage scenarios.
- [x] A fresh linked docs installation passes npm installation/build and feature tests.
- [x] Repeat the final full docs browser gate after this audit's corrections: 251 tests / 2,746 assertions, without warnings.

## Before publication

- [ ] Choose the release version and review the [unreleased changelog](CHANGELOG.md).
- [ ] Review and commit the final changes, including generated assets and lock files where tracked.
- [ ] Push the package commit first, refresh `sirius/ui` in the docs lock file to that commit, then push docs so its CI checkout references the reviewed source.
- [ ] Obtain successful remote CI results for the release commit.
- [ ] Rebuild/archive the selected release commit and confirm its version-matched skill/references.
- [ ] Authorize package publication or docs deployment separately.

Direct Claude Code execution is deferred by agreement. Other browser engines, physical devices, formal accessibility certification, and Linux execution remain unverified locally; do not advertise those checks as completed. Ignored test installations/caches are not part of the distribution.
