# Phase 24 — AI agent skill for package consumers

Completed on 2026-10-07 within the agreed scope. Direct Claude Code runtime evaluation is deferred at the user's request. All final phase gates passed.

## Shipped contract

The canonical portable skill is resources/boost/skills/sirius-ui-development/SKILL.md. Ten adjacent references cover setup, public field and presentation props, widgets, navigation, overlays, Table, Calendar, Chart, and executable consumer recipes. Frontmatter uses the name sirius-ui-development and a targeted description; detailed guides are loaded only when needed. The same source is used for both installation paths.

References explain namespace/config/translation defaults, local precompiled assets, themes/icons, canonical values, native versus Livewire forms, uploads and HTML sanitization. They keep authorization, scoping, persistence, transactions, exports and application-created overlays outside the package. Table uses filters(), Column format closures and external row/bulk views; no action engine or toolbar-action extension is introduced.

Getting Started now expands to Overview and AI Agent Skill. The new /getting-started/ai-agent-skill route documents Boost selection, standalone/manual installation, invocation, upgrades, customizations, ownership conflicts and compatibility. Overview remains first. Package README remains unchanged; docs README points to the guide.

## Installation and ownership

Boost 2.8.1 discovers the direct Composer dependency's resources/boost/skills bundle. Interactive consumers select Agent Skills, their agent and sirius/ui:
```shell
php artisan boost:install --skills
php artisan boost:update
```

Standalone installation/update uses one explicit command:
```shell
php artisan sirius:skills:install --agent=codex --dry-run
php artisan sirius:skills:install --agent=codex
php artisan sirius:skills:install --agent=claude-code
```

Repeat --agent to select both. Destinations are project-local .agents/skills/sirius-ui-development and .claude/skills/sirius-ui-development. The command previews every planned file action and ownership manifest. Provider boot registers the command only; no agent files or configuration are installed automatically.

The standalone manifest tracks per-file SHA-256 hashes and a bundle digest. Unchanged files are not rewritten; pristine managed files update and retired files are removed individually. Customized or colliding files require explicit interactive confirmation; originals are backed up under .sirius-ui-backups inside the selected skill. Noninteractive conflicts cause no installation. Unrelated files/skills and AGENTS.md/CLAUDE.md/MCP configuration remain intact.

Manifest paths reject traversal and Windows reserved names. Destination ancestors/files reject symlinks and junctions. Preflight detects source/destination conflicts and ownership changes during preview. Boost-owned destinations direct users to boost:update, including custom linked destinations.

Boost overwrites edits made directly in its installed package copies. The supported customization path is a complete .ai/skills/sirius-ui-development bundle; it overrides package guidance, with upgrades merged manually. Real install/update tests verify that behavior for both agent directories. The standalone installer does not take ownership of Boost files.

## Verification

| Check | Result |
| --- | --- |
| Package composer test | 682 tests / 2,186 assertions; Pint, PHPStan and Rector passed |
| Docs composer test | 213 tests / 1,294 assertions; Pint, PHPStan and Rector passed |
| Docs composer test:browser | 241 tests / 2,677 assertions; final two-worker run passed without warnings |
| Standalone installer regression coverage | Clean Codex/Claude targets, repetition, upgrades, retired files, customization backups/refusal, malformed manifests, traversal, reserved paths, linked destinations, passive boot, preview races and ownership |
| Boost integration | Real native InstallCommand/UpdateCommand, selected direct package, complete references in both destinations, refresh, custom override and standalone ownership refusal |
| Bundled recipes in docs | Livewire validation/reset/Toast, native form rendering, scoped Collection Table/filter/sort, scoped Calendar event click and acknowledged persistence, including duplicate local IDs in different owners |
| Composer archive | 11 skill files byte-verified, references and compiled assets/notices included; tests, dependencies and caches excluded |

Boost deliberately disables command registration during PHPUnit. The integration test explicitly registers its actual native command classes; separate clean-consumer CLI invocations also succeeded through normal local service-provider registration. Tests never patch Boost/vendor source.

