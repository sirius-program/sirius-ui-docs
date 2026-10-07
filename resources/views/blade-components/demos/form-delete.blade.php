<x-sirius::form :action="route('blade-components.form.destroy')" method="DELETE" id="form-archive" class="space-y-4" novalidate>
    <x-sirius::checkbox name="archive[confirmed]" label="Archive the demo draft" :checked="(bool) old('archive.confirmed')" required error-bag="form-archive" />
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
</x-sirius::form>
