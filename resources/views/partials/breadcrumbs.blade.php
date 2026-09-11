@unless ($breadcrumbs->isEmpty())
    <nav aria-label="{{ __('Breadcrumb') }}">
        <flux:breadcrumbs class="mt-1 min-w-0 flex-wrap">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && ! $loop->last)
                    <flux:breadcrumbs.item :href="$breadcrumb->url" wire:navigate>
                        {{ $breadcrumb->title }}
                    </flux:breadcrumbs.item>
                @else
                    <flux:breadcrumbs.item>
                        {{ $breadcrumb->title }}
                    </flux:breadcrumbs.item>
                @endif
            @endforeach
        </flux:breadcrumbs>
    </nav>
@endunless
