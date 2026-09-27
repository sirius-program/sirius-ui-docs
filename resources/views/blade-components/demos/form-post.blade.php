<x-sirius::form :action="route('blade-components.form.store')" method="POST" id="form-create" class="space-y-4" novalidate>
    <x-sirius::input name="project[title]" label="Project name" :value="is_string(old('project.title')) ? old('project.title') : null" required error-bag="form-project" />
    <x-sirius::currency name="project[budget]" label="Budget (USD)" :value="is_string(old('project.budget')) ? old('project.budget') : null" prefix="$" required error-bag="form-project" />
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
</x-sirius::form>

