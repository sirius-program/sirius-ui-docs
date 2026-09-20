<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Select integration</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-white p-6 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100"><main class="mx-auto max-w-2xl space-y-6">
<h1>Select integration</h1>
<form id="select-form" class="space-y-5">
    <x-sirius::select id="native-single" name="shipping" label="Delivery" :options="\App\Support\SelectCatalog::shipping()" value="0" />
    <x-sirius::select id="native-multiple" name="topics" label="Interests" :options="\App\Support\SelectCatalog::topics()" multiple :value="['design']" :max-items="2" />
    <x-sirius::select id="native-disabled" name="disabled" label="Disabled" :options="\App\Support\SelectCatalog::topics()" disabled value="design" />
    <x-sirius::select id="native-readonly" name="readonly" label="Readonly" :options="\App\Support\SelectCatalog::topics()" readonly value="design" />
    <button type="reset">Native reset</button>
</form>
<x-sirius::select id="external-select" name="external" label="External" :options="\App\Support\SelectCatalog::topics()" form="select-form" value="research" />
</main></body></html>
