<x-layouts::app :title="__('Getting Started')">
    <x-docs-page :navigation="['Getting Started' => ['overview' => 'Overview', 'blade-components' => 'Blade components']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header id="overview" class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">SIRIUS UI COMPONENTS</p>
                <h1 class="text-3xl font-semibold">Getting Started</h1>
            </header>
            <p>Reusable Blade and Livewire components. Choose a component below for demos, usage, and attributes. See the README for local setup.</p>
            <h2 class="text-lg font-medium">Blade Components</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <section id="blade-components-form-controls" class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                    <h3 class="font-medium">Form Controls</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('blade-components.choices') }}" wire:navigate>Checkbox, Radio &amp; Switch</a></li>
                        <li><a class="underline" href="{{ route('blade-components.currency') }}" wire:navigate>Currency</a></li>
                        <li><a class="underline" href="{{ route('blade-components.datetime-picker') }}" wire:navigate>Datetime Picker</a></li>
                        <li><a class="underline" href="{{ route('blade-components.file-upload') }}" wire:navigate>File Upload</a></li>
                        <li><a class="underline" href="{{ route('blade-components.form') }}" wire:navigate>Form</a></li>
                        <li><a class="underline" href="{{ route('blade-components.input') }}" wire:navigate>Input</a></li>
                        <li><a class="underline" href="{{ route('blade-components.label') }}" wire:navigate>Label</a></li>
                        <li><a class="underline" href="{{ route('blade-components.phone') }}" wire:navigate>Phone</a></li>
                        <li><a class="underline" href="{{ route('blade-components.richtext') }}" wire:navigate>Richtext</a></li>
                        <li><a class="underline" href="{{ route('blade-components.select') }}" wire:navigate>Select</a></li>
                        <li><a class="underline" href="{{ route('blade-components.slider') }}" wire:navigate>Slider</a></li>
                        <li><a class="underline" href="{{ route('blade-components.textarea') }}" wire:navigate>Textarea</a></li>
                    </ul>
                </section>
                <section id="blade-components-presentation" class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                    <h3 class="font-medium">Presentation</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('blade-components.alert') }}" wire:navigate>Alert</a></li>
                        <li><a class="underline" href="{{ route('blade-components.avatar') }}" wire:navigate>Avatar</a></li>
                        <li><a class="underline" href="{{ route('blade-components.badge') }}" wire:navigate>Badge</a></li>
                        <li><a class="underline" href="{{ route('blade-components.button') }}" wire:navigate>Button</a></li>
                        <li><a class="underline" href="{{ route('blade-components.button-group') }}" wire:navigate>Button Group</a></li>
                        <li><a class="underline" href="{{ route('blade-components.icon') }}" wire:navigate>Icon</a></li>
                        <li><a class="underline" href="{{ route('blade-components.message') }}" wire:navigate>Message</a></li>
                        <li><a class="underline" href="{{ route('blade-components.popover') }}" wire:navigate>Popover</a></li>
                        <li><a class="underline" href="{{ route('blade-components.skeleton') }}" wire:navigate>Skeleton</a></li>
                        <li><a class="underline" href="{{ route('blade-components.tooltip') }}" wire:navigate>Tooltip</a></li>
                    </ul>
                </section>
                <section id="blade-components-layouts" class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                    <h3 class="font-medium">Layouts</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('blade-components.accordion') }}" wire:navigate>Accordion</a></li>
                        <li><a class="underline" href="{{ route('blade-components.card') }}" wire:navigate>Card</a></li>
                        <li><a class="underline" href="{{ route('blade-components.dialog') }}" wire:navigate>Dialog</a></li>
                        <li><a class="underline" href="{{ route('blade-components.separator') }}" wire:navigate>Separator</a></li>
                        <li><a class="underline" href="{{ route('blade-components.slideover') }}" wire:navigate>Slideover</a></li>
                    </ul>
                </section>
                <section id="blade-components-navigation" class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                    <h3 class="font-medium">Navigation</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('blade-components.breadcrumb') }}" wire:navigate>Breadcrumb</a></li>
                        <li><a class="underline" href="{{ route('blade-components.dropdown') }}" wire:navigate>Dropdown</a></li>
                        <li><a class="underline" href="{{ route('blade-components.menu') }}" wire:navigate>Menu</a></li>
                    </ul>
                </section>
            </div>
        </article>
    </x-docs-page>
</x-layouts::app>
