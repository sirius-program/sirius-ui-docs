<section class="mt-8 space-y-6" data-floating-integration>
    <h2 class="text-xl font-semibold">Tooltip and Popover</h2>
    <livewire:examples.floating-example />
    <div class="flex flex-wrap gap-3">
        <x-sirius::button id="floating-dialog-trigger" data-sir-dialog-open="floating-dialog">Floating panels in Dialog</x-sirius::button>
        <x-sirius::button id="floating-slideover-trigger" data-sir-dialog-open="floating-slideover">Floating panels in Slideover</x-sirius::button>
    </div>
    @foreach (['dialog', 'slideover'] as $overlay)
        <x-dynamic-component :component="'sirius::' . $overlay" :id="'floating-' . $overlay" :header="'Floating panels in ' . ucfirst($overlay)">
            <div style="height: 700px" class="space-y-4">
                <x-sirius::tooltip :id="$overlay . '-hint'" text="This hint stays above the scroll area." placement="left">
                    <x-sirius::button :id="$overlay . '-hint-trigger'">Access hint</x-sirius::button>
                </x-sirius::tooltip>
                <x-sirius::popover :id="$overlay . '-sharing'" label="Project sharing">
                    <x-slot:trigger>
                        <x-sirius::button :id="$overlay . '-sharing-trigger'">Invite member</x-sirius::button>
                    </x-slot:trigger>
                    <x-sirius::input :id="$overlay . '-email'" label="Member email" />
                    <x-sirius::tooltip :id="$overlay . '-nested-hint'" text="Invitations expire after seven days.">
                        <x-sirius::button :id="$overlay . '-nested-hint-trigger'">Invitation help</x-sirius::button>
                    </x-sirius::tooltip>
                    <x-sirius::popover :id="$overlay . '-nested'" label="Invitation details">
                        <x-slot:trigger>
                            <x-sirius::button :id="$overlay . '-nested-trigger'">Advanced details</x-sirius::button>
                        </x-slot:trigger>
                        <p>Members can view project files.</p>
                        <x-sirius::button :id="$overlay . '-nested-done'" data-sir-popover-close>Done</x-sirius::button>
                    </x-sirius::popover>
                    <x-sirius::button :id="$overlay . '-sharing-done'" data-sir-popover-close>Done</x-sirius::button>
                </x-sirius::popover>
            </div>
            <x-slot:footer><x-sirius::button :id="$overlay . '-close'" data-sir-dialog-close>Close overlay</x-sirius::button></x-slot:footer>
        </x-dynamic-component>
    @endforeach
</section>
