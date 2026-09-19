<x-sirius::datetime-picker id="blade-date-departure" name="departure" label="Departure date"
    min-date="2028-01-01" max-date="2028-12-31" :disabled-dates="['2028-03-01']" locale="id" :week-start="1" required helper="Choose your travel day. No departures on 1 March."
    :value="session('sample-datetime-picker.departure', '')" error-bag="datetime-picker" />
