<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Datetime picker integration</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white p-6 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100">
        <main class="mx-auto max-w-2xl space-y-6">
            <h1>Datetime picker integration</h1>
            <form id="date-form" class="space-y-5">
                <x-sirius::datetime-picker id="native-date" name="date" label="Travel date" value="2028-02-29" min-date="2028-01-01" max-date="2028-12-31" :disabled-dates="['2028-03-01']" locale="id" :week-start="1" />
                <x-sirius::datetime-picker id="native-time" name="time" label="Reminder" type="time" value="09:30" min-time="08:00" max-time="20:00" />
                <x-sirius::datetime-picker id="native-datetime" name="datetime" label="Consultation" type="datetime" value="2028-12-31 14:30:45" timezone="Asia/Jakarta" />
                <x-sirius::datetime-picker id="native-locked" name="locked" label="Locked" readonly value="2028-02-29" />
                <x-sirius::datetime-picker id="native-disabled" name="disabled" label="Disabled" disabled value="2028-02-29" />
                <button type="reset">Native reset</button>
            </form>
            <x-sirius::datetime-picker id="external-date" name="external" label="External form date" form="date-form" value="2028-01-01" :clearable="false" />
        </main>
    </body>
</html>
