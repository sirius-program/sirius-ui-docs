<div class="space-y-4">
    @if ($visible)
        @include('livewire-components.demos.calendar-control')
    @endif
    <div class="flex flex-wrap gap-2">
        <x-sirius::button wire:click="$dispatch('calendar:refresh.{{ $calendarId }}')">Refresh events</x-sirius::button>
        <x-sirius::button wire:click="$dispatch('calendar:rejection.{{ $calendarId }}')">Toggle rejected changes</x-sirius::button>
        <x-sirius::button wire:click="$dispatch('calendar:timezone.{{ $calendarId }}')">Switch timezone</x-sirius::button>
    </div>
    <p role="status" data-calendar-feedback-example>{{ $feedback }} Changes: {{ $rejected ? 'rejected' : 'accepted' }}.</p>
    <p>Plan team sessions in Asia/Jakarta. Click a date to create a session, or an event to edit it. Drag or resize a session to reschedule it. Sample changes are stored in this browser session. In your app, query scoped records and authorize changes before saving.</p>
    <x-sirius::dialog :id="$calendarId.'-edit'" header="Planning session" size="lg">
        <form wire:submit="save" class="space-y-4">
            <x-sirius::input :id="$calendarId.'-title'" label="Title" wire:model="title" required />
            <x-sirius::datetime-picker :id="$calendarId.'-start'" label="Start" type="datetime" :timezone="$timezone" wire:model="start" required />
            <x-sirius::datetime-picker :id="$calendarId.'-end'" label="End (exclusive)" type="datetime" :timezone="$timezone" wire:model="end" required />
            <x-sirius::checkbox :id="$calendarId.'-all-day'" label="All day" wire:model="allDay" />
            <div class="flex flex-wrap gap-2">
                <x-sirius::button type="submit" variant="primary">Save session</x-sirius::button>
                @if ($eventId !== null)<x-sirius::button variant="danger" wire:click="remove">Delete session</x-sirius::button>@endif
                <x-sirius::button :data-sir-dialog-close="$calendarId.'-edit'">Cancel</x-sirius::button>
            </div>
        </form>
    </x-sirius::dialog>
</div>
