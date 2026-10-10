<div class="grid gap-4 sm:grid-cols-2">
    <x-sirius::card header="Default tokens">
        <div class="space-y-4" data-default-color-example>
            <x-sirius::badge variant="primary">Primary</x-sirius::badge>
            <p><x-sirius::code variant="primary">project_id</x-sirius::code></p>
            <x-sirius::switch id="default-color-switch" name="default_updates" label="Project updates" checked />
        </div>
    </x-sirius::card>
    <x-sirius::card header="Cyan override" class="brand-theme">
        <div class="space-y-4" data-brand-color-example>
            <x-sirius::badge variant="primary">Primary</x-sirius::badge>
            <p><x-sirius::code variant="primary">project_id</x-sirius::code></p>
            <x-sirius::switch id="brand-color-switch" name="brand_updates" label="Project updates" checked />
        </div>
    </x-sirius::card>
</div>
