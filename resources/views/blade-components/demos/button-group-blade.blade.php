<div x-data="{ page: 1 }" class="space-y-3">
    <x-sirius::button-group label="Invoice pages">
        <x-sirius::button variant="outline" x-on:click="page = Math.max(1, page - 1)">Previous</x-sirius::button>
        <x-sirius::button variant="outline" x-on:click="page++">Next</x-sirius::button>
    </x-sirius::button-group>
    <p role="status">Page <span x-text="page">1</span></p>
</div>
