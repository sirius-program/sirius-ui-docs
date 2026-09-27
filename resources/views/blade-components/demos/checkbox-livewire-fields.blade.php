<x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-agree'" label="I accept the workspace terms" wire:model.live="agreed" error-bag="default" name="agreed" required :readonly="$locked" helper="Accept the terms before joining the workspace." data-basic-agree />
<x-sirius::field :id="($automaticIds ?? false) ? null : $demoId.'-roles'" group label="Member access" error-bag="default" error-key="roles" helper="Choose the permissions for a new teammate." required>
    <div class="flex flex-wrap gap-4">
        <x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-role-zero'" label="Reader" error-bag="default" name="roles[]" value="0" wire:model.live="roles" :readonly="$locked" data-basic-role-zero />
        <x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-role-editor'" label="Editor" error-bag="default" name="roles[]" value="editor" wire:model.live="roles" :readonly="$locked" data-basic-role-editor />
    </div>
</x-sirius::field>
<x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-mixed'" label="All project notifications" helper="A mixed state indicates that only some project alerts are selected." :indeterminate="$mixed" :readonly="$locked" data-basic-mixed />
