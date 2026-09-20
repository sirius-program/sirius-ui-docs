<x-sirius::select id="blade-select-shipping" name="shipping" label="Delivery method" required
    :options="\App\Support\SelectCatalog::shipping()" :value="session('select_sample.shipping')"
    helper="Choose how your order will arrive." error-bag="select" />
