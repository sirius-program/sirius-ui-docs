<x-layouts::app title="Phone">
    <x-docs-page :navigation="['Phone' => ['phone-demo' => 'Demo', 'phone-usage' => 'Usage', 'phone-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'validation-rules' => 'Validation rules', 'assets-and-interaction' => 'Assets and interaction', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="phone">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Phone</h1>
                <p>Using <a href="https://github.com/catamphetamine/libphonenumber-js" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">libphonenumber-js</a> under the hood, a country-aware phone input with an international submitted value.</p>
            </header>
            <section id="phone-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3><livewire:examples.phone-example />
                </div>
                <div id="phone-blade" class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>@include('blade-components.demos.phone-blade')
                </div>
            </section>
            <section id="phone-usage" class="space-y-4"><h2 class="text-xl font-medium">Usage</h2>@include('blade-components.examples.phone')</section>
            <section id="phone-attributes">@include('blade-components.attributes.phone')</section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Controls automatically associate labels, helpers, and validation errors. Laravel or Livewire supplies the error bags; application validation remains authoritative.</p>
                <p>Bind a nullable string. A valid number produces E.164, for example <code>+6281234567890</code>; an empty or invalid draft produces <code>null</code>. Native forms submit an empty string, which Laravel normally converts to null. Draft text remains visible through validation and re-renders. Feedback appears on blur or submit.</p>
            </section>
            <section id="validation-rules" class="space-y-3">
                <h2 class="text-xl font-medium">Validation rules</h2>
                <p>The demos use the optional package rule <code>Sirius\Ui\Rules\PhoneNumber</code> to validate international syntax (8–15 digits) and permitted calling-code prefixes on the server. The rule does not verify national numbering plans, ownership, or reachability; applications must add the server-side numbering-plan and verification rules their workflow requires. The demos use <code>novalidate</code> to show server errors. Nothing is persisted.</p>
                <p>Pass calling codes as strings without <code>+</code>, not country codes. An empty list allows any calling-code prefix. Restrictions are independent of the component's country setting; countries sharing a calling code are not distinguished. Combine the rule with <code>required</code> or <code>nullable</code> as needed.</p>
                @include('blade-components.examples.phone-validation')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package stylesheet and JavaScript once in your application build, or publish <code>sirius-ui-assets</code> and load the published CSS and JavaScript.</p>
                @include('blade-components.examples.assets')
                <p>libphonenumber-js 1.13.13 and its complete numbering metadata are bundled internally. Retain the MIT and Apache-2.0 notices. No CDN, API key, or geolocation request is required. JavaScript is required for canonical submission; without it, the phone value is not submitted.</p>
                <p>Enter a local number or paste an international number. Valid numbers are grouped using country metadata. A national trunk prefix is normalized by the library. Switching countries preserves national digits and recalculates validity. International numbers switch country only when identification is unambiguous and the country is allowed. Extensions, short codes, and non-geographic numbers are unsupported.</p>
                <p>The selected country prefix has a fixed five-character text width with ellipsis; the native dropdown shows full calling-code and country labels. Tab focuses the number and country select; use native select keyboard controls to change country. Disabled controls are omitted from submission. Readonly controls prevent number and country changes while retaining canonical submission.</p>
                <p>Use nullable string model bindings without number, boolean, or trim modifiers. The model bridge preserves null for Alpine and Livewire and forwards input/change/blur/Enter timing. Set <code>reset-key</code> to a new value on an explicit server reset, including when a partial draft already has a null canonical value. Use stable IDs across Livewire renders. For native JavaScript updates, assign the canonical value to <code>[data-sir-phone-model].value</code>; dispatch input there when bindings should update. <code>phone:change</code> exposes value and country in its event detail.</p>
                <p>For ordinary Blade redirects, opt into <code>draft-name</code> and pass the validated draft object back through <code>draft</code>. The separate JSON draft contains text and country for redisplay only; never persist it as the phone number. Treat this client payload as untrusted and validate its shape, length, and allowed country, as the demo controller does.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish the package configuration to customize defaults in your application. The country prop selects a numbering country, not the display language. Country codes are case-insensitive; regional locales use their region. Language-only mappings are <code>en → US, ja → JP, ko → KR, zh → CN, vi → VN, uk → UA, el → GR, ar → SA, he → IL</code>. Other two-letter values that are supported country codes resolve directly, including <code>id → ID</code>. Country codes take priority in ambiguous cases such as <code>ca → CA</code>. Unmapped values are rejected; use an explicit region when in doubt.</p>
                <p>Explicit country overrides sirius-ui.phone_country, then sirius-ui.locale, app.locale, app.fallback_locale, and finally US. A wildcard offers all supported countries sorted numerically by calling code (then country name for ties), with labels such as +62 - Indonesia and gets its initial country from the global fallback chain, skipping wildcard entries. Arrays preserve order and use the first country initially. No automatic comma-separated environment parsing is performed.</p>
                @include('blade-components.examples.phone-config')
                <h3 class="font-medium">Translations</h3>
                <p>Customize rule messages through <code>sirius::validation.phone_number</code> and <code>sirius::validation.phone_country</code>. Publish the translations, then edit <code>lang/vendor/sirius/en/validation.php</code> or add the file for your application locale, such as <code>id</code>. Laravel's active locale and fallback locale control these messages independently of the phone country. The optional <code>:attribute</code> placeholder uses your validation attribute name.</p>
                @include('blade-components.examples.phone-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
