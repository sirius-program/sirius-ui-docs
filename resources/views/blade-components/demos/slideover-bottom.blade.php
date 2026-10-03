<div data-slideover-form="blade" class="inline-block">
    <x-sirius::button data-sir-dialog-open="billing-summary">Bottom</x-sirius::button>
    <x-sirius::slideover id="billing-summary" header="Billing summary" side="bottom">
        <p>Invoice #1042 totals $120.00. Payment is due on October 15.</p>
        <x-slot:footer><x-sirius::button data-sir-dialog-close>Close</x-sirius::button></x-slot:footer>
    </x-sirius::slideover>
</div>