<div data-date-example>
    <form wire:submit="save" novalidate class="space-y-5">
        @if ($showControls)
            <div wire:key="date-controls" class="space-y-5">
                <x-sirius::datetime-picker :id="$this->getId().'-departure'" name="departure" label="Departure date"
                    min-date="2028-01-01" max-date="2028-12-31" :disabled-dates="['2028-03-01']" :week-start="1" required helper="Choose your travel day. No departures on 1 March."
                    wire:model.live.debounce.150ms="departure" :readonly="$locked" :disabled="$disabled" data-date-departure />
                <x-sirius::datetime-picker :id="$this->getId().'-reminder'" name="reminder" label="Reminder"
                    type="time" min-time="08:00" max-time="20:00" :minute-increment="15" helper="Set your reminder time."
                    wire:model.live.debounce.150ms="reminder" :readonly="$locked" :disabled="$disabled" data-date-reminder />
                <x-sirius::datetime-picker :id="$this->getId().'-appointment'" name="appointment" label="Jadwal konsultasi"
                    type="datetime" min-date="2028-01-01 00:00:00" max-date="2029-12-31 23:59:59" timezone="Asia/Jakarta" locale="id" required helper="Jadwalkan konsultasi menggunakan zona waktu lokal Asia/Jakarta."
                    wire:model.live.debounce.150ms="appointment" display-format="d F Y H:i:S" :readonly="$locked" :disabled="$disabled" data-date-appointment />
            </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <flux:button type="submit">Submit / Validate</flux:button>
            <flux:button wire:click="loadExample" type="button">Load Value</flux:button>
            <flux:button wire:click="resetExample" type="button">Reset Sample</flux:button>
            <flux:button wire:click="$toggle('locked')" type="button">Toggle Readonly</flux:button>
        </div>
        <p role="status">Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Travel dates validated. Nothing was stored.</p>@endif
    </form>
</div>
