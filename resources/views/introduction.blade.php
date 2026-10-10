<x-layouts::app :title="__('Introduction')">
    <x-docs-page :navigation="['Introduction' => ['overview' => 'Overview', 'choosing-components' => 'Blade and Livewire', 'assets-and-themes' => 'Assets and themes', 'application-responsibilities' => 'Application responsibilities', 'blade-components' => 'Blade components', 'livewire-components' => 'Livewire components']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header id="overview" class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">GETTING STARTED</p>
                <h1 class="text-3xl font-semibold">Introduction</h1>
                <p>Get to know more about Sirius UI.</p>
            </header>
            <p>Reusable Blade and Livewire components. Start with <x-sirius::link href="{{ route('started.installation') }}" wire:navigate>Installation</x-sirius::link> to install the package and load its assets, then choose a component below for demos, usage, and attributes.</p>
            <p>Using a coding agent? Install the <x-sirius::link href="{{ route('started.ai-agent-skill') }}" wire:navigate>AI Agent Skill</x-sirius::link> for version-matched Sirius UI guidance and examples.</p>
            <section id="choosing-components" class="space-y-3">
                <h2 class="text-xl font-medium">Blade and Livewire</h2>
                <p>Use Blade components for forms, navigation, layouts, and overlays. Form controls work with native submissions or Livewire bindings; interactive widgets initialize from the package assets.</p>
                <p>For data interfaces, extend the Livewire Table or Calendar with your application's queries and hooks. Mount Chart directly with your datasets and options. Their documentation includes examples for each approach.</p>
            </section>
            <section id="assets-and-themes" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and themes</h2>
                <p>Load Sirius CSS and JavaScript once through Vite or published assets. Select, File Upload, Richtext, Calendar, and Chart bundle their widget dependencies; no CDN or separate React setup is required.</p>
                <p>The package supports light and dark themes, semantic color variants, and CSS variables for customization. Use the <x-sirius::code>dark</x-sirius::code> class on a parent element to enable the dark theme.</p>
            </section>
            <section id="application-responsibilities" class="space-y-3">
                <h2 class="text-xl font-medium">Application responsibilities</h2>
                <p>Your application owns authorization, query scoping, validation, persistence, and upload endpoints. Sanitize Richtext HTML before rendering it, and manage stored-file cleanup when uploads or editor images are removed.</p>
            </section>
            <h2 id="blade-components" class="text-lg font-medium">Blade Components</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <section id="blade-components-form-control" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Form Control</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><x-sirius::link href="{{ route('blade-components.form') }}" wire:navigate>Form</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.label') }}" wire:navigate>Label</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.choices') }}" wire:navigate>Choices</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.currency') }}" wire:navigate>Currency</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.datetime-picker') }}" wire:navigate>Datetime Picker</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.file-upload') }}" wire:navigate>File Upload</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.input') }}" wire:navigate>Input</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.phone') }}" wire:navigate>Phone</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.richtext') }}" wire:navigate>Richtext</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.select') }}" wire:navigate>Select</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.slider') }}" wire:navigate>Slider</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.textarea') }}" wire:navigate>Textarea</x-sirius::link></li>
                    </ul>
                </section>
                <section id="blade-components-presentation" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Presentation</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><x-sirius::link href="{{ route('blade-components.alert') }}" wire:navigate>Alert</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.avatar') }}" wire:navigate>Avatar</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.badge') }}" wire:navigate>Badge</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.button') }}" wire:navigate>Button</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.button-group') }}" wire:navigate>Button Group</x-sirius::link></li>
                        <li><x-sirius::link :href="route('blade-components.code')" wire:navigate>Code</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.icon') }}" wire:navigate>Icon</x-sirius::link></li>
                        <li><x-sirius::link :href="route('blade-components.link')" wire:navigate>Link</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.message') }}" wire:navigate>Message</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.popover') }}" wire:navigate>Popover</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.skeleton') }}" wire:navigate>Skeleton</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.timeline') }}" wire:navigate>Timeline</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.toast') }}" wire:navigate>Toast</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.tooltip') }}" wire:navigate>Tooltip</x-sirius::link></li>
                    </ul>
                </section>
                <section id="blade-components-layout" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Layout</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3 mb-4">
                        <li><x-sirius::link href="{{ route('blade-components.accordion') }}" wire:navigate>Accordion</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.breadcrumb') }}" wire:navigate>Breadcrumb</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.card') }}" wire:navigate>Card</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.dialog') }}" wire:navigate>Dialog</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.dropdown') }}" wire:navigate>Dropdown</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.menu') }}" wire:navigate>Menu</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.separator') }}" wire:navigate>Separator</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.slideover') }}" wire:navigate>Slideover</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('blade-components.tabs') }}" wire:navigate>Tabs</x-sirius::link></li>
                    </ul>
                </section>
            </div>
            <h2 id="livewire-components" class="text-lg font-medium">Livewire Components</h2>
            
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <section id="livewire-components-calendar" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Calendar</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><x-sirius::link href="{{ route('livewire-components.calendar') }}" wire:navigate>Overview</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.calendar.actions') }}" wire:navigate>Actions</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.calendar.events') }}" wire:navigate>Events</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.calendar.options') }}" wire:navigate>Options</x-sirius::link></li>
                    </ul>
                </section>
                <section id="livewire-components-chart" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Chart</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><x-sirius::link href="{{ route('livewire-components.chart') }}" wire:navigate>Overview</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.chart.data') }}" wire:navigate>Data</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.chart.extensions') }}" wire:navigate>Extensions</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.chart.options') }}" wire:navigate>Options</x-sirius::link></li>
                    </ul>
                </section>
                <section id="livewire-components-table" class="rounded-xl border border-slate-300 p-6 dark:border-slate-600">
                    <h3 class="font-medium">Table</h3>
                    <ul class="list-disc pl-5 mt-3 space-y-3">
                        <li><x-sirius::link href="{{ route('livewire-components.table') }}" wire:navigate>Overview</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.table.query') }}" wire:navigate>Query</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.table.columns') }}" wire:navigate>Columns</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.table.filters') }}" wire:navigate>Filters</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.table.row-actions') }}" wire:navigate>Row Actions</x-sirius::link></li>
                        <li><x-sirius::link href="{{ route('livewire-components.table.bulk-actions') }}" wire:navigate>Bulk Actions</x-sirius::link></li>
                    </ul>
                </section>
            </div>
        </article>
    </x-docs-page>
</x-layouts::app>
