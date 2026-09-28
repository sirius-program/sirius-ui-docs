<x-layouts::app :title="__('Getting Started')">
    <x-docs-page :navigation="['Getting Started' => ['overview' => 'Overview', 'blade-components' => 'Blade components']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header id="overview" class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">SIRIUS UI COMPONENTS</p>
                <h1 class="text-3xl font-semibold">Getting Started</h1>
            </header>
            <p>Reusable Blade and Livewire components. Choose a component below for demos, usage, and attributes. See the README for local setup.</p>
            <section id="blade-components" class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                <h2 class="text-lg font-medium">Blade Components</h2>
                <ul class="list-disc pl-5 mt-3 space-y-3">
                    <li><a class="underline" href="{{ route('blade-components.label') }}" wire:navigate>Label</a></li>
                    @foreach (['input' => 'Input', 'textarea' => 'Textarea', 'choices' => 'Checkbox, Radio & Switch'] as $control => $controlLabel)
                        <li><a class="underline" href="{{ route('blade-components.' . $control) }}" wire:navigate>{{ $controlLabel }}</a></li>
                    @endforeach
                    <li><a class="underline" href="{{ route('blade-components.richtext') }}" wire:navigate>Richtext</a></li>
                    <li><a class="underline" href="{{ route('blade-components.slider') }}" wire:navigate>Slider</a></li>
                    <li><a class="underline" href="{{ route('blade-components.currency') }}" wire:navigate>Currency</a></li>
                    <li><a class="underline" href="{{ route('blade-components.datetime-picker') }}" wire:navigate>Datetime Picker</a></li>
                    <li><a class="underline" href="{{ route('blade-components.phone') }}" wire:navigate>Phone</a></li>
                    <li><a class="underline" href="{{ route('blade-components.select') }}" wire:navigate>Select</a></li>
                    <li><a class="underline" href="{{ route('blade-components.file-upload') }}" wire:navigate>File Upload</a></li>
                    <li><a class="underline" href="{{ route('blade-components.form') }}" wire:navigate>Form</a></li>
                    <li><a class="underline" href="{{ route('blade-components.icon') }}" wire:navigate>Icon</a></li>
                    <li><a class="underline" href="{{ route('blade-components.button') }}" wire:navigate>Button</a></li>
                    <li><a class="underline" href="{{ route('blade-components.button-group') }}" wire:navigate>Button Group</a></li>
                    <li><a class="underline" href="{{ route('blade-components.badge') }}" wire:navigate>Badge</a></li>
                    <li><a class="underline" href="{{ route('blade-components.message') }}" wire:navigate>Message</a></li>
                    <li><a class="underline" href="{{ route('blade-components.card') }}" wire:navigate>Card</a></li>
                    <li><a class="underline" href="{{ route('blade-components.accordion') }}" wire:navigate>Accordion</a></li>
                </ul>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
