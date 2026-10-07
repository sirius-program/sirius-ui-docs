<x-sirius::form :action="route('blade-components.form')" id="form-search" class="space-y-4">
    <x-sirius::input name="query" label="Find a project" :value="$query" />
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load">Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset">Reset Sample</x-sirius::button>
    </div>
</x-sirius::form>
