<form wire:submit="save" novalidate class="space-y-5" data-richtext-example>
    @if ($visible)
        <x-sirius::richtext :reset-key="$richtextRevision" id="announcement" wire:model="body" label="Team announcement" :toolbar="['bold', 'italic', 'underline', 'strike', 'heading', 'bulletList', 'orderedList', 'blockquote', 'codeBlock', 'link', 'image', 'undo', 'redo']" :upload-url="route('blade-components.richtext.images.store')" required :readonly="$locked" placeholder="Share the latest project update…" helper="Format the update before sharing it with your team." maxlength="10000" />
        <x-sirius::richtext :reset-key="$richtextRevision" id="signature" wire:model.live="signature" label="Signature" :toolbar="['bold', 'italic', 'link']" :height="100" :readonly="$locked" maxlength="2000" />
    @endif
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit">Submit / Validate</flux:button>
        <flux:button type="button" wire:click="loadExample">Load Value</flux:button>
        <flux:button type="button" wire:click="resetExample">Reset Sample</flux:button>
        <flux:button type="button" wire:click="$toggle('locked')">Toggle Readonly</flux:button>
    </div>
    <p data-richtext-readonly>Readonly: {{ $locked ? 'on' : 'off' }}</p>
    @if ($preview !== '')<div data-richtext-preview role="status"><p>Sanitized preview</p>{!! $preview !!}</div>@endif
</form>



