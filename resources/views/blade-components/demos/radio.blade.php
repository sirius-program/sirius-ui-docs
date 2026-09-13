<x-sirius::field id="blade-radio-plans" group label="Subscription plan"
    error-key="plan" error-bag="sample-radio" helper="Choose the plan for your workspace." required>
    <div class="flex flex-wrap gap-4">
        <x-sirius::radio id="blade-radio-plan-zero" name="plan" label="Free" value="0"
            :checked="session('sample-radio.plan') === '0'" required />
        <x-sirius::radio id="blade-radio-plan-pro" name="plan" label="Pro" value="pro"
            :checked="session('sample-radio.plan') === 'pro'" required />
    </div>
</x-sirius::field>
