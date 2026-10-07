<x-sirius::form :action="route('blade-components.form.update')" method="PATCH" id="form-rename" class="space-y-4" novalidate>
    <x-sirius::input name="rename[title]" label="New project name" :value="is_string(old('rename.title')) ? old('rename.title') : null" required error-bag="form-rename" />
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
</x-sirius::form>

