# Phase 0 — Foundation and integration decisions

Executed on 2026-09-12. This phase establishes architecture, local installation, and development integration proofs. It does not ship any public form, layout, table, or calendar component.

## Architecture enforcement

The package's `tests/Architecture/PackageTest.php` is included in `phpunit.xml.dist`, so `composer test` always runs it. It protects independence from consuming `App`, `Database`, `Tests`, and Flux namespaces; strict PHP types; absence of debugging and direct environment helpers in production classes; Livewire inheritance; and source file/PSR-4 correspondence.

Existing PHPStan maximum-level analysis checks typed PHP boundaries in package source and tests. Architecture tests deliberately do not require every class to be `final`: future table subclasses and other intentional extension points must remain extensible. The Livewire namespace rule also applies to indirect inheritance. It has no production matches until Livewire components are introduced.

Blade templates are reviewed for presentation-only responsibilities: no query execution, business mutations, direct environment access, or references to application models. PHP architecture expectations cannot reliably enforce arbitrary Blade content; this is an explicit review requirement, not a claim of complete static coverage. Future shared helpers must preserve these boundaries. Add focused template/static enforcement when actual templates reveal a meaningful repeatable rule.

To change architecture rules in a later phase, document the new boundary and why it is needed, update its tests, demonstrate a representative violation, and rerun both project gates. Do not exclude an entire directory or add analysis suppressions to conceal a violation.

The Phase 0 negative control added a temporary production class calling `dump()`. The architecture suite failed with `Expecting 'Sirius\\Ui' not to use 'dump'`. After removing that temporary class, the suite passed. No intentionally invalid production file remains.

## Local package integration

Docs installs `sirius/ui:dev-main` using a Composer path repository pointing to `../sirius-ui`. Composer created a Windows junction to the actual package directory. `PackageIntegrationTest` verifies service-provider auto-discovery, merged namespace configuration, and SVG rendering through the package's Blade Heroicons dependency.

The docs CSS imports the package's compiled `dist/sirius.css`. Rebuild package CSS before rebuilding docs. The `/components` page and sidebar entry form the component documentation index; placeholders clearly indicate that components are not implemented yet. The package README points only to docs.

## Selected libraries and exact versions

Versions below were resolved from package metadata and installed locally. The selected features require no API key, paid editor, cloud service, or jQuery dependency. This is an engineering selection based on the checked license files and integration behavior; retain license notices when redistributing.

| Purpose | Selection | License | Scope and rationale |
| --- | --- | --- | --- |
| Blade icons | `blade-ui-kit/blade-heroicons` 2.7.0; `blade-ui-kit/blade-icons` 1.10.1 | MIT | Package dependency; SVGs render locally. Common free icons without a JS runtime. |
| Date/time | `flatpickr` 4.6.13 | MIT | Docs proof now; package adapter in Phase 4. Explicit value updates and teardown, no jQuery. Old release cadence is a maintenance consideration; recheck before promotion. |
| Upload | `filepond` 4.32.12 | MIT | Docs proof now; Phase 6 owns full validation, cancellation/retry UX, and multiple uploads. No Pintura or paid image-editing features. |
| Searchable select | `tom-select` 2.6.2 | Apache-2.0 | Docs proof now; replaces the proposed Select2 category without introducing jQuery. Full remote pagination belongs to Phase 5. |
| Richtext | `@tiptap/core` and `@tiptap/starter-kit` 3.31.3 | MIT | Open-source editor only. Fits custom Tailwind styling; no Pro, cloud, AI, or image-upload feature. |
| HTML sanitization example | `symfony/html-sanitizer` 7.4.18; `masterminds/html5` 2.11.0 | MIT | Docs application dependency. The consuming application owns validation and sanitization. |
| Table/calendar | Native Livewire 4.4.4 baseline | MIT | No additional datatable/calendar JS engine. Server-owned table state and the agreed simple month grid do not justify a second rendering engine. |

Quill 2.0.3 was evaluated and rejected after npm audit identified GHSA-v3m3-f69x-jf25. It is not installed. The final selected npm dependency graph passed audit. Composer's normal advisory blocking remains enabled; no advisories were ignored to install the sanitizer.

The widget packages are exact development dependencies in docs for these integration proofs. Move the necessary dependencies, adapters, and asset build ownership into the package when implementing their corresponding component phases; consumers must not depend on docs assets. This avoids prematurely declaring the experimental fixtures a public package API.

## Asset and lifecycle contract

`resources/js/development/integrations.js` registers two Alpine factories. The factories lazy-load the selected widget modules and CSS through Vite. Livewire supplies Alpine even on the ordinary Blade proof; no standalone Alpine copy is installed. Widget instances stay in JavaScript closures rather than Alpine's reactive proxy.

Each instance initializes once, checks whether it was disposed while imports were pending, watches server changes, and uses non-emitting setters to avoid feedback loops. Alpine teardown destroys the instance and removes explicit upload watchers. File upload bridges processing, progress, cancellation, and temporary-file removal to Livewire APIs. FilePond uses `storeAsFile` for ordinary Blade form submission.

