<div class="mt-6 space-y-4">
    <button type="button" wire:click="resetValues">Reset from server</button>
    <button type="button" wire:click="$toggle('visible')">Toggle widgets</button>
    <button type="button" wire:click="save">Validate and sanitize</button>
    @if ($visible)
        <div wire:key="probe-widgets" class="space-y-4">
            <div wire:ignore x-data="integrationWidget('date', $wire.entangle('date').live)">
                <label for="probe-date">Date</label>
                <input id="probe-date" x-ref="control" name="date" type="text">
            </div>
            <div wire:ignore x-data="integrationWidget('select', $wire.entangle('choice').live)">
                <label for="probe-choice">Choice</label>
                <select id="probe-choice" x-ref="control" name="choice">
                    <option value="alpha">Alpha</option>
                    <option value="beta">Beta</option>
                </select>
            </div>
            <div wire:ignore x-data="integrationWidget('editor', $wire.entangle('html').live)">
                <label for="probe-editor">Rich text</label>
                <div id="probe-editor" x-ref="control"></div>
            </div>
            <div wire:ignore x-data="integrationUpload($wire)">
                <label for="probe-upload">Text file</label>
                <input id="probe-upload" x-ref="control" type="file" name="upload" accept="text/plain">
            </div>
        </div>
    @endif
    <output id="server-date">{{ $date }}</output>
    <output id="server-choice">{{ $choice }}</output>
    <output id="server-html">{{ $html }}</output>
    <output id="server-upload">{{ $upload?->getClientOriginalName() ?? 'No upload' }}</output>
    @foreach ($errors->all() as $error)
        <p role="alert">{{ $error }}</p>
    @endforeach
    <div id="sanitized-output">{!! $sanitized !!}</div>
</div>
