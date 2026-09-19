<x-sirius::datetime-picker id="blade-date-appointment" name="appointment" label="Consultation schedule"
    type="datetime" min-date="2028-01-01 00:00:00" max-date="2029-12-31 23:59:59" timezone="Asia/Jakarta" locale="id" required helper="Schedule a consultation using the Asia/Jakarta time zone and Indonesian locale."
    :value="session('sample-datetime-picker.appointment', '')" display-format="d F Y H:i:S" error-bag="datetime-picker" />
