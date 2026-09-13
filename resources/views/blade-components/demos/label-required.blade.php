<x-sirius::label for="label-required" required>Billing email</x-sirius::label>
<input id="label-required" name="email" type="email" class="sir-control" required autocomplete="email"
    value="{{ session('sample-label.email', '') }}"
    aria-invalid="{{ $errors->getBag('sample-label')->has('email') ? 'true' : 'false' }}"
    @if ($errors->getBag('sample-label')->has('email')) aria-describedby="label-error" @endif>
@error('email', 'sample-label')<p id="label-error" class="sir-error" role="status">{{ $message }}</p>@enderror