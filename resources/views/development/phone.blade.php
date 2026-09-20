<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Phone integration</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-white p-6 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100"><main class="mx-auto max-w-2xl space-y-6">
<h1>Phone integration</h1>
<form id="phone-form" class="space-y-5">
    <x-sirius::phone id="native-phone" name="phone" label="Delivery" country="ID" value="+6281234567890" required />
    <x-sirius::phone id="native-multiple" name="multiple" label="Supplier" :country="['ID', 'GB', 'US']" delimiter="-" value="+442079460018" />
    <x-sirius::phone id="native-all" name="all" label="Traveler" country="*" delimiter="." />
    <x-sirius::phone id="native-compact" name="compact" label="Compact" country="ID" delimiter="" value="+6281234567890" />
    <x-sirius::phone id="native-locked" name="locked" label="Locked" :country="['ID', 'GB']" readonly value="+6281234567890" />
    <x-sirius::phone id="native-disabled" name="disabled" label="Disabled" country="ID" disabled value="+6281234567890" />
    <button type="reset">Native reset</button><button type="submit">Submit native</button>
</form>
<x-sirius::phone id="external-phone" name="external" label="External" country="ID" form="phone-form" value="+6281234567890" />
</main></body></html>
