<x-layouts::app title="Label">
    <article class="mx-auto flex max-w-4xl flex-col gap-8">
        <header class="space-y-2">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM FOUNDATION</p>
            <h1 class="text-3xl font-semibold">Label</h1>
            <p>A clear name for every control, with an optional red required marker.</p>
        </header>
        <section class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
            <h2 class="text-xl font-medium">Required and optional</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <x-sirius::label for="label-required" required>Project name</x-sirius::label>
                    <input id="label-required" class="sir-control" required placeholder="My project">
                </div>
                <div class="space-y-2">
                    <x-sirius::label for="label-optional" :required="false">Reference (optional)</x-sirius::label>
                    <input id="label-optional" class="sir-control" placeholder="Internal reference">
                </div>
            </div>
        </section>
        <section class="space-y-3">
            <h2 class="text-xl font-medium">Usage</h2>
            <pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::label for="email" required&gt;Email&lt;/x-sirius::label&gt;
&lt;input id="email" type="email" required&gt;@endverbatim</code></pre>
            <p>When using a standalone label, set <code>required</code> on the input too. The shared field does this for you.</p>
        </section>
        <section class="space-y-3">
            <h2 class="text-xl font-medium">Props and attributes</h2>
            <dl class="grid gap-3 sm:grid-cols-[10rem_1fr]">
                <dt class="font-medium">for</dt><dd>Optional ID of the related control.</dd>
                <dt class="font-medium">required</dt><dd>Boolean, default false. Append a red asterisk. Use <code>:required="false"</code> for an explicit false value.</dd>
                <dt class="font-medium">as</dt><dd>Default label; accepts label or legend. Use legend inside a fieldset.</dd>
                <dt class="font-medium">Default slot</dt><dd>Label content. Escape user-supplied strings with Blade echo syntax.</dd>
            </dl>
            <p>Other HTML attributes apply to the label. Classes merge with <code>sir-label</code>. The marker is hidden from assistive technology; required state belongs to the control. No JavaScript or custom events are needed.</p>
            <p>Customize <code>--sir-color-danger</code> to change the marker color consistently with field errors.</p>
            <a class="underline" href="{{ route('components.forms') }}" wire:navigate>Explore helper text and validation errors →</a>
        </section>
    </article>
</x-layouts::app>
