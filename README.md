# Sirius UI documentation

This application documents and tests the local `sirius/ui` package. Public components are added only after their implementation phases are completed.

## Local installation

Keep `sirius-ui` and `sirius-ui-docs` in sibling directories. Build the package with `npm ci` and `npm run build`, then run `composer install`, `npm ci`, and `npm run build` in docs. Provision application environment values yourself; agents must never access `.env` directly.

Docs uses a Composer path repository at `../sirius-ui`, mapped to `dev-main`. On Windows Composer creates a junction; elsewhere it uses a symlink. Source changes are immediately visible, but package assets must be rebuilt. After changing package Composer metadata, run `composer update sirius/ui --with-dependencies` in docs.

If linking is unavailable, set the repository's `options.symlink` to `false`, run `composer reinstall sirius/ui`, and repeat that reinstall after package edits to refresh the mirrored copy. Never edit files under `vendor`.

The docs stylesheet imports `vendor/sirius/ui/dist/sirius.css`, and `resources/js/app.js` imports `vendor/sirius/ui/dist/sirius.js`. Build package assets before building docs. The package script enables password visibility, readonly choice controls, and mixed checkbox state without depending on Alpine or Livewire JavaScript. Widget proofs use lazy, locally bundled JS/CSS imports; no runtime CDN is required and no second Alpine instance is installed. The existing docs layout uses Flux, but the package does not depend on Flux.

For applications without a bundler, run `php artisan vendor:publish --tag=sirius-ui-assets` and load `/vendor/sirius-ui/sirius.css` and `/vendor/sirius-ui/sirius.js` once. Refresh published assets after package upgrades, reviewing any local modifications first. The script handles later Livewire renders and navigation automatically.

## Navigation and component index

Documentation views live in resources/views/blade-components: examples contains copyable snippets, demos contains rendered Blade/Livewire demonstrations, and attributes contains property tables. Page views compose these partials; Livewire view entry points include the corresponding demo.

Each component follows **Demo → Usage → Attributes**, with **Shared field contract** and **Assets and interaction** where applicable. Livewire and ordinary Blade demos are stacked with matching controls and sample values. Both provide **Submit / Validate**, **Load Value**, and **Reset Sample**; only Livewire provides **Toggle Readonly**. Demos use workspace scenarios such as project setup, billing details, member access, and subscription selection. Each Usage block displays the exact source of its rendered Blade demo partial, with a separate Copy control for each scenario. Syntax highlighting runs locally, with a selection fallback when clipboard access is denied. Named session keys in these snippets are supplied by the docs demo controller; adapt the value bindings and validation bag to your application. A right-hand content navigator links to sections on wide screens and moves above the content on smaller screens. Documentation pages end with a simple footer. Props tables include types, defaults, descriptions, and component-specific attribute support notes.

Open `/getting-started` through **Getting Started**; component pages are grouped under **Blade Components**. The **Label** page is available at `/blade-components/label`. Shared field behavior is explained on the relevant component pages; the former Form Conventions page has been removed. Field validation regression fixtures are available at `/development/fields` only in local/testing environments.

Use `<x-sirius::label>` for standalone labels and `<x-sirius::field>` to compose a native control with labels, helpers, validation messages, and accessible IDs. Controls and fields generate a random five-character ID when omitted or null; provide a unique explicit ID when it must remain stable across server renders. Apply the field's scoped `$component->controlAttributes()` to the actual control. Inline and fieldset/legend layouts prepare the foundation for choice controls.

Phase 2 provides **Input** (text, number, and password) at `/blade-components/input`, **Textarea** at `/blade-components/textarea`, and **Checkbox, Radio & Switch** at `/blade-components/choices`. Each control has its own example and options section within the combined page. Former Password, Checkbox, Radio, and Switch URLs redirect to the appropriate combined page. Pages include interactive Livewire examples, native Blade usage, props, errors, readonly/disabled semantics, and keyboard guidance. Each control has an ordinary POST demo with isolated validation and sample values. A combined native form remains in the development integration fixture.

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
