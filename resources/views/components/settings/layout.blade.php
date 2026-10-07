<div class="flex items-start gap-8 max-md:flex-col">
    <div class="w-full md:w-56">
        <x-sirius::menu :label="__('Settings')">
            <x-sirius::menu.item :link="route('appearance.edit')" :active="request()->routeIs('appearance.edit')" wire:navigate>{{ __('Appearance') }}</x-sirius::menu.item>
        </x-sirius::menu>
    </div>
    <div class="flex-1 self-stretch">
        <h2 class="text-xl font-semibold">{{ $heading ?? '' }}</h2>
        <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $subheading ?? '' }}</p>
        <div class="mt-5 w-full max-w-lg">{{ $slot }}</div>
    </div>
</div>
