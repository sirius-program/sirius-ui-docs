<p>A single checkbox binds to a boolean. Multiple checkboxes sharing a binding use array membership; give each its own ID and explicit value. String <code>0</code> remains a valid value.</p>
<pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::checkbox id="agree" name="agree" label="I agree"
    wire:model="agreed" required /&gt;
&lt;x-sirius::checkbox id="role-reader" name="roles[]" label="Reader"
    value="0" wire:model="roles" /&gt;
&lt;x-sirius::checkbox id="role-editor" name="roles[]" label="Editor"
    value="editor" wire:model="roles" /&gt;
&lt;x-sirius::checkbox id="mixed" label="Select rows" :indeterminate="$mixed" /&gt;@endverbatim</code></pre>
<p>Ordinary Blade supports <code>:checked="true"</code>. Unchecked inputs are omitted; checked inputs submit their explicit value (default <code>on</code>). Normalize boolean fields with <code>$request->boolean('agree')</code>. No hidden duplicate fields are inserted.</p>
<p><code>indeterminate</code> is independent of checked state and submission. User activation clears the visual mixed state; a changed server prop reapplies it. Native reset restores the current declared mixed state. Use a fieldset/legend with group validation for at-least-one selection; marking every option required would require every checkbox.</p>
<form class="space-y-3 rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
    <h3 class="font-medium">Ordinary Blade choices</h3>
    <x-sirius::checkbox id="native-consent" name="consent" label="Consent" value="1" checked />
    <x-sirius::checkbox id="native-reader" name="roles[]" label="Reader" value="0" />
    <x-sirius::checkbox id="native-editor" name="roles[]" label="Editor" value="editor" />
    <flux:button type="reset">Reset native choices</flux:button>
</form>
<p>These controls use native checked state without Livewire bindings. <a class="underline" href="{{ route('components.control', ['control' => 'input']) }}" wire:navigate>Try the complete ordinary Blade POST example.</a></p>
