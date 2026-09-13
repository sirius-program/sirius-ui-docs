<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Currency integration</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white p-6 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100">
        <main class="mx-auto max-w-2xl space-y-6">
            <h1>Currency integration</h1>
            <form id="currency-form" class="space-y-5">
                <x-sirius::currency id="native-amount" name="amount" label="Amount" value="1234.50" />
                <x-sirius::currency id="native-reversed" name="reversed" label="Reversed" thousands-separator="." decimal-separator="," :precision="3" allow-negative value="-1250.125" />
                <x-sirius::currency id="native-whole" name="whole" label="Whole units" :precision="0" value="0" />
                <x-sirius::currency id="native-bounds" name="bounded" label="Exact bounds" min="99999999999999999999.01" max="99999999999999999999.03" value="99999999999999999999.02" />
                <x-sirius::currency id="native-locked" name="locked" label="Locked" readonly value="42.50" />
                <x-sirius::currency id="native-disabled" name="disabled" label="Disabled" disabled value="99" />
                <x-sirius::currency id="native-space" name="space" label="Space grouping" thousands-separator=" " value="1234.50" />
                <button type="reset">Native reset</button>
                <button type="submit">Submit native</button>
            </form>
            <x-sirius::currency id="external-amount" name="external" form="currency-form" label="External form control" value="2500.00" />
        </main>
    </body>
</html>
