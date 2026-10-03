<x-docs-code language="Blade">&lt;x-sirius::button wire:click="$set('reviewing', true)"&gt;Review invoice&lt;/x-sirius::button&gt;
&lt;x-sirius::dialog id="invoice" wire:key="invoice-dialog" header="Invoice" :open="$reviewing"
    x-on:dialog:close="if ($event.target === $el &amp;&amp; $wire.reviewing) $wire.set('reviewing', false)"&gt;
    Invoice details
&lt;/x-sirius::dialog&gt;</x-docs-code>
