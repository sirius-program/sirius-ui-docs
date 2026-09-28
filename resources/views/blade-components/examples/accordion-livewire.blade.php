<x-docs-code language="Blade">&lt;x-sirius::accordion id="shipping" wire:key="shipping" trigger="Shipping details" :open="$expanded"
    x-on:accordion:toggle="if ($event.target === $el &amp;&amp; $wire.expanded !== $event.detail.open) $wire.set('expanded', $event.detail.open)"&gt;
    Delivery takes 3–5 business days.
&lt;/x-sirius::accordion&gt;</x-docs-code>
