<x-sirius::switch id="blade-switch-enabled" name="enabled" label="Enable security alerts"
    :checked="(bool) session('sample-switch.enabled', false)" error-bag="sample-switch"
    helper="Security alerts must be enabled for this workspace." required />
