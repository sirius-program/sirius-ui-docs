<x-docs-code language="PHP">public bool $reviewing = false;

public function reviewInvoice(): void
{
    $this-&gt;dispatch('dialog:show', id: 'invoice-review');
}

public function closeReview(): void
{
    $this-&gt;dispatch('dialog:hide', id: 'invoice-review');
}</x-docs-code>
<x-docs-code>&lt;x-sirius::button wire:click="reviewInvoice"&gt;Review invoice&lt;/x-sirius::button&gt;
&lt;x-sirius::dialog id="invoice-review" wire:key="invoice-review"
    header="Invoice #1042" body="The invoice is ready for review." /&gt;

&lt;x-sirius::button wire:click="$set('reviewing', true)"&gt;Review invoice&lt;/x-sirius::button&gt;
&lt;x-sirius::dialog id="bound-invoice" wire:key="bound-invoice"
    header="Invoice #1042" body="The invoice is ready for review." :open="$reviewing"
    x-on:dialog:close="if ($event.target === $el &amp;&amp; $wire.reviewing) $wire.set('reviewing', false)" /&gt;</x-docs-code>
