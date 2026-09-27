<x-sirius::form :action="route('blade-components.form')" id="form-search" class="space-y-4">
    <x-sirius::input name="query" label="Find a project" :value="$query" />
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load">Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset">Reset Sample</flux:button>
    </div>
</x-sirius::form>
