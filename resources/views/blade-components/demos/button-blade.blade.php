<div class="flex flex-wrap gap-3">
    <x-sirius::button variant="primary">Create invoice</x-sirius::button>
    <x-sirius::button variant="info">View invoice</x-sirius::button>
    <x-sirius::button variant="success" icon="heroicon-o-check">Approve invoice</x-sirius::button>
    <x-sirius::button variant="danger" disabled>Delete draft</x-sirius::button>
    <x-sirius::button variant="warning" loading>Reviewing payment</x-sirius::button>
    <x-sirius::button variant="secondary" icon="heroicon-o-arrow-down-tray" aria-label="Download invoice" />
    <x-sirius::button variant="ghost">Cancel</x-sirius::button>
    <x-sirius::button variant="outline">Preview invoice</x-sirius::button>
    <x-sirius::button as="a" variant="link" href="{{ route('blade-components.form') }}">View form guide</x-sirius::button>
</div>