<div class="p-6">
    <x-sirius::menu id="grouped-menu" label="Team navigation" class="max-w-sm">
        <x-sirius::menu.category title="Workspace" icon="heroicon-o-building-office">
            <x-sirius::menu.item id="team-links" name="Team" icon="heroicon-o-users" open x-data="{ expanded: true }" x-bind:open="expanded">
                <x-slot:submenu>
                    <x-sirius::menu.item name="Overview" :link="route('dashboard')" active />
                </x-slot:submenu>
            </x-sirius::menu.item>
            <x-sirius::menu.item id="project-links" name="Projects" icon="heroicon-o-folder" open transition>
                <x-slot:submenu>
                    <x-sirius::menu.item id="project-home" name="Current projects" :link="route('dashboard')" />
                </x-slot:submenu>
            </x-sirius::menu.item>
            <x-sirius::menu.item id="account-links" name="Account" icon="heroicon-o-cog-6-tooth" transition>
                <x-slot:submenu>
                    <x-sirius::menu.item name="Appearance" :link="route('appearance.edit')" />
                </x-slot:submenu>
            </x-sirius::menu.item>
        </x-sirius::menu.category>
    </x-sirius::menu>
</div>
