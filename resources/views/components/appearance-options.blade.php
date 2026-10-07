@props(['prefix'])
<x-sirius::field :id="$prefix.'-appearance'" label="Appearance" group wrapper-class="docs-appearance-options">
    @foreach (['light' => 'Light', 'dark' => 'Dark', 'system' => 'System'] as $value => $label)
        <x-sirius::radio :id="$prefix.'-appearance-'.$value" :name="$prefix.'-appearance'"
            :value="$value" :label="__($label)" :checked="$value === 'system'" data-docs-appearance />
    @endforeach
</x-sirius::field>
