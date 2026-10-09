<div class="space-y-4" x-data="{ action: 'No action selected' }">
    <x-sirius::menu label="Workspace navigation" id="workspace-menu" class="max-w-sm">
        <x-sirius::menu.category title="Workspace">
            <x-sirius::menu.item name="Overview" icon="heroicon-o-home" :link="route('dashboard')" active />
            <x-sirius::menu.item name="Messages" icon="heroicon-o-envelope" :link="route('blade-components.message')">
                <x-slot:trailing><x-sirius::badge variant="primary">3</x-sirius::badge></x-slot:trailing>
            </x-sirius::menu.item>
            <x-sirius::menu.item id="workspace-settings" name="Settings" icon="heroicon-o-cog-6-tooth" open transition>
                <x-slot:submenu>
                    <x-sirius::menu.item name="Appearance" :link="route('appearance.edit')" />
                    <x-sirius::menu.item id="workspace-billing" name="Billing">
                        <x-slot:submenu>
                            <x-sirius::menu.item name="Download invoice" x-on:click="action = 'Invoice requested'" />
                            <x-sirius::menu.item name="Payment methods" disabled />
                        </x-slot:submenu>
                    </x-sirius::menu.item>
                </x-slot:submenu>
            </x-sirius::menu.item>
            <x-sirius::menu.item name="Sign out" icon="heroicon-o-arrow-right-start-on-rectangle" x-on:click="action = 'Sign out requested'" />
        </x-sirius::menu.category>
    </x-sirius::menu>
    <p role="status" x-text="action"></p>
</div>
