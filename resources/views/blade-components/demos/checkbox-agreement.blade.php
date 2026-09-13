<x-sirius::checkbox id="blade-checkbox-agree" name="agreed" label="I accept the workspace terms"
    :checked="(bool) session('sample-checkbox.agreed', false)" error-bag="sample-checkbox"
    helper="Accept the terms before joining the workspace." required />
