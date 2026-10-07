<x-sirius::form :action="route('blade-components.form.update')" method="PUT" id="form-replace" class="space-y-4" novalidate>
    <x-sirius::input name="replace[title]" label="Project details" :value="is_string(old('replace.title')) ? old('replace.title') : null" required error-bag="form-replace" />
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
</x-sirius::form>

