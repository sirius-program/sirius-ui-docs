<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Richtext integration</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-white p-6 text-slate-900 dark:bg-slate-900 dark:text-slate-100"><main class="mx-auto max-w-2xl space-y-6">
<x-sirius::form :action="url()->current()" id="richtext-form" class="space-y-5">
    <x-sirius::richtext id="native-richtext" name="body" label="Announcement" :value="'<p>Initial note</p>'" required maxlength="20" />
    <x-sirius::richtext id="disabled-richtext" name="disabled" label="Disabled" disabled :value="'<p>Ignored</p>'" />
    <x-sirius::richtext id="readonly-richtext" name="readonly" label="Readonly" readonly :value="'<p>Locked</p>'" />
    <button type="reset">Native reset</button>
</x-sirius::form>
<x-sirius::richtext id="external-richtext" form="richtext-form" name="external" label="External field" :value="'<p>External</p>'" />
</main></body></html>

