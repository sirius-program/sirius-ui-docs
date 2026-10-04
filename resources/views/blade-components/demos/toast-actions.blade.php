<x-sirius::button data-sir-toast-open="report-toast">With Actions</x-sirius::button>
<x-sirius::toast id="report-toast" title="Monthly report" text="The report is ready. Open it when you are ready." variant="success" :duration="0">
    <x-slot:footer>
        <x-sirius::button as="a" :href="asset('sample/sample.pdf')" target="_blank" rel="noopener">Open report</x-sirius::button>
        <x-sirius::button data-sir-toast-close="report-toast" variant="ghost">Later</x-sirius::button>
    </x-slot:footer>
</x-sirius::toast>