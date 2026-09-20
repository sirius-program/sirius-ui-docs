<div class="grid gap-2">
    <x-sirius::label for="label-optional">Purchase order (optional)</x-sirius::label>
    <input id="label-optional" name="reference" class="sir-control" maxlength="80"
        value="{{ session('sample-label.reference', '') }}"
        aria-invalid="{{ $errors->getBag('sample-label')->has('reference') ? 'true' : 'false' }}"
        @if ($errors->getBag('sample-label')->has('reference')) aria-describedby="label-reference-error" @endif>
    @error('reference', 'sample-label')<p id="label-reference-error" class="sir-error" role="status">{{ $message }}</p>@enderror
</div>
