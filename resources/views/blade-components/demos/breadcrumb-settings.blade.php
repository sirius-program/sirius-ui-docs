<x-sirius::breadcrumb label="Settings location" separator-icon="heroicon-o-chevron-right" id="settings-breadcrumb">
    <x-sirius::breadcrumb.item :link="route('dashboard')">Workspace</x-sirius::breadcrumb.item>
    <x-sirius::breadcrumb.item :link="route('appearance.edit')">Settings</x-sirius::breadcrumb.item>
    <x-sirius::breadcrumb.item current>Appearance</x-sirius::breadcrumb.item>
</x-sirius::breadcrumb>
