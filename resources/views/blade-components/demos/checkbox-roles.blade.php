<x-sirius::field id="blade-checkbox-roles" group label="Member access"
    error-key="roles" error-bag="sample-checkbox" helper="Choose the permissions for a new teammate." required>
    <div class="flex flex-wrap gap-4">
        <x-sirius::checkbox id="blade-checkbox-role-zero" name="roles[]" label="Reader" value="0"
            :checked="in_array('0', session('sample-checkbox.roles', []), true)" />
        <x-sirius::checkbox id="blade-checkbox-role-editor" name="roles[]" label="Editor" value="editor"
            :checked="in_array('editor', session('sample-checkbox.roles', []), true)" />
    </div>
</x-sirius::field>
