<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plain Blade proof</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="p-8" data-integration-probe>
    <h1>Plain Blade proof</h1>
    <a href="{{ route('development.integrations') }}" wire:navigate>Integration proofs</a>
    <form x-data="{ submitted: '' }" @submit.prevent="submitted = JSON.stringify(Object.fromEntries(new FormData($el)))">
        @foreach (['first', 'second'] as $instance)
            <div x-data="integrationWidget('date', '2026-09-12')">
                <label for="date-{{ $instance }}">Date {{ $instance }}</label>
                <input id="date-{{ $instance }}" x-ref="control" name="date_{{ $instance }}">
            </div>
        @endforeach
        <div x-data="integrationWidget('select', 'alpha')">
            <label for="plain-choice">Choice</label>
            <select id="plain-choice" x-ref="control" name="choice">
                <option value="alpha">Alpha</option>
                <option value="beta">Beta</option>
            </select>
        </div>
        <div x-data="integrationWidget('editor', '<p>Initial content</p>')">
            <div x-ref="control"></div>
            <input type="hidden" name="html" :value="value">
        </div>
        <div x-data="integrationUpload()">
            <input x-ref="control" type="file" name="attachment" aria-label="Attachment">
        </div>
        <button type="submit">Inspect form values</button>
        <output id="form-values" x-text="submitted"></output>
    </form>
    @livewireScripts
</body>
</html>
