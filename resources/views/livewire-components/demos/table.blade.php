<div class="space-y-4">
    <livewire:examples.invoice-table id="invoice-table" record-label="invoices" :loading="$loading" />
    <p id="table-feedback" role="status">{{ $feedback }}</p>
    <div>
        <x-sirius::dialog id="invoice-review" header="Review invoice" wire:key="invoice-review">
            <form wire:submit="saveReview" class="space-y-4" novalidate>
                <p>{{ $number }}</p>
                <x-sirius::textarea id="invoice-note" label="Review note" wire:model="note" required />
                <x-sirius::button type="submit" variant="primary">Save review</x-sirius::button>
            </form>
        </x-sirius::dialog>
    </div>
    <div>
        <x-sirius::alert id="invoice-confirm" title="Invoice reminder" :text="'Send a reminder for '.$number.'?'" icon="heroicon-o-envelope" wire:key="invoice-confirm">
            <x-slot:footer><x-sirius::button data-sir-dialog-close>Cancel</x-sirius::button></x-slot:footer>
        </x-sirius::alert>
    </div>
    <x-sirius::slideover id="invoice-details" header="Invoice details" wire:key="invoice-details"><p>{{ $number }}</p><p>Check the customer and payment status before sending a reminder.</p></x-sirius::slideover>
</div>
