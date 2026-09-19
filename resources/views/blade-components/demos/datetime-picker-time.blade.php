<x-sirius::datetime-picker id="blade-date-reminder" name="reminder" label="Reminder"
    type="time" min-time="08:00" max-time="20:00" :minute-increment="15" helper="Set your reminder time."
    :value="session('sample-datetime-picker.reminder', '')" error-bag="datetime-picker" />
