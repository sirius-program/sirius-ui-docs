<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Native dialog integration</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white p-6 text-slate-900 dark:bg-slate-900 dark:text-slate-100">
        <h1>Native dialog integration</h1>
        <x-sirius::button id="native-dialog-trigger" data-sir-dialog-open="native-dialog">Open notice</x-sirius::button>
        <x-sirius::dialog id="native-dialog" header="Shipping notice" open initial-focus="#native-dialog-close">
            <p>Your parcel will leave our warehouse tomorrow.</p>
            <x-slot:footer><x-sirius::button id="native-dialog-close" data-sir-dialog-close>Close notice</x-sirius::button></x-slot:footer>
        </x-sirius::dialog>
    </body>
</html>
