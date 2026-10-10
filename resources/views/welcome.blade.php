<x-layouts::landing title="Sirius UI">
    <div class="landing-content">
        <section class="landing-hero" aria-labelledby="landing-title">
            <div class="landing-intro">
                <p class="landing-eyebrow">Laravel Blade + Livewire</p>
                <h1 id="landing-title">Build your next interface with <span>Sirius UI.</span></h1>
                <p class="landing-lead">From everyday forms to tables, calendars, and charts. Reusable components with consistent styles, keyboard interactions, and light and dark themes.</p>
                <div class="flex flex-wrap items-center gap-4">
                    <x-sirius::button as="a" :href="route('started.installation')" variant="primary" icon="heroicon-o-arrow-right" wire:navigate>Start building</x-sirius::button>
                    <x-sirius::link :href="route('started.introduction').'#blade-components'" wire:navigate>Explore components</x-sirius::link>
                </div>
                <p class="landing-note">Use <x-sirius::code>&lt;x-sirius::button&gt;</x-sirius::code> in Blade. Add Livewire when you need server state.</p>
            </div>
            @include('welcome.demos.project')
        </section>

        <section class="landing-section" aria-labelledby="landing-components-title">
            <div class="landing-section-heading">
                <div>
                    <p class="landing-eyebrow">Try it here</p>
                    <h2 id="landing-components-title">Small components. A consistent interface.</h2>
                </div>
                <x-sirius::link :href="route('other.colors')" wire:navigate>Explore colors</x-sirius::link>
            </div>
            @include('welcome.demos.variants')
        </section>

        <section class="landing-section" aria-labelledby="landing-next-title">
            <div class="landing-section-heading">
                <h2 id="landing-next-title">Make it your own.</h2>
            </div>
            <div class="landing-guides">
                <x-sirius::card header="Start with Blade">
                    <p class="landing-muted">Install the package, load its assets, and use components in your views.</p>
                    <x-slot:footer><x-sirius::link :href="route('started.installation')" wire:navigate>Installation guide</x-sirius::link></x-slot:footer>
                </x-sirius::card>
                <x-sirius::card header="Bring your application state">
                    <p class="landing-muted">Connect form controls, tables, calendars, and charts to Livewire.</p>
                    <x-slot:footer><x-sirius::link :href="route('started.introduction').'#livewire-components'" wire:navigate>Livewire components</x-sirius::link></x-slot:footer>
                </x-sirius::card>
                <x-sirius::card header="Match your brand">
                    <p class="landing-muted">Adjust semantic colors and shared tokens for your interface.</p>
                    <x-slot:footer><x-sirius::link :href="route('other.colors')" wire:navigate>Theme guide</x-sirius::link></x-slot:footer>
                </x-sirius::card>
            </div>
        </section>
    </div>
</x-layouts::landing>
