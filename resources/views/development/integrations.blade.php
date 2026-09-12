<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Integration proofs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="p-8" data-integration-probe>
    <h1 class="text-2xl font-semibold">Integration proofs</h1>
    <p>Development fixtures only. These are not public Sirius UI components.</p>
    <a href="{{ route('development.plain-blade') }}" wire:navigate>Plain Blade proof</a>
    <livewire:development.integration-probe />
    @livewireScripts
</body>
</html>
