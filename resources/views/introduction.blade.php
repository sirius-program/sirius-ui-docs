<x-layouts::app :title="__('Introduction')">
    <x-docs-page :navigation="['Introduction' => ['overview' => 'Overview', 'blade-components' => 'Blade components']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header id="overview" class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">GETTING STARTED</p>
                <h1 class="text-3xl font-semibold">Introduction</h1>
                <p>Get to know more about Sirius UI.</p>
            </header>
            <p>Reusable Blade and Livewire components. Start with <a class="underline" href="{{ route('started.installation') }}" wire:navigate>Installation</a> to install the package and load its assets, then choose a component below for demos, usage, and attributes.</p>
            <p>Using a coding agent? Install the <a class="underline" href="{{ route('started.ai-agent-skill') }}" wire:navigate>AI Agent Skill</a> for version-matched Sirius UI guidance and examples.</p>
            <h2 id="blade-components" class="text-lg font-medium">Blade Components</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <section id="blade-components-form-control" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Form Control</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('blade-components.form') }}" wire:navigate>Form</a></li>
                        <li><a class="underline" href="{{ route('blade-components.label') }}" wire:navigate>Label</a></li>
                        <li><a class="underline" href="{{ route('blade-components.choices') }}" wire:navigate>Choices</a></li>
                        <li><a class="underline" href="{{ route('blade-components.currency') }}" wire:navigate>Currency</a></li>
                        <li><a class="underline" href="{{ route('blade-components.datetime-picker') }}" wire:navigate>Datetime Picker</a></li>
                        <li><a class="underline" href="{{ route('blade-components.file-upload') }}" wire:navigate>File Upload</a></li>
                        <li><a class="underline" href="{{ route('blade-components.input') }}" wire:navigate>Input</a></li>
                        <li><a class="underline" href="{{ route('blade-components.phone') }}" wire:navigate>Phone</a></li>
                        <li><a class="underline" href="{{ route('blade-components.richtext') }}" wire:navigate>Richtext</a></li>
                        <li><a class="underline" href="{{ route('blade-components.select') }}" wire:navigate>Select</a></li>
                        <li><a class="underline" href="{{ route('blade-components.slider') }}" wire:navigate>Slider</a></li>
                        <li><a class="underline" href="{{ route('blade-components.textarea') }}" wire:navigate>Textarea</a></li>
                    </ul>
                </section>
                <section id="blade-components-presentation" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
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
                        <li><a class="underline" href="{{ route('blade-components.timeline') }}" wire:navigate>Timeline</a></li>
                        <li><a class="underline" href="{{ route('blade-components.toast') }}" wire:navigate>Toast</a></li>
                        <li><a class="underline" href="{{ route('blade-components.tooltip') }}" wire:navigate>Tooltip</a></li>
                    </ul>
                </section>
                <section id="blade-components-layout" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Layout</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3 mb-4">
                        <li><a class="underline" href="{{ route('blade-components.accordion') }}" wire:navigate>Accordion</a></li>
                        <li><a class="underline" href="{{ route('blade-components.breadcrumb') }}" wire:navigate>Breadcrumb</a></li>
                        <li><a class="underline" href="{{ route('blade-components.card') }}" wire:navigate>Card</a></li>
                        <li><a class="underline" href="{{ route('blade-components.dialog') }}" wire:navigate>Dialog</a></li>
                        <li><a class="underline" href="{{ route('blade-components.dropdown') }}" wire:navigate>Dropdown</a></li>
                        <li><a class="underline" href="{{ route('blade-components.menu') }}" wire:navigate>Menu</a></li>
                        <li><a class="underline" href="{{ route('blade-components.separator') }}" wire:navigate>Separator</a></li>
                        <li><a class="underline" href="{{ route('blade-components.slideover') }}" wire:navigate>Slideover</a></li>
                        <li><a class="underline" href="{{ route('blade-components.tabs') }}" wire:navigate>Tabs</a></li>
                    </ul>
                </section>
            </div>
            <h2 class="text-lg font-medium">Livewire Components</h2>
            
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <section id="livewire-components-calendar" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Calendar</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('livewire-components.calendar') }}" wire:navigate>Overview</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.calendar.actions') }}" wire:navigate>Actions</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.calendar.events') }}" wire:navigate>Events</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.calendar.options') }}" wire:navigate>Options</a></li>
                    </ul>
                </section>
                <section id="livewire-components-chart" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Chart</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('livewire-components.chart') }}" wire:navigate>Overview</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.chart.data') }}" wire:navigate>Data</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.chart.extensions') }}" wire:navigate>Extensions</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.chart.options') }}" wire:navigate>Options</a></li>
                    </ul>
                </section>
                <section id="livewire-components-table" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Table</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><a class="underline" href="{{ route('livewire-components.table') }}" wire:navigate>Overview</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.table.query') }}" wire:navigate>Query</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.table.columns') }}" wire:navigate>Columns</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.table.filters') }}" wire:navigate>Filters</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.table.row-actions') }}" wire:navigate>Row Actions</a></li>
                        <li><a class="underline" href="{{ route('livewire-components.table.bulk-actions') }}" wire:navigate>Bulk Actions</a></li>
                    </ul>
                </section>
            </div>
        </article>
    </x-docs-page>
</x-layouts::app>
