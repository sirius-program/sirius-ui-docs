<x-sirius::input id="blade-input-password" name="password" type="password" label="Password"
    :value="session('sample-input.loaded', false) ? 'Workspace-demo!42' : ''"
    error-bag="sample-input" helper="Example only; do not enter a real password."
    required minlength="8" autocomplete="new-password" />
