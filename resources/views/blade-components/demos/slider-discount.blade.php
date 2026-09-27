<x-sirius::slider
    id="blade-discount" name="discount" label="Seasonal discount (%)"
    :value="session('sample-slider.discount', 10)" :max="50" :step="5"
    helper="Set a discount for your holiday promotion." required error-bag="slider"
/>
