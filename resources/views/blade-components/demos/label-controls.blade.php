<div class="grid gap-2">
    <x-sirius::label :for="$demoId.'-required'" required status="For your receipt">Billing email</x-sirius::label>
    <input id="{{ $demoId }}-required" name="email" type="email" class="sir-control" required autocomplete="email"
        @if ($livewire) wire:model="email" @else value="{{ $values['email'] ?? '' }}" @endif
        @readonly($locked) aria-invalid="{{ $errors->getBag($livewire ? 'default' : 'sample-label')->has('email') ? 'true' : 'false' }}"
        @if ($errors->getBag($livewire ? 'default' : 'sample-label')->has('email')) aria-describedby="{{ $demoId }}-error" @endif>
    @error('email', $livewire ? 'default' : 'sample-label')<p id="{{ $demoId }}-error" class="sir-error" role="status">{{ $message }}</p>@enderror
</div>
<div class="grid gap-2">
    <x-sirius::label :for="$demoId.'-optional'">Purchase order (optional)</x-sirius::label>
    <input id="{{ $demoId }}-optional" name="reference" class="sir-control" maxlength="80"
        @if ($livewire) wire:model="reference" @else value="{{ $values['reference'] ?? '' }}" @endif @readonly($locked)
        aria-invalid="{{ $errors->getBag($livewire ? 'default' : 'sample-label')->has('reference') ? 'true' : 'false' }}"
        @if ($errors->getBag($livewire ? 'default' : 'sample-label')->has('reference')) aria-describedby="{{ $demoId }}-reference-error" @endif>
    @error('reference', $livewire ? 'default' : 'sample-label')<p id="{{ $demoId }}-reference-error" class="sir-error" role="status">{{ $message }}</p>@enderror
</div>
