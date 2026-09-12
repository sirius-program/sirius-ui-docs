<p>Options share a native name and Livewire property but have distinct IDs and values. A group submits one selected value; no initial selection is supported. Disabled options cannot be selected. Keep value types consistent; use explicit Livewire casting only when your property expects it.</p>
<pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::field id="plans" group label="Plan" helper="Choose one" error-key="plan" required&gt;
    &lt;x-sirius::radio id="free" name="plan" label="Free" value="0" wire:model="plan" required /&gt;
    &lt;x-sirius::radio id="pro" name="plan" label="Pro" value="pro" wire:model="plan" required /&gt;
&lt;/x-sirius::field&gt;@endverbatim</code></pre>
<p>For ordinary Blade, select an initial option with <code>:checked="old('plan') === '0'"</code>. Required on the native group means exactly one choice is needed. The fieldset provides the group label and helper/error association. Use different names for independent groups, including repeated component instances.</p>
<form class="space-y-3 rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
    <h3 class="font-medium">Ordinary Blade choices</h3>
    <x-sirius::field id="native-plans" group label="Subscription" helper="A separate native radio group.">
        <x-sirius::radio id="native-plan-free" name="native-plan" label="Free" value="0" checked />
        <x-sirius::radio id="native-plan-pro" name="native-plan" label="Pro" value="pro" />
    </x-sirius::field>
    <flux:button type="reset">Reset native choices</flux:button>
</form>
<p><a class="underline" href="{{ route('components.control', ['control' => 'input']) }}" wire:navigate>Try the complete ordinary Blade POST example.</a></p>
