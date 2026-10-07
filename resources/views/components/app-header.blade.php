@props(['title' => null])
<header class="docs-header" data-docs-header>
    <div class="flex min-w-0 items-center gap-3">
        <x-sirius::button variant="ghost" icon="heroicon-o-bars-3" class="docs-mobile-toggle"
            data-sir-dialog-open="docs-navigation" aria-controls="docs-navigation" aria-label="Open navigation" />
        <div class="min-w-0">
            <h1 class="truncate font-semibold">{{ $title ?? config('app.name', 'Sirius UI') }}</h1>
            {{ Breadcrumbs::view('partials.breadcrumbs') }}
        </div>
    </div>
    <x-sirius::dropdown id="docs-appearance-menu" align="end" content-role="dialog">
        <x-slot:trigger aria-label="Change appearance" title="Change appearance">
            <x-sirius::icon name="heroicon-o-computer-desktop" />
        </x-slot:trigger>
        <x-appearance-options prefix="header" />
    </x-sirius::dropdown>
</header>
