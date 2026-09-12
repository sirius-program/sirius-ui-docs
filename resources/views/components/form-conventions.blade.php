<x-layouts::app title="Form conventions">
    <article class="mx-auto flex max-w-4xl flex-col gap-8">
        <header class="space-y-2">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM FOUNDATION</p>
            <h1 class="text-3xl font-semibold">Form conventions</h1>
            <p>Consistent labels, helper text, errors, and accessible relationships across your forms.</p>
        </header>
        <section class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
            <h2 class="text-xl font-medium">Livewire validation</h2>
            <p>Submit an empty or invalid address, correct it, then reset. Readonly preserves the value while preventing editing.</p>
            <livewire:examples.field-example />
        </section>
        <section class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
            <h2 class="text-xl font-medium">Ordinary Blade form</h2>
            <p>This example uses a nested HTML name and Laravel's named <code>profile</code> error bag. Nothing is persisted.</p>
            <form method="POST" action="{{ route('components.forms.validate') }}" novalidate class="space-y-4">
                @csrf
                <x-sirius::field id="plain-email" name="contact[email]" label="Contact email" helper="A working address for this example."
                    error-bag="profile" type="email" required :value="old('contact.email')" autocomplete="email">
                    <input {{ $component->controlAttributes() }}>
                </x-sirius::field>
                <flux:button type="submit">Validate Blade form</flux:button>
                @if (session('form-success'))<p role="status">{{ session('form-success') }}</p>@endif
            </form>
        </section>
        <section class="space-y-4">
            <h2 class="text-xl font-medium">The shared field</h2>
            <pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::field id="email" name="email" label="Email"
    helper="We will keep it private." required wire:model="email"&gt;
    &lt;input type="email" {{ $component-&gt;controlAttributes() }}&gt;
&lt;/x-sirius::field&gt;@endverbatim</code></pre>
            <p><code>field</code> is the low-level composition API. Apply its scoped <code>$component->controlAttributes()</code> bag exactly once to the native control. Future input components will encapsulate this composition.</p>
            <p>Supply an explicit, stable, unique <code>id</code>, including a record key for repeated fields. Invoke this method directly inside the field slot: nested Blade components change the scoped <code>$component</code>.</p>
        </section>
        <section class="space-y-4">
            <h2 class="text-xl font-medium">Inline controls and groups</h2>
            <x-sirius::field id="demo-consent" layout="inline" label="Send me product updates" helper="You can change this preference later.">
                <input type="checkbox" {{ $component->controlAttributes() }}>
            </x-sirius::field>
            <x-sirius::field id="demo-channels" group label="Contact channels" helper="Choose the channels that suit you.">
                <div class="flex flex-wrap gap-4">
                    <div><input id="demo-channel-email" type="checkbox" name="channels[]" value="email"> <x-sirius::label for="demo-channel-email">Email</x-sirius::label></div>
                    <div><input id="demo-channel-sms" type="checkbox" name="channels[]" value="sms"> <x-sirius::label for="demo-channel-sms">SMS</x-sirius::label></div>
                </div>
            </x-sirius::field>
            <p>These native controls demonstrate the layout foundation. Dedicated checkbox, radio, and switch components belong to Phase 2.</p>
            <p>A group renders a fieldset and legend. Give its controls their own IDs, names, labels, and bindings; do not call <code>controlAttributes()</code> for a group. Group required marks the legend only. Enforce at-least-one checkbox selection on the server, rather than marking every option required.</p>
            <pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::field id="channels" group label="Channels" helper="Choose one or more"&gt;
    &lt;input type="checkbox" id="email-option" name="channels[]" value="email"&gt;
    &lt;x-sirius::label for="email-option"&gt;Email&lt;/x-sirius::label&gt;
&lt;/x-sirius::field&gt;@endverbatim</code></pre>
        </section>
        <section class="space-y-4">
            <h2 class="text-xl font-medium">Props and behavior</h2>
            <dl class="grid gap-x-6 gap-y-3 sm:grid-cols-[12rem_1fr]">
                <dt class="font-medium">id</dt><dd>Required stable control ID; group mode uses it on the fieldset. Helper and error IDs append <code>-helper</code> and <code>-error</code>.</dd>
                <dt class="font-medium">label / helper</dt><dd>Optional escaped strings. Empty strings omit their elements. Helper and errors can appear together.</dd>
                <dt class="font-medium">name</dt><dd>Optional native control name. Bracket names such as <code>contacts[0][email]</code> map to dotted error keys.</dd>
                <dt class="font-medium">required / disabled / readonly</dt><dd>Boolean, default false. Forwarded to a single control. Group disabled applies to its fieldset. Native readonly does not prevent checkbox/radio changes; their custom readonly behavior belongs to Phase 2.</dd>
                <dt class="font-medium">error-key / error-bag</dt><dd>Explicit key overrides the <code>wire:model</code> path, which overrides the normalized name. The bag defaults to <code>default</code>. All messages for that key are rendered.</dd>
                <dt class="font-medium">errors</dt><dd>Optional ViewErrorBag override. Normally Laravel or Livewire supplies it automatically.</dd>
                <dt class="font-medium">layout / size</dt><dd><code>stacked</code> (default) or <code>inline</code>; <code>sm</code>, <code>md</code> (default), or <code>lg</code>.</dd>
                <dt class="font-medium">group / wrapper-class</dt><dd>Group defaults to false. Wrapper classes affect layout; the ordinary <code>class</code> attribute applies to the control.</dd>
            </dl>
            <p>Unconsumed HTML, data, ARIA, Alpine, and Livewire attributes go to the single control through its bag. Existing <code>aria-describedby</code> references are retained alongside helper/error IDs. The field manages <code>aria-invalid</code> from validation. Supply an accessible name yourself when omitting the label.</p>
            <p>Group mode accepts label/helper/error and wrapper props; set individual control attributes inside its slot. Field adds no custom events or value conversion. Native form submission applies, including omission of disabled controls.</p>
        </section>
        <section class="space-y-4">
            <h2 class="text-xl font-medium">Sizes and states</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                <x-sirius::field id="size-small" label="Small" size="sm"><input {{ $component->controlAttributes() }} value="Compact"></x-sirius::field>
                <x-sirius::field id="state-disabled" label="Disabled" disabled><input {{ $component->controlAttributes() }} value="Unavailable"></x-sirius::field>
                <x-sirius::field id="state-readonly" label="Readonly" readonly size="lg"><input {{ $component->controlAttributes() }} value="Still submitted"></x-sirius::field>
            </div>
            <p>Styles support light/dark themes and keyboard focus. Override <code>--sir-color-danger</code>, <code>--sir-color-muted</code>, <code>--sir-color-border</code>, <code>--sir-focus-ring</code>, and <code>--sir-field-gap</code> in application CSS.</p>
        </section>
    </article>
</x-layouts::app>
