<livewire:examples.team-calendar :id="$calendarId" label="Team planning schedule" initial-date="2028-10-16" timezone="Asia/Jakarta"
    :selectable="true" :editable="true" :options="['firstDay' => 1, 'slotMinTime' => '07:00:00', 'slotMaxTime' => '19:00:00', 'dayMaxEvents' => 3]" :key="$calendarId" />
