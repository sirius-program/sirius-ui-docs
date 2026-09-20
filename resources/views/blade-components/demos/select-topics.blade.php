<x-sirius::select id="blade-select-topics" name="topics" label="Workshop interests" required
    :options="\App\Support\SelectCatalog::topics()" :value="session('select_sample.topics')" multiple :clearable="true"
    helper="Choose the sessions you want to attend." error-bag="select" />
