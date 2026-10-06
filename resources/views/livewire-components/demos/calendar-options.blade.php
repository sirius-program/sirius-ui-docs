<livewire:examples.basic-team-calendar
    id="options-calendar"
    label="Work-week schedule"
    initial-date="2028-10-16"
    initial-view="timeGridWeek"
    locale="id"
    timezone="Asia/Jakarta"
    :first-day="1"
    :options="[
        'weekends' => false,
        'slotMinTime' => '07:00:00',
        'slotMaxTime' => '19:00:00',
        'businessHours' => [
            'daysOfWeek' => [1, 2, 3, 4, 5],
            'startTime' => '09:00',
            'endTime' => '17:00',
        ],
    ]"
/>

