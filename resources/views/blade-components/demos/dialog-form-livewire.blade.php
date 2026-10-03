<div data-dialog-form="livewire">
    <x-sirius::button wire:click="$set('reviewing', true)">Create project</x-sirius::button>
    <x-sirius::dialog id="dialog-form" size="xl" header="Create a project" initial-focus="#dialog-form-title"
        :open="$reviewing" wire:key="dialog-project-form" x-on:dialog:close="if ($event.target === $el && $wire.reviewing) $wire.set('reviewing', false)">
        <form wire:submit="save" novalidate class="space-y-5">
            <div class="grid gap-5 md:grid-cols-2">
                <x-sirius::input id="dialog-form-title" name="sample[title]" error-key="sample.title" wire:model="sample.title" :readonly="$locked" label="Project title" :value="$sample['title']" required maxlength="80" />
                <x-sirius::input id="dialog-form-seats" name="sample[seats]" error-key="sample.seats" wire:model="sample.seats" :readonly="$locked" type="number" label="Team seats" :value="$sample['seats']" min="1" max="100" suffix="seats" required />
                <x-sirius::input id="dialog-form-password" name="sample[password]" error-key="sample.password" wire:model="sample.password" :readonly="$locked" type="password" label="Demo password" helper="Example only; do not enter a real password." />
                <x-sirius::currency id="dialog-form-budget" name="sample[budget]" error-key="sample.budget" wire:model="sample.budget" :readonly="$locked" label="Project budget" :value="$sample['budget']" prefix="$" required />
                <x-sirius::phone id="dialog-form-phone" name="sample[phone]" error-key="sample.phone" wire:model="sample.phone" :readonly="$locked" label="Contact number" :country="['ID', 'GB']" :value="$sample['phone']" :reset-key="$resetKey" required />
                <x-sirius::datetime-picker id="dialog-form-date" name="sample[date]" error-key="sample.date" wire:model="sample.date" :readonly="$locked" label="Start date" type="date" :value="$sample['date']" locale="en" required />
                <x-sirius::datetime-picker id="dialog-form-time" name="sample[time]" error-key="sample.time" wire:model="sample.time" :readonly="$locked" label="Reminder time" type="time" :value="$sample['time']" required />
                <x-sirius::datetime-picker id="dialog-form-appointment" name="sample[appointment]" error-key="sample.appointment" wire:model="sample.appointment" :readonly="$locked" label="Kickoff meeting" type="datetime" timezone="Asia/Jakarta" locale="en" :value="$sample['appointment']" required />
                <x-sirius::select id="dialog-form-delivery" name="sample[delivery]" error-key="sample.delivery" wire:model="sample.delivery" :readonly="$locked" label="Delivery method" :value="$sample['delivery']" :options="[['value' => 'standard', 'label' => 'Standard delivery'], ['value' => 'express', 'label' => 'Express delivery']]" required />
                <x-sirius::select id="dialog-form-services" name="sample[services][]" error-key="sample.services" wire:model="sample.services" :readonly="$locked" label="Project services" multiple :value="$sample['services']" :options="[['value' => 'design', 'label' => 'Design'], ['value' => 'development', 'label' => 'Development']]" required />
                <x-sirius::textarea id="dialog-form-notes" name="sample[notes]" error-key="sample.notes" wire:model="sample.notes" :readonly="$locked" label="Delivery notes" :value="$sample['notes']" rows="3" />
                <x-sirius::file-upload id="dialog-form-attachment" name="attachment" label="Supporting file" accept="application/pdf,text/plain,image/jpeg,image/png" :max-size="2048" helper="PDF, text, JPEG, or PNG, up to 2 MiB." wire:model="attachment" :readonly="$locked" :reset-key="$resetKey" />
                <x-sirius::checkbox id="dialog-form-agreed" name="sample[agreed]" error-key="sample.agreed" wire:model="sample.agreed" :readonly="$locked" label="I accept the project terms"  required />
                <x-sirius::switch id="dialog-form-notifications" name="sample[notifications]" error-key="sample.notifications" wire:model="sample.notifications" :readonly="$locked" label="Send project updates"  />
                <x-sirius::field id="dialog-form-access" group label="Member access" error-key="sample.access"  required>
                    <div class="flex flex-wrap gap-4">
                        <x-sirius::checkbox id="dialog-form-reader" name="sample[access][]" label="Reader" value="reader" wire:model="sample.access" :readonly="$locked" />
                        <x-sirius::checkbox id="dialog-form-editor" name="sample[access][]" label="Editor" value="editor" wire:model="sample.access" :readonly="$locked" />
                    </div>
                </x-sirius::field>
                <x-sirius::field id="dialog-form-plan" group label="Subscription plan" error-key="sample.plan"  required>
                    <div class="flex flex-wrap gap-4">
                        <x-sirius::radio id="dialog-form-free" name="sample[plan]" label="Free" value="free" wire:model="sample.plan" :readonly="$locked" required />
                        <x-sirius::radio id="dialog-form-pro" name="sample[plan]" label="Pro" value="pro" wire:model="sample.plan" :readonly="$locked" required />
                    </div>
                </x-sirius::field>
                <x-sirius::slider id="dialog-form-discount" name="sample[discount]" error-key="sample.discount" wire:model="sample.discount" :readonly="$locked" label="Project discount (%)" :value="$sample['discount']" :max="50" :step="5" />
                <x-sirius::slider id="dialog-form-range" name="sample[range][]" error-key="sample.range" wire:model="sample.range" :readonly="$locked" label="Hourly rate range (USD)" range :value="$sample['range']" :min="[0, 20]" :max="[200, 300]" :step="[5, 20]" />
                <div class="md:col-span-2"><x-sirius::richtext id="dialog-form-brief" name="sample[brief]" error-key="sample.brief" wire:model="sample.brief" :readonly="$locked" label="Project brief" :value="$sample['brief']" :reset-key="$resetKey" :height="160" :toolbar="['bold', 'italic', 'heading', 'bulletList', 'link', 'image', 'undo', 'redo']" :upload-url="route('blade-components.richtext.images.store')" /></div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-sirius::button type="submit" variant="primary">Submit / Validate</x-sirius::button>
                <x-sirius::button wire:click="loadExample">Load Value</x-sirius::button>
                <x-sirius::button wire:click="resetExample">Reset Sample</x-sirius::button>
                <x-sirius::button wire:click="$toggle('locked')">Toggle Readonly</x-sirius::button>
            </div>
            <p role="status">Readonly: {{ $locked ? 'on' : 'off' }}</p>
            @if ($saved)<p role="status">Project validated. Nothing was stored.</p>@endif
        </form>
        <x-slot:footer>
            <x-sirius::button data-sir-dialog-close>Cancel</x-sirius::button>
        </x-slot:footer>
    </x-sirius::dialog>
</div>
