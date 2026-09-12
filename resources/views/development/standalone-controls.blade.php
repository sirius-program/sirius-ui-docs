<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Standalone Sirius controls</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white p-6 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100">
        <main class="mx-auto max-w-2xl space-y-6">
            <h1 class="text-2xl">Standalone Sirius controls</h1>
            <form id="standalone-form" class="space-y-4">
                <x-sirius::input id="standalone-password" type="password" label="Password" value="initial-secret" />
                <x-sirius::checkbox id="standalone-check" name="check" label="Locked checkbox" checked readonly />
                <x-sirius::radio id="standalone-radio-a" name="plan" value="a" label="Locked radio A" checked readonly />
                <x-sirius::radio id="standalone-radio-b" name="plan" value="b" label="Locked radio B" readonly />
                <x-sirius::radio id="independent-radio" name="other-plan" value="other" label="Independent radio" />
                <x-sirius::switch id="standalone-switch" name="switch" label="Locked switch" checked readonly />
                <x-sirius::checkbox id="standalone-disabled-check" label="Disabled checkbox" disabled />
                <x-sirius::radio id="standalone-disabled-radio" name="plan" label="Disabled radio" value="disabled" disabled />
                <x-sirius::switch id="standalone-disabled-switch" label="Disabled switch" disabled />
                <x-sirius::checkbox id="standalone-mixed" label="Mixed checkbox" indeterminate />
                <x-sirius::input id="standalone-long" label="Long adornments" prefix="A long prefix that must wrap" suffix="A long suffix that must wrap" value="Value" />
                <x-sirius::textarea id="standalone-notes" label="Notes" rows="3">Native text</x-sirius::textarea>
                <button type="reset">Reset standalone</button>
            </form>
        </main>
    </body>
</html>
