<div data-upload-example>
    <form wire:submit="save" novalidate class="space-y-5">
        <x-sirius::file-upload :id="$this->getId().'-brief'" name="brief" label="Project brief" required
            accept="application/pdf,text/plain" :max-size="2048" helper="Upload a PDF or text document up to 2 MiB."
            wire:model="brief" :readonly="$locked" :reset-key="$resetKey"
            :value="$existingBrief ? [['name' => 'sample.pdf', 'size' => 18810, 'url' => asset('sample/sample.pdf')]] : []"
            x-on:file-upload:remove-existing="$wire.set('existingBrief', false)" />
        <x-sirius::file-upload :id="$this->getId().'-attachments'" name="attachments" label="Supporting documents" multiple
            accept="application/pdf,text/plain,image/jpeg,image/png" :max-size="2048" :max-files="3" helper="Up to three PDF, text, JPEG, or PNG files, 2 MiB each."
            wire:model="attachments" :readonly="$locked" :reset-key="$resetKey" error-key="attachments.*"
            :value="$existingAttachments"
            x-on:file-upload:remove-existing="$wire.removeExistingAttachment($event.detail.name)" />
        <x-sirius::file-upload :id="$this->getId().'-artwork'" name="artwork" label="Project image"
            accept="image/jpeg,image/png" :max-size="2048" helper="Upload a JPEG or PNG image up to 2 MiB."
            wire:model="artwork" :readonly="$locked" :reset-key="$resetKey"
            :value="$existing ? [['name' => 'sample.jpg', 'size' => 17547, 'url' => asset('sample/sample.jpg')]] : []"
            x-on:file-upload:remove-existing="$wire.set('existing', false)" />
        <div class="flex flex-wrap gap-2">
            <flux:button type="submit">Submit / Validate</flux:button>
            <flux:button type="button" wire:click="loadExample">Load Value</flux:button>
            <flux:button type="button" wire:click="resetExample">Reset Sample</flux:button>
            <flux:button type="button" wire:click="$toggle('locked')">Toggle Readonly</flux:button>
        </div>
        <p>Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Project documents validated. Nothing was stored.</p>@endif
    </form>
</div>
