<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Slider integration</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-white p-6 text-slate-900 dark:bg-slate-900 dark:text-slate-100"><main class="mx-auto max-w-2xl space-y-6">
<x-sirius::form :action="url()->current()" id="slider-form" class="space-y-5">
    <x-sirius::slider id="native-slider" name="amount" label="Amount" :value="0.3" :min="0.1" :max="1" :step="0.1" required />
    <x-sirius::slider id="native-range" name="prices" label="Prices" range :value="[21, 80]" :min="[0, 10]" :max="[90, 100]" :step="[3, 5]" />
    <x-sirius::slider id="locked-slider" name="locked" label="Readonly" :value="30" readonly />
    <x-sirius::slider id="disabled-slider" name="disabled" label="Disabled" :value="40" disabled />
    <button type="reset">Native reset</button>
</x-sirius::form>
<x-sirius::slider id="external-slider" name="external" label="External" form="slider-form" :value="50" />
</main></body></html>
