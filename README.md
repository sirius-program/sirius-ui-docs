# Sirius UI documentation

This application documents and tests the local `sirius/ui` package. Public components are added only after their implementation phases are completed.

## Local installation

Keep `sirius-ui` and `sirius-ui-docs` in sibling directories. Build the package with `npm ci` and `npm run build`, then run `composer install`, `npm ci`, and `npm run build` in docs. Provision application environment values yourself; agents must never access `.env` directly.

Docs uses a Composer path repository at `../sirius-ui`, mapped to `dev-main`. On Windows Composer creates a junction; elsewhere it uses a symlink. Source changes are immediately visible, but package assets must be rebuilt. After changing package Composer metadata, run `composer update sirius/ui --with-dependencies` in docs.

If linking is unavailable, set the repository's `options.symlink` to `false`, run `composer reinstall sirius/ui`, and repeat that reinstall after package edits to refresh the mirrored copy. Never edit files under `vendor`.

The docs stylesheet imports `vendor/sirius/ui/dist/sirius.css`, and `resources/js/app.js` imports `vendor/sirius/ui/dist/sirius.js`. Build package assets before building docs. The package script enables password visibility, readonly choice controls, and mixed checkbox state without depending on Alpine or Livewire JavaScript. Widget proofs use lazy, locally bundled JS/CSS imports; no runtime CDN is required and no second Alpine instance is installed. The existing docs layout uses Flux, but the package does not depend on Flux.

For applications without a bundler, run `php artisan vendor:publish --tag=sirius-ui-assets` and load `/vendor/sirius-ui/sirius.css` and `/vendor/sirius-ui/sirius.js` once. Refresh published assets after package upgrades, reviewing any local modifications first. The script handles later Livewire renders and navigation automatically.

## Navigation and component index

Open `/components` through the **Sirius UI → Components** sidebar entry. Phase 1 provides **Label** at `/components/label` and **Form conventions** at `/components/forms`, with ordinary Blade submission and Livewire validation/reset examples.

Use `<x-sirius::label>` for standalone labels and `<x-sirius::field>` to compose a native control with labels, helpers, validation messages, and accessible IDs. The field requires a stable unique ID; apply its scoped `$component->controlAttributes()` to the actual control. Inline and fieldset/legend layouts prepare the foundation for choice controls.

Phase 2 provides **Input** (text, number, and password) at `/components/input`, **Textarea** at `/components/textarea`, and **Checkbox, Radio & Switch** at `/components/choices`. Each control has its own example and options section within the combined page. Former Password, Checkbox, Radio, and Switch URLs redirect to the appropriate combined page. Pages include interactive Livewire examples, native Blade usage, props, errors, readonly/disabled semantics, and keyboard guidance. The Input page includes an ordinary POST form that demonstrates canonical values and boolean normalization without storing data.

Development-only integration fixtures are available at `/development/integrations` and `/development/plain-blade` when the application environment is `local` or `testing`. These are experiments for later components, not public component APIs.

Checkbox and radio options inside `<x-sirius::field group>` share the group's error key, error bag, and accessible descriptions. Put `required` on the group to show a single required marker alongside a single set of validation messages. Required radio groups preserve native validation; validate minimum checkbox selections on the server.

Phase 2 integration fixtures at `/development/basic-controls` and `/development/standalone-controls` verify multiple Livewire instances and native controls without Livewire or Alpine. They are available only in local/testing environments.

- [Implementation checklist](IMPLEMENTATION_PLAN.md)
- [Phase 0 architecture, dependency decisions, and evidence](PHASE_0.md)
- [Phase 1 form foundation and verification](PHASE_1.md)
- [Phase 2 basic controls and verification](PHASE_2.md)
- [Bundled dependency notices](public/third-party-notices.txt)

## Verification

Run `composer test` in each changed project. Once all those checks pass, run `composer test:browser` in docs and wait for completion. Use `npm run build` after frontend changes; it also refreshes third-party license notices.

Package architecture tests run under Pest 4/Testbench; docs feature/browser tests retain Pest 5. Tests use deterministic values, fake storage for file validation, and isolated browser contexts. They do not require production records or permanent file storage.
