<x-sirius::form :action="route('blade-components.form.destroy')" method="DELETE" id="form-archive" class="space-y-4" novalidate>
    <x-sirius::checkbox name="archive[confirmed]" label="Archive the demo draft" :checked="(bool) old('archive.confirmed')" required error-bag="form-archive" />
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
</x-sirius::form>
