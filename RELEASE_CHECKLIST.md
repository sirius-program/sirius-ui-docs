# Release checklist

Local candidate validation: 2026-10-07. Evidence and scope are recorded in [Phase 26](PHASE_26.md). No release has been published.

## Technical validation

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
- [x] Final full docs browser gate passes after all other checks: 251 tests / 2,746 assertions without warnings.

## Before publication

- [ ] Choose the release version and review the [unreleased changelog](CHANGELOG.md).
- [ ] Review and commit the final changes, including generated assets and lock files where tracked.
- [ ] Obtain successful remote CI results for the release commit.
- [ ] Rebuild/archive the selected release commit and confirm its version-matched skill/references.
- [ ] Authorize package publication or docs deployment separately.

Direct Claude Code execution is deferred by agreement. Other browser engines, physical devices, formal accessibility certification, and Linux execution remain unverified locally; do not advertise those checks as completed. Ignored test installations/caches are not part of the distribution.