Development routes are available only in `local` and `testing`. The fixtures demonstrate server reset, conditional unmount/remount, multiple instances, ordinary form values, and Livewire navigation. They do not claim complete browser accessibility or full Phase 4–7 option support. Those remain component acceptance requirements.

Vite emits local chunks and CSS. `scripts/build-notices.mjs` runs before every build and collects licenses for the selected libraries and their installed runtime dependencies into `public/third-party-notices.txt`. Sifter's npm archive supplies its notice in README rather than a LICENSE file; the generator retains that notice and the Apache 2.0 license. Unicode Variants' license is retained from its upstream v1.1.2 tag in `scripts/licenses` because the npm archive omits it. PHP dependency licenses remain in their Composer packages.

## HTML trust boundary

`IntegrationProbe::save()` validates inputs and sanitizes editor HTML on the server with `HtmlSanitizerConfig::allowSafeElements()`. Only the resulting locked `sanitized` property is rendered unescaped. The submitted HTML remains escaped in diagnostics. A feature test covers script elements, unsafe link URLs, and preservation of permitted formatting.

The example does not persist content. Applications must sanitize before displaying stored or submitted richtext; disabling a toolbar button or sanitizing only in JavaScript is insufficient. Future application-specific allowed HTML must be documented and tested.

## Test environment and compatibility

The main package and docs run on PHP 8.5.10 with Laravel 13.31.0 and Livewire 4.4.4. Package tests retain Pest 4.7.8/Testbench 11.2.0; docs retains Pest 5.1.4 and Browser plugin 5.0.1.

An isolated copy under the package's ignored `.phpunit.cache/phase-zero-laravel12` resolved Laravel 12.69.2, Testbench 10.11.0, and Livewire 4.4.4 with the PHP 8.3 Composer platform constraint. Its package tests passed on the available PHP 8.5 runtime. This does not claim a local execution on PHP 8.3. CI now explicitly covers PHP 8.3 and 8.5 for both Laravel majors and sets Composer's platform to the selected PHP version. CI has not been dispatched in this local task.

Installed Laravel 13/Testbench metadata declares PHP `^8.3`, so the original 8.3 combination was not inherently invalid. The matrix expansion checks newer PHP as well; it does not unnecessarily raise the package minimum.

The installed Pest Browser server omits multipart files when constructing its Laravel request (`LaravelHttpServer` has a `TODO files` placeholder). Therefore the upload browser test starts an isolated native PHP server, uses the real Livewire multipart endpoint, and stops the server in a `finally` block. It uses a dedicated test upload disk/root and a deterministic, non-secret testing key. The external server uses `APP_ENV=local` because Livewire's `testing` mode selects a special fake disk across requests. No vendor patch or fake upload endpoint is used. Other browser tests use Pest's normal server. Feature tests use isolated fake storage and fixed input values without database fixtures.

## Reference sources

- [Pest architecture expectations](https://pestphp.com/docs/arch-testing)
- [Composer path repositories](https://getcomposer.org/doc/05-repositories.md#path)
- [Livewire JavaScript lifecycle](https://livewire.laravel.com/docs/4.x/javascript)
- [Livewire upload API](https://livewire.laravel.com/docs/4.x/uploads)
- [Flatpickr instance API](https://flatpickr.js.org/instance-methods-properties-elements/)
- [FilePond server integration](https://pqina.nl/filepond/docs/api/server/)
- [Tom Select API](https://tom-select.js.org/docs/api/)
- [Tiptap open-source editor](https://tiptap.dev/docs/editor/getting-started/overview)
- [Symfony HTML Sanitizer](https://symfony.com/doc/7.4/html_sanitizer.html)
- [Unicode Variants v1.1.2 license](https://github.com/orchidjs/unicode-variants/blob/v1.1.2/LICENSE)

## Completion evidence

All Phase 0 gates passed:

- Package `composer test`: 5 tests, 31 assertions; formatting, maximum-level static analysis, and refactoring checks passed.
- Docs `composer test`: 6 tests, 21 assertions; formatting, static analysis, and refactoring checks passed.
- Docs `composer test:browser`, run after both project checks passed: 4 tests, 31 assertions; includes real multipart upload, client/server updates, reset, remount, navigation, and JS error assertions.
- Both `npm run build` commands passed; docs generated local widget chunks and dependency notices.
- Isolated Laravel 12 package suite: 5 tests, 31 assertions, on PHP 8.5 with dependencies resolved for the PHP 8.3 platform.
- Final selected dependency audits reported no known vulnerabilities. Composer validation passed; the package's intentional exact Heroicons version produces a non-fatal version-constraint recommendation.

CI runtime execution on PHP 8.3 and broader browser/OS coverage remain CI/release checks, not locally verified claims. No later component phase was started.
