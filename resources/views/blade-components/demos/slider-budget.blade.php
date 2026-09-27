<x-sirius::slider
    id="blade-budget" name="budget" label="Nightly budget (USD)" range
    :value="session('sample-slider.budget', [40, 160])"
    :min="[0, 20]" :max="[200, 300]" :step="[5, 20]"
    helper="Choose the lowest and highest nightly price for your stay."
    required error-key="budget*" error-bag="slider"
/>
