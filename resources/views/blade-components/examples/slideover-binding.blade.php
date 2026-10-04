<x-docs-code language="PHP">public bool $reviewing = false;

public function reviewDelivery(): void
{
    $this-&gt;dispatch('dialog:show', id: 'delivery-review');
}

public function closeReview(): void
{
    $this-&gt;dispatch('dialog:hide', id: 'delivery-review');
}</x-docs-code>
<x-docs-code>&lt;x-sirius::button wire:click="reviewDelivery"&gt;Review delivery&lt;/x-sirius::button&gt;
&lt;x-sirius::slideover id="delivery-review" wire:key="delivery-review"
    header="Delivery details" body="Your order will arrive on Friday." /&gt;

&lt;x-sirius::button wire:click="$set('reviewing', true)"&gt;Review delivery&lt;/x-sirius::button&gt;
&lt;x-sirius::slideover id="bound-delivery" wire:key="bound-delivery"
    header="Delivery details" body="Your order will arrive on Friday." :open="$reviewing"
    x-on:dialog:close="if ($event.target === $el &amp;&amp; $wire.reviewing) $wire.set('reviewing', false)" /&gt;</x-docs-code>
