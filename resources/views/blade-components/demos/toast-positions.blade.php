<div class="flex flex-wrap gap-3">
    @foreach (['top-start', 'top-center', 'top-end', 'bottom-start', 'bottom-center', 'bottom-end'] as $position)
        <x-sirius::button :data-sir-toast-open="'position-toast-'.$position">{{ $position }}</x-sirius::button>
        <x-sirius::toast :id="'position-toast-'.$position" :position="$position" title="Report ready" text="Your monthly report is ready to download." />
    @endforeach
</div>
