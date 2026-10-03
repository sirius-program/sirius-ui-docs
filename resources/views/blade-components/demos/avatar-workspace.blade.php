<div class="flex flex-wrap items-center gap-6">
    <div class="flex items-center gap-3">
        <x-sirius::avatar id="workspace-avatar" :src="asset('sample/sample.jpg')" fallback="Lake Studio" alt="Lake Studio logo" variant="rounded" size="lg" />
        <p class="font-medium">Lake Studio</p>
    </div>
    <x-sirius::avatar :src="asset('sample/sample.jpg')" fallback="Lake Studio" alt="Lake Studio logo" size="xl" />
</div>
