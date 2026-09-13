<div class="grid gap-4 sm:grid-cols-3">
    <x-sirius::field id="size-small" label="Small" size="sm"><input {{ $component->controlAttributes() }} value="Compact"></x-sirius::field>
    <x-sirius::field id="state-disabled" label="Disabled" disabled><input {{ $component->controlAttributes() }} value="Unavailable"></x-sirius::field>
    <x-sirius::field id="state-readonly" label="Readonly" readonly size="lg"><input {{ $component->controlAttributes() }} value="Still submitted"></x-sirius::field>
</div>
