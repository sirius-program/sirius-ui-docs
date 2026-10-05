<div class="space-y-4" data-bulk-host="{{ $tableId }}">
    <livewire:examples.bulk-invoice-table :id="$tableId" record-label="invoices" :loading="$loading" />
    <p id="{{ $tableId }}-feedback" role="status">{{ $feedback }}</p>
    @error('ids')<p role="alert">{{ $message }}</p>@enderror
    @if ($linkedNumbers !== [])
        <section id="linked-selection" class="space-y-2" tabindex="-1"><h3 class="font-medium">Linked selection</h3><p>{{ implode(', ', $linkedNumbers) }}</p></section>
    @endif
    <div>
        <x-sirius::dialog :id="$tableId.'-review'" header="Review selected invoices" x-on:dialog:close="$wire.cancelReview()" wire:key="{{ $tableId }}-review">
            <form wire:submit="beginReview" class="space-y-4" novalidate>
                <p>{{ implode(', ', $numbers) }}</p>
                <x-sirius::textarea :id="$tableId.'-note'" label="Review note" wire:model="note" :readonly="$loading" required />
                @error('ids')<p role="alert">{{ $message }}</p>@enderror
                @if (!$loading)<x-sirius::button type="submit" variant="primary">Start review</x-sirius::button>@endif
            </form>
            <x-slot:footer>
                <div class="flex flex-wrap gap-2">
                    @if ($loading)
                        <x-sirius::button variant="primary" wire:click="completeReview">Complete review</x-sirius::button>
                        <x-sirius::button variant="danger" wire:click="completeReview(true)">Simulate failure</x-sirius::button>
                    @endif
                    <x-sirius::button data-sir-dialog-close>Cancel</x-sirius::button>
                </div>
            </x-slot:footer>
        </x-sirius::dialog>
    </div>
    <div>
        <x-sirius::alert :id="$tableId.'-confirm'" title="Prepare invoice reminders" :text="implode(', ', $numbers) ?: 'Choose invoices to prepare reminders.'" icon="heroicon-o-envelope" wire:key="{{ $tableId }}-confirm">
            <x-slot:footer><div class="flex flex-wrap gap-2"><x-sirius::button variant="primary" wire:click="prepareReminders">Prepare reminders</x-sirius::button><x-sirius::button data-sir-dialog-close>Cancel</x-sirius::button></div></x-slot:footer>
        </x-sirius::alert>
    </div>
    <x-sirius::slideover :id="$tableId.'-details'" header="Selected invoices" wire:key="{{ $tableId }}-details"><p>{{ implode(', ', $numbers) }}</p><x-slot:footer><x-sirius::button data-sir-dialog-close>Close</x-sirius::button></x-slot:footer></x-sirius::slideover>
</div>
