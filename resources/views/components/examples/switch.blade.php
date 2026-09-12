<p>A switch is a native checkbox with <code>role="switch"</code> and an on/off appearance. It binds to a boolean and supports keyboard and label activation. It has no mixed state and is not an HTML <code>type="switch"</code>.</p>
<pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::switch id="notifications" name="notifications"
    label="Enable notifications" helper="Send product updates"
    wire:model="notifications" /&gt;

&lt;x-sirius::switch id="plain-enabled" name="enabled" label="Enabled"
    value="1" :checked="true" :readonly="$locked" /&gt;@endverbatim</code></pre>
<p>Native checked state provides its accessible on/off state. Do not add a separate <code>aria-checked</code> binding. Unchecked switches are omitted from ordinary submission; use <code>$request->boolean('enabled')</code> to normalize them. Required means the switch must be on; disabled omits it from submission, while readonly preserves submission and focus.</p>
<form class="space-y-3 rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
    <h3 class="font-medium">Ordinary Blade choices</h3>
    <x-sirius::switch id="native-switch" name="enabled" label="Enabled by default" value="1" checked />
    <x-sirius::switch id="native-switch-disabled" label="Disabled" disabled />
    <flux:button type="reset">Reset native choices</flux:button>
</form>
<p><a class="underline" href="{{ route('components.control', ['control' => 'input']) }}" wire:navigate>Try the complete ordinary Blade POST example.</a></p>
