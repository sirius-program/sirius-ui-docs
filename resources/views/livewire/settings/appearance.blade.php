<section class="w-full">
    @include('partials.settings-heading')
    <h2 class="sr-only">{{ __('Appearance settings') }}</h2>
    <x-settings.layout :heading="__('Appearance')" :subheading="__('Choose how the application looks on this device')">
        <x-appearance-options prefix="settings" />
    </x-settings.layout>
</section>
