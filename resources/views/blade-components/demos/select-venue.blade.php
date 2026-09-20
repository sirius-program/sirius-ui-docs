<x-sirius::select id="blade-select-venue" name="venue" label="Event venue"
    :options="[]" :value="session('select_sample.venue')" :search-url="route('blade-components.select.options')"
    helper="Search the public venue directory." error-bag="select" />
