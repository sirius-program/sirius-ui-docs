<x-layouts::app title="Phone">
    <x-docs-page :navigation="['Phone' => ['phone-demo' => 'Demo', 'phone-usage' => 'Usage', 'phone-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'validation-rules' => 'Validation rules', 'assets-and-interaction' => 'Assets and interaction', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="phone">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Phone</h1>
                <p>Phone input with country selection and international values, powered by <a href="https://github.com/catamphetamine/libphonenumber-js" target="_blank" class="text-blue-500 dark:text-blue-400 hover:underline">libphonenumber-js</a>.</p>
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
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                <p>Bind a nullable string. Valid numbers produce E.164, such as <code>+6281234567890</code>; empty or invalid drafts produce <code>null</code>. Native forms submit an empty string instead. Draft text stays visible, with feedback on blur or submit.</p>
            </section>
            <section id="validation-rules" class="space-y-3">
                <h2 class="text-xl font-medium">Validation rules</h2>
                <p>The optional <code>Sirius\Ui\Rules\PhoneNumber</code> rule checks international syntax (8-15 digits) and allowed calling codes. It does not verify national numbering plans or whether a number is reachable.</p>
                <p>Pass calling codes without <code>+</code>, such as <code>62</code>. An empty list allows all codes. The rule is independent of the country prop and cannot distinguish countries sharing a calling code. Combine it with <code>required</code> or <code>nullable</code>.</p>
                @include('blade-components.examples.phone-validation')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>libphonenumber-js and its numbering data are bundled. JavaScript is required to submit the phone value.</p>
                <p>Enter a local or international number. Country changes preserve national digits. International input changes country only when the match is unambiguous and allowed. Extensions, short codes, and non-geographic numbers are unsupported.</p>
                <p>Readonly prevents number and country changes while keeping the submitted value. Disabled fields are omitted.</p>
                <p>Use string bindings without number, boolean, or trim modifiers. Change <code>reset-key</code> to clear partial drafts on server reset, and use stable IDs. For JavaScript updates, set <code>[data-sir-phone-model].value</code> and dispatch <code>input</code>. The <code>phone:change</code> event includes value and country.</p>
                <p>For Blade redirects, set <code>draft-name</code> and restore the validated text/country object through <code>draft</code>. Use it for redisplay, not as the saved phone number.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Country selects the numbering region, not the UI language. Regional locales use their region. Language mappings: <code>en: US, ja: JP, ko: KR, zh: CN, vi: VN, uk: UA, el: GR, ar: SA, he: IL</code>. Other supported country codes resolve directly, including <code>id: ID</code> and <code>ca: CA</code>. Use an explicit country when ambiguous.</p>
                <p>Country falls back through <code>sirius-ui.phone_country &rarr; sirius-ui.locale &rarr; app.locale &rarr; app.fallback_locale &rarr; US</code>. Props take priority. <code>*</code> sorts countries by calling code and uses the fallback chain for its initial choice. Arrays keep their order and start with the first country. Comma-separated environment values are unsupported.</p>
                @include('blade-components.examples.phone-config')
                <h3 class="font-medium">Translations</h3>
                <p>Publish translations and edit <code>lang/vendor/sirius/{locale}/validation.php</code>. Keys are <code>phone_number</code> and <code>phone_country</code>; preserve <code>:attribute</code> when used. Messages follow the application locale, independently of the selected country.</p>
                @include('blade-components.examples.phone-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
