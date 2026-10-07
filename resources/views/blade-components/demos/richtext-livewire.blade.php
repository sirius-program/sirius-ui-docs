<form wire:submit="save" novalidate class="space-y-5" data-richtext-example>
    @if ($visible)
        <x-sirius::richtext :reset-key="$richtextRevision" id="announcement" wire:model="body" label="Team announcement" :toolbar="['bold', 'italic', 'underline', 'strike', 'heading', 'bulletList', 'orderedList', 'blockquote', 'codeBlock', 'link', 'image', 'undo', 'redo']" :upload-url="route('blade-components.richtext.images.store')" required :readonly="$locked" placeholder="Share the latest project update…" helper="Format the update before sharing it with your team." maxlength="10000" />
        <x-sirius::richtext :reset-key="$richtextRevision" id="signature" wire:model.live="signature" label="Signature" :toolbar="['bold', 'italic', 'link']" :height="100" :readonly="$locked" maxlength="2000" />
    @endif
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit">Submit / Validate</x-sirius::button>
        <x-sirius::button type="button" wire:click="loadExample">Load Value</x-sirius::button>
        <x-sirius::button type="button" wire:click="resetExample">Reset Sample</x-sirius::button>
        <x-sirius::button type="button" wire:click="$toggle('locked')">Toggle Readonly</x-sirius::button>
    </div>
    <p data-richtext-readonly>Readonly: {{ $locked ? 'on' : 'off' }}</p>
    @if ($preview !== '')<div data-richtext-preview role="status"><p>Sanitized preview</p>{!! $preview !!}</div>@endif
</form>



