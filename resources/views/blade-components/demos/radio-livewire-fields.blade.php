<x-sirius::field :id="($automaticIds ?? false) ? null : $demoId.'-plans'" group label="Subscription plan" helper="Choose the plan for your workspace." error-bag="default" error-key="plan" required>
    <div class="flex flex-wrap gap-4">
        <x-sirius::radio :id="($automaticIds ?? false) ? null : $demoId.'-plan-zero'" error-bag="default" :name="$demoId.'-plan'" label="Free" value="0" wire:model.live="plan" required :readonly="$locked" data-basic-plan-zero />
        <x-sirius::radio :id="($automaticIds ?? false) ? null : $demoId.'-plan-pro'" error-bag="default" :name="$demoId.'-plan'" label="Pro" value="pro" wire:model.live="plan" required :readonly="$locked" data-basic-plan-pro />
    </div>
</x-sirius::field>
