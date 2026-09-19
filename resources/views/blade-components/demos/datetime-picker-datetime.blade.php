<x-sirius::datetime-picker id="blade-date-appointment" name="appointment" label="Jadwal konsultasi"
    type="datetime" min-date="2028-01-01 00:00:00" max-date="2029-12-31 23:59:59" timezone="Asia/Jakarta" locale="id" required helper="Jadwalkan konsultasi menggunakan zona waktu lokal Asia/Jakarta."
    :value="session('sample-datetime-picker.appointment', '')" display-format="d F Y H:i:S" error-bag="datetime-picker" />
