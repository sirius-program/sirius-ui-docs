@php($sample = array_replace(\App\Support\DialogFormSample::values(), session('slideover-sample', [])))
<div data-slideover-form="blade" class="inline-block">
    <x-sirius::button data-sir-dialog-open="blade-slideover-form">Right</x-sirius::button>
    <x-sirius::slideover id="blade-slideover-form" side="right" size="xl" header="Create a project" initial-focus="#blade-slideover-form-title"
        :open="(bool) session('slideover-form-open', false)">
        <x-sirius::form method="POST" :action="route('blade-components.slideover.store')" sending-file novalidate class="space-y-5">
            <input type="hidden" name="sample[agreed]" value="0" />
            <input type="hidden" name="sample[notifications]" value="0" />
            <div class="grid gap-5 md:grid-cols-2">
                <x-sirius::input id="blade-slideover-form-title" name="sample[title]" error-key="sample.title"  error-bag="slideover-form" label="Project title" :value="$sample['title']" required maxlength="80" />
                <x-sirius::input id="blade-slideover-form-seats" name="sample[seats]" error-key="sample.seats"  error-bag="slideover-form" type="number" label="Team seats" :value="$sample['seats']" min="1" max="100" suffix="seats" required />
                <x-sirius::input id="blade-slideover-form-password" name="sample[password]" error-key="sample.password"  error-bag="slideover-form" type="password" label="Demo password" helper="Example only; do not enter a real password." />
                <x-sirius::currency id="blade-slideover-form-budget" name="sample[budget]" error-key="sample.budget"  error-bag="slideover-form" label="Project budget" :value="$sample['budget']" prefix="$" required />
                <x-sirius::phone id="blade-slideover-form-phone" name="sample[phone]" error-key="sample.phone"  error-bag="slideover-form" label="Contact number" :country="['ID', 'GB']" :value="$sample['phone']"  required />
                <x-sirius::datetime-picker id="blade-slideover-form-date" name="sample[date]" error-key="sample.date"  error-bag="slideover-form" label="Start date" type="date" :value="$sample['date']" locale="en" required />
                <x-sirius::datetime-picker id="blade-slideover-form-time" name="sample[time]" error-key="sample.time"  error-bag="slideover-form" label="Reminder time" type="time" :value="$sample['time']" required />
                <x-sirius::datetime-picker id="blade-slideover-form-appointment" name="sample[appointment]" error-key="sample.appointment"  error-bag="slideover-form" label="Kickoff meeting" type="datetime" timezone="Asia/Jakarta" locale="en" :value="$sample['appointment']" required />
                <x-sirius::select id="blade-slideover-form-delivery" name="sample[delivery]" error-key="sample.delivery"  error-bag="slideover-form" label="Delivery method" :value="$sample['delivery']" :options="[['value' => 'standard', 'label' => 'Standard delivery'], ['value' => 'express', 'label' => 'Express delivery']]" required />
                <x-sirius::select id="blade-slideover-form-services" name="sample[services][]" error-key="sample.services"  error-bag="slideover-form" label="Project services" multiple :value="$sample['services']" :options="[['value' => 'design', 'label' => 'Design'], ['value' => 'development', 'label' => 'Development']]" required />
                <x-sirius::textarea id="blade-slideover-form-notes" name="sample[notes]" error-key="sample.notes"  error-bag="slideover-form" label="Delivery notes" :value="$sample['notes']" rows="3" />
                <x-sirius::file-upload id="blade-slideover-form-attachment" name="attachment" label="Supporting file" accept="application/pdf,text/plain,image/jpeg,image/png" :max-size="2048" helper="PDF, text, JPEG, or PNG, up to 2 MiB." error-bag="slideover-form" />
                <x-sirius::checkbox id="blade-slideover-form-agreed" name="sample[agreed]" error-key="sample.agreed"  error-bag="slideover-form" label="I accept the project terms" :checked="(bool) $sample['agreed']" required />
                <x-sirius::switch id="blade-slideover-form-notifications" name="sample[notifications]" error-key="sample.notifications"  error-bag="slideover-form" label="Send project updates" :checked="(bool) $sample['notifications']" />
                <x-sirius::field id="blade-slideover-form-access" group label="Member access" error-key="sample.access" error-bag="slideover-form" required>
                    <div class="flex flex-wrap gap-4">
                        <x-sirius::checkbox id="blade-slideover-form-reader" name="sample[access][]" label="Reader" value="reader"  :checked="in_array('reader', $sample['access'], true)" />
                        <x-sirius::checkbox id="blade-slideover-form-editor" name="sample[access][]" label="Editor" value="editor"  :checked="in_array('editor', $sample['access'], true)" />
                    </div>
                </x-sirius::field>
                <x-sirius::field id="blade-slideover-form-plan" group label="Subscription plan" error-key="sample.plan" error-bag="slideover-form" required>
                    <div class="flex flex-wrap gap-4">
                        <x-sirius::radio id="blade-slideover-form-free" name="sample[plan]" label="Free" value="free"  :checked="$sample['plan'] === 'free'" required />
                        <x-sirius::radio id="blade-slideover-form-pro" name="sample[plan]" label="Pro" value="pro"  :checked="$sample['plan'] === 'pro'" required />
                    </div>
                </x-sirius::field>
                <x-sirius::slider id="blade-slideover-form-discount" name="sample[discount]" error-key="sample.discount"  error-bag="slideover-form" label="Project discount (%)" :value="$sample['discount']" :max="50" :step="5" />
                <x-sirius::slider id="blade-slideover-form-range" name="sample[range][]" error-key="sample.range"  error-bag="slideover-form" label="Hourly rate range (USD)" range :value="$sample['range']" :min="[0, 20]" :max="[200, 300]" :step="[5, 20]" />
                <div class="md:col-span-2"><x-sirius::richtext id="blade-slideover-form-brief" name="sample[brief]" error-key="sample.brief"  error-bag="slideover-form" label="Project brief" :value="$sample['brief']"  :height="160" :toolbar="['bold', 'italic', 'heading', 'bulletList', 'link', 'image', 'undo', 'redo']" :upload-url="route('blade-components.richtext.images.store')" /></div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-sirius::button type="submit" name="sample_action" value="validate" variant="primary">Submit / Validate</x-sirius::button>
                <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
                <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
            </div>
            
            @if (session('slideover-form-saved'))<p role="status">Project validated. Nothing was stored.</p>@endif
        </x-sirius::form>
        <x-slot:footer>
            <x-sirius::button data-sir-dialog-close>Cancel</x-sirius::button>
        </x-slot:footer>
    </x-sirius::slideover>
</div>
