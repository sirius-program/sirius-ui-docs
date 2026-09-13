<x-sirius::currency id="blade-currency-adjustment" label="Invoice adjustment" name="adjustment"
    :value="session('sample-currency.adjustment', '')" error-bag="currency"
    thousands-separator="." decimal-separator="," :precision="3" allow-negative suffix="EUR" required
    helper="Use a negative amount for a credit; up to 3 decimal places." />
