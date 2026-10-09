<x-layouts::app title="Phone">
    <x-docs-page :navigation="['Phone' => ['phone-demo' => 'Demo', 'phone-usage' => 'Usage', 'phone-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'validation-rules' => 'Validation rules', 'global-configuration' => 'Global configuration', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="phone">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Phone</h1>
                <p>Phone input with country selection and international values, powered by <x-sirius::link href="https://github.com/catamphetamine/libphonenumber-js" target="_blank" rel="noopener noreferrer">libphonenumber-js</x-sirius::link>.</p>
            </header>
            <section id="phone-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3><livewire:examples.phone-example />
                </div>
                <div id="phone-blade" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>@include('blade-components.demos.phone-blade')
                </div>
            </section>
            <section id="phone-usage" class="space-y-4"><h2 class="text-xl font-medium">Usage</h2>@include('blade-components.examples.phone')</section>
            <section id="phone-attributes">@include('blade-components.attributes.phone')</section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>libphonenumber-js and its numbering data are bundled. JavaScript is required to submit the phone value.</p>
                <p>Enter a local or international number. Country changes preserve national digits. International input changes country only when the match is unambiguous and allowed. Extensions, short codes, and non-geographic numbers are unsupported.</p>
                <p>Readonly prevents number and country changes while keeping the submitted value. Disabled fields are omitted.</p>
                <p>Use string bindings without number, boolean, or trim modifiers. Change <x-sirius::code>reset-key</x-sirius::code> to clear partial drafts on server reset, and use stable IDs. For JavaScript updates, set <x-sirius::code>[data-sir-phone-model].value</x-sirius::code> and dispatch <x-sirius::code>input</x-sirius::code>. The <x-sirius::code>phone:change</x-sirius::code> event includes value and country.</p>
                <p>For Blade redirects, set <x-sirius::code>draft-name</x-sirius::code> and restore the validated text/country object through <x-sirius::code>draft</x-sirius::code>. Use it for redisplay, not as the saved phone number.</p>
            </section>
            <section id="validation-rules" class="space-y-3">
                <h2 class="text-xl font-medium">Validation rules</h2>
                <p>The optional <x-sirius::code>Sirius\Ui\Rules\PhoneNumber</x-sirius::code> rule checks international syntax (8-15 digits) and allowed calling codes. It does not verify national numbering plans or whether a number is reachable.</p>
                <p>Pass calling codes without <x-sirius::code>+</x-sirius::code>, such as <x-sirius::code>62</x-sirius::code>. An empty list allows all codes. The rule is independent of the country prop and cannot distinguish countries sharing a calling code. Combine it with <x-sirius::code>required</x-sirius::code> or <x-sirius::code>nullable</x-sirius::code>.</p>
                @include('blade-components.examples.phone-validation')
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Country selects the numbering region, not the UI language. Regional locales use their region. Language mappings: <x-sirius::code>en: US, ja: JP, ko: KR, zh: CN, vi: VN, uk: UA, el: GR, ar: SA</x-sirius::code>. Other supported country codes resolve directly, including <x-sirius::code>id: ID</x-sirius::code> and <x-sirius::code>ca: CA</x-sirius::code>. Use an explicit country when ambiguous.</p>
                <p>Country falls back through <x-sirius::code>sirius-ui.phone_country &rarr; sirius-ui.locale &rarr; app.locale &rarr; app.fallback_locale &rarr; US</x-sirius::code>. Props take priority. <x-sirius::code>*</x-sirius::code> sorts countries by calling code and uses the fallback chain for its initial choice. Arrays keep their order and start with the first country. Comma-separated environment values are unsupported.</p>
                @include('blade-components.examples.phone-config')
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>These are translation string used for client-side validation and messages, for server-side use Laravel's translation string.</p>
                <p>Edit the <x-sirius::code>phone</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>.</p>
                @include('blade-components.examples.phone-ui-translations')
                <p>If you use the <x-sirius::code>Sirius\Ui\Rules\PhoneNumber</x-sirius::code> rule, you can edit the validation messages. Publish translations and edit <x-sirius::code>lang/vendor/sirius/{locale}/validation.php</x-sirius::code>. Keys are <x-sirius::code>phone_number</x-sirius::code> and <x-sirius::code>phone_country</x-sirius::code>; preserve <x-sirius::code>:attribute</x-sirius::code> when used. Messages follow the application locale, independently of the selected country.</p>
                @include('blade-components.examples.phone-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
