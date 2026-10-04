<x-sirius::tabs id="workspace-settings" label="Workspace settings" orientation="vertical" activation="manual" active="notifications" :items="[
    'profile' => 'Profile',
    'notifications' => 'Notifications',
    'access' => 'Access',
]">
    <x-slot:panel-profile><p>Your workspace name is Design team.</p></x-slot:panel-profile>
    <x-slot:panel-notifications><p>Project updates are sent by email each weekday.</p></x-slot:panel-notifications>
    <x-slot:panel-access><p>Only invited members can open workspace projects.</p></x-slot:panel-access>
</x-sirius::tabs>
