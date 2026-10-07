@unless ($breadcrumbs->isEmpty())
    <x-sirius::breadcrumb :label="__('Breadcrumb')" class="mt-1 min-w-0 flex-wrap">
        @foreach ($breadcrumbs as $breadcrumb)
            <x-sirius::breadcrumb.item :link="$breadcrumb->url && ! $loop->last ? $breadcrumb->url : null"
                :current="$loop->last" wire:navigate>{{ $breadcrumb->title }}</x-sirius::breadcrumb.item>
        @endforeach
    </x-sirius::breadcrumb>
@endunless