A Composer archive was built from a project-local snapshot of tracked/unignored package source, excluding environment files and local dependency/test caches, using composer archive --format=zip. Every skill reference and dist asset was checked against the output. No runtime assets or production dependencies were added.

The skill-creator quick_validate.py script could not start because PyYAML is absent in both local Python runtimes. Existing Symfony YAML validates the frontmatter in the package test, all Markdown links resolve, Boost parses/distributes the bundle, and actual Codex runs activate it. No Python dependency was installed.

## Actual Codex evaluations

Tested Codex CLI 0.160.1 with Laravel 13.31.0, Livewire 4.4.4, Boost 2.8.1 and PHP 8.5 on Windows. Two minimal consumer projects live under docs .phpunit.cache/agent-evaluation, with read-only shared installed Composer dependencies. Existing general Laravel/Livewire/testing instructions remained available; successful Sirius skill/reference reads and generated examples are the evidence for package-specific activation.

Each native Codex session explicitly invoked $sirius-ui-development, then read its installed SKILL.md and relevant setup/field/overlay/Table/Calendar/recipe references. Both built:
- A validated Livewire Input/Currency form with a pre-rendered Toast, invalid-submit protection and canonical Reset.
- A local light/dark token override.
- An authenticated owner-scoped Collection Table with filtering/sorting.
- An owner-scoped Calendar source, an application-created event review Dialog, and acknowledged event-drop persistence with foreign-owner rejection.

| Installation path | Actual result |
| --- | --- |
| Standalone Artisan → Codex | 23 generated Pest tests / 112 assertions; local Chromium smoke passed with no JavaScript errors |
| Boost → Codex | 20 generated Pest tests / 97 assertions; no consumer browser smoke claimed |

Pest results were independently replayed locally while the sessions were working (22/107 before the final standalone regression addition, and 20/97 for Boost). The final standalone session recorded 23/112 plus its Chromium smoke for Currency/save/reset, both themes and Calendar event-click Dialog. Mouse-drag persistence was tested through Livewire, not a browser drag gesture. Consumer authentication is a fixed local demo identity and persistence uses session storage; these are evaluation fixtures, not production authentication/storage designs.

The first CLI attempts selected workspace-write but received a read-only runtime and could not execute even file reads. Fresh ephemeral runs with the already-authorized full-access permission mode completed, restricted by task instructions to the consumer files. No agent runtime is invoked by production package code.

Claude Code directory installation is verified through standalone and Boost tests and matches its documented project skill convention. Its executable was absent from Windows and WSL; the user explicitly chose to defer direct runtime evaluation. No Claude version, model behavior or generated-code compatibility is claimed. Other agents and a new Laravel 12/PHP 8.3 compatibility matrix were not evaluated in this phase.

## Browser gate notes

The first full browser run overlapped native consumer Pest runs sharing the same installed browser runtime. It failed with missing Playwright server state and timeouts. After evaluations stopped, a separate full run passed 241 tests / 2,677 assertions. After the last installer/recipe review, full replays encountered isolated existing Form currency and touch-navigation timeouts; targeted replays passed 1/9 and 1/11 respectively (standalone runner emitted two warnings without details). A one-worker run exceeded Composer's 300-second process limit. The final complete replay passed all 241 tests / 2,677 assertions in 194,986 ms without warnings, using two workers and a process-local COMPOSER_PROCESS_TIMEOUT=0. No project/vendor or OS settings were changed to address these runner issues.

Final gate command (the environment override lasts only for this PowerShell process):
```powershell
$env:COMPOSER_PROCESS_TIMEOUT = '0'
composer test:browser -- --processes=2
```

Primary references: [Laravel Boost third-party skills](https://github.com/laravel/docs/blob/13.x/boost.md#third-party-package-skills), [Laravel Boost](https://laravel.com/framework/docs/boost), [Claude Code skills](https://code.claude.com/docs/en/skills), and [OpenAI skill guidance](https://learn.chatgpt.com/docs/build-skills). Installed Boost Codex/Claude adapters and native Codex execution verify the actual directory/invocation behavior used here.
