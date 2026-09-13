<x-sirius::input id="blade-input-quantity" name="quantity" type="number" label="Team seats"
    :value="session('sample-input.quantity', 0)" error-bag="sample-input"
    helper="Reserve up to 100 seats for your team." required min="0" max="100" step="1" suffix="seats" />
