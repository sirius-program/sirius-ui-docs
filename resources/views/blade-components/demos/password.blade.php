<x-sirius::input id="blade-password-password" name="password" type="password" label="Account password"
    :value="session('sample-password.loaded', false) ? 'Workspace-demo!42' : ''"
    error-bag="sample-password" helper="Example only; do not enter a real password."
    required minlength="8" autocomplete="new-password" />
