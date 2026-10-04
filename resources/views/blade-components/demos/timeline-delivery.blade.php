<x-sirius::timeline label="Order delivery">
    <x-sirius::timeline.item title="Order confirmed" description="Payment received on October 12." state="completed" icon="heroicon-o-check-circle" />
    <x-sirius::timeline.item title="On the way" description="Your parcel is with the courier." state="current" icon="heroicon-o-truck">
        <x-sirius::button as="a" href="#track-parcel" size="sm" variant="outline">Track parcel</x-sirius::button>
    </x-sirius::timeline.item>
    <x-sirius::timeline.item title="Delivered" description="Expected on October 15.">
        <x-slot:marker><span class="font-semibold">3</span></x-slot:marker>
    </x-sirius::timeline.item>
</x-sirius::timeline>
