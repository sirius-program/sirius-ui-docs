<x-sirius::card id="project-card" header-class="font-semibold" footer-class="flex justify-end">
    <x-slot:header>
        <div class="flex items-center justify-between gap-3">
            <h3>Website redesign</h3>
            <x-sirius::badge variant="primary">In progress</x-sirius::badge>
        </div>
    </x-slot:header>
    <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Non rerum est voluptas repellendus veritatis tenetur ullam sed odio, deleniti accusantium porro, modi praesentium. Sequi, odit repellat? Natus itaque deserunt dolorem.</p>
    <x-slot:footer>
        <x-sirius::button as="a" href="{{ route('blade-components.button') }}" variant="primary">View actions</x-sirius::button>
    </x-slot:footer>
</x-sirius::card>
