<div class="grid gap-4 sm:grid-cols-2">
    <x-sirius::card header="Default typography">
        <div class="space-y-3" data-typography-default>
            <h3 class="font-semibold">Project update</h3>
            <p>The website redesign is ready for review.</p>
            <p><x-sirius::code>project_id = 1042</x-sirius::code></p>
        </div>
    </x-sirius::card>
    <x-sirius::card header="Serif override" class="brand-typography">
        <div class="space-y-3" data-typography-custom>
            <h3 class="font-semibold">Project update</h3>
            <p>The website redesign is ready for review.</p>
            <p><x-sirius::code>project_id = 1042</x-sirius::code></p>
        </div>
    </x-sirius::card>
</div>
