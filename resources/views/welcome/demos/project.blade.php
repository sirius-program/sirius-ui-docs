<div class="landing-project" x-data="{ title: 'Website redesign', seats: 5, updates: true }">
    <x-sirius::card id="landing-project-card">
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="font-semibold">Your next project</h2>
                <x-sirius::badge variant="success">Demo</x-sirius::badge>
            </div>
        </x-slot:header>
        <x-sirius::form :action="route('home')" method="GET" class="grid gap-5"
            x-on:submit.prevent="$dispatch('toast:show', { id: 'landing-toast' })">
            <x-sirius::input id="landing-project-title" label="Project name" value="Website redesign" x-model="title" maxlength="60" />
            <x-sirius::input id="landing-project-seats" type="number" label="Team seats" value="5" x-model="seats" min="1" max="1000" suffix="seats" />
            <x-sirius::switch id="landing-project-updates" label="Send project updates" :checked="true" x-model="updates" />
            <div class="flex flex-wrap gap-3">
                <x-sirius::button id="landing-preview-trigger" variant="primary" data-sir-dialog-open="landing-preview">Preview Dialog</x-sirius::button>
                <x-sirius::button id="landing-toast-trigger" type="submit" variant="outline">Try Toast</x-sirius::button>
            </div>
        </x-sirius::form>
        <x-slot:footer><p class="landing-muted text-sm">Try the controls. This demo stays on this page; nothing is saved.</p></x-slot:footer>
    </x-sirius::card>
    <x-sirius::dialog id="landing-preview" header="Project preview" initial-focus="#landing-preview-close">
        <p class="landing-muted mb-5">A preview of your current demo values.</p>
        <dl class="grid gap-4">
            <div><dt class="landing-muted text-sm">Project name</dt><dd id="landing-preview-title" class="font-semibold wrap-anywhere" x-text="title || 'Untitled project'">Website redesign</dd></div>
            <div><dt class="landing-muted text-sm">Team seats</dt><dd id="landing-preview-seats" x-text="seats">5</dd></div>
            <div><dt class="landing-muted text-sm">Project updates</dt><dd id="landing-preview-updates" x-text="updates ? 'On' : 'Off'">On</dd></div>
        </dl>
        <x-slot:footer><x-sirius::button id="landing-preview-close" data-sir-dialog-close variant="outline">Back to demo</x-sirius::button></x-slot:footer>
    </x-sirius::dialog>
    <x-sirius::toast id="landing-toast" title="Hello from Sirius UI" text="This is a demo notification. Nothing was saved." variant="success" :duration="5000" />
</div>
