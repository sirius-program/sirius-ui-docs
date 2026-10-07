<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
                <flux:sidebar.group expandable :heading="__('Getting Started')" :expanded="request()->routeIs('started', 'started.*')">
                    <flux:sidebar.item :href="route('started')" :current="request()->routeIs('started')" wire:navigate>Overview</flux:sidebar.item>
                    <flux:sidebar.item :href="route('started.ai-agent-skill')" :current="request()->routeIs('started.ai-agent-skill')" wire:navigate>AI Agent Skill</flux:sidebar.item>
                </flux:sidebar.group>
                <flux:sidebar.group :heading="__('Blade Components')" class="grid my-5">
                    <flux:sidebar.group expandable heading="Form Control" class="grid" :expanded="request()->routeIs('blade-components.label', 'blade-components.input', 'blade-components.textarea', 'blade-components.choices', 'blade-components.slider', 'blade-components.currency', 'blade-components.datetime-picker', 'blade-components.phone', 'blade-components.select', 'blade-components.file-upload', 'blade-components.richtext', 'blade-components.form')">
                        <flux:sidebar.item :href="route('blade-components.choices')" :current="request()->routeIs('blade-components.choices')" wire:navigate>Checkbox, Radio &amp; Switch</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.currency')" :current="request()->routeIs('blade-components.currency')" wire:navigate>Currency</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.datetime-picker')" :current="request()->routeIs('blade-components.datetime-picker')" wire:navigate>Datetime Picker</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.file-upload')" :current="request()->routeIs('blade-components.file-upload')" wire:navigate>File Upload</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.form')" :current="request()->routeIs('blade-components.form')" wire:navigate>Form</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.input')" :current="request()->routeIs('blade-components.input')" wire:navigate>Input</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.label')" :current="request()->routeIs('blade-components.label')" wire:navigate>Label</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.phone')" :current="request()->routeIs('blade-components.phone')" wire:navigate>Phone</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.richtext')" :current="request()->routeIs('blade-components.richtext')" wire:navigate>Richtext</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.select')" :current="request()->routeIs('blade-components.select')" wire:navigate>Select</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.slider')" :current="request()->routeIs('blade-components.slider')" wire:navigate>Slider</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.textarea')" :current="request()->routeIs('blade-components.textarea')" wire:navigate>Textarea</flux:sidebar.item>
                    </flux:sidebar.group>

                    <flux:sidebar.group expandable heading="Presentation" class="grid" :expanded="request()->routeIs('blade-components.alert', 'blade-components.avatar', 'blade-components.skeleton', 'blade-components.icon', 'blade-components.button', 'blade-components.button-group', 'blade-components.badge', 'blade-components.message', 'blade-components.popover', 'blade-components.timeline', 'blade-components.toast', 'blade-components.tooltip')">
                        <flux:sidebar.item :href="route('blade-components.alert')" :current="request()->routeIs('blade-components.alert')" wire:navigate>Alert</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.avatar')" :current="request()->routeIs('blade-components.avatar')" wire:navigate>Avatar</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.badge')" :current="request()->routeIs('blade-components.badge')" wire:navigate>Badge</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.button')" :current="request()->routeIs('blade-components.button')" wire:navigate>Button</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.button-group')" :current="request()->routeIs('blade-components.button-group')" wire:navigate>Button Group</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.icon')" :current="request()->routeIs('blade-components.icon')" wire:navigate>Icon</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.message')" :current="request()->routeIs('blade-components.message')" wire:navigate>Message</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.popover')" :current="request()->routeIs('blade-components.popover')" wire:navigate>Popover</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.skeleton')" :current="request()->routeIs('blade-components.skeleton')" wire:navigate>Skeleton</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.timeline')" :current="request()->routeIs('blade-components.timeline')" wire:navigate>Timeline</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.toast')" :current="request()->routeIs('blade-components.toast')" wire:navigate>Toast</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.tooltip')" :current="request()->routeIs('blade-components.tooltip')" wire:navigate>Tooltip</flux:sidebar.item>
                    </flux:sidebar.group>
                    
                    <flux:sidebar.group expandable heading="Layout" class="grid" :expanded="request()->routeIs('blade-components.card', 'blade-components.accordion', 'blade-components.dialog', 'blade-components.separator', 'blade-components.slideover', 'blade-components.tabs')">
                        <flux:sidebar.item :href="route('blade-components.accordion')" :current="request()->routeIs('blade-components.accordion')" wire:navigate>Accordion</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.card')" :current="request()->routeIs('blade-components.card')" wire:navigate>Card</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.dialog')" :current="request()->routeIs('blade-components.dialog')" wire:navigate>Dialog</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.separator')" :current="request()->routeIs('blade-components.separator')" wire:navigate>Separator</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.slideover')" :current="request()->routeIs('blade-components.slideover')" wire:navigate>Slideover</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.tabs')" :current="request()->routeIs('blade-components.tabs')" wire:navigate>Tabs</flux:sidebar.item>
                    </flux:sidebar.group>
                    <flux:sidebar.group expandable heading="Navigation" class="grid" :expanded="request()->routeIs('blade-components.breadcrumb', 'blade-components.dropdown', 'blade-components.menu')">
                        <flux:sidebar.item :href="route('blade-components.breadcrumb')" :current="request()->routeIs('blade-components.breadcrumb')" wire:navigate>Breadcrumb</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.dropdown')" :current="request()->routeIs('blade-components.dropdown')" wire:navigate>Dropdown</flux:sidebar.item>
                        <flux:sidebar.item :href="route('blade-components.menu')" :current="request()->routeIs('blade-components.menu')" wire:navigate>Menu</flux:sidebar.item>
                    </flux:sidebar.group>
                </flux:sidebar.group>
                <flux:sidebar.group :heading="__('Livewire Components')" class="grid my-5">
                    <flux:sidebar.group expandable heading="Calendar" class="grid" :expanded="request()->routeIs('livewire-components.calendar', 'livewire-components.calendar.*', 'development.calendar')">
                        <flux:sidebar.item :href="route('livewire-components.calendar')" :current="request()->routeIs('livewire-components.calendar')" wire:navigate>Overview</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.calendar.actions')" :current="request()->routeIs('livewire-components.calendar.actions', 'development.calendar')" wire:navigate>Actions</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.calendar.events')" :current="request()->routeIs('livewire-components.calendar.events')" wire:navigate>Events</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.calendar.options')" :current="request()->routeIs('livewire-components.calendar.options')" wire:navigate>Options</flux:sidebar.item>
                    </flux:sidebar.group>
                    <flux:sidebar.group expandable heading="Chart" class="grid" :expanded="request()->routeIs('livewire-components.chart', 'livewire-components.chart.*', 'development.chart')">
                        <flux:sidebar.item :href="route('livewire-components.chart')" :current="request()->routeIs('livewire-components.chart', 'development.chart')" wire:navigate>Overview</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.chart.data')" :current="request()->routeIs('livewire-components.chart.data')" wire:navigate>Data</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.chart.extensions')" :current="request()->routeIs('livewire-components.chart.extensions')" wire:navigate>Extensions</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.chart.options')" :current="request()->routeIs('livewire-components.chart.options')" wire:navigate>Options</flux:sidebar.item>
                    </flux:sidebar.group>
                    <flux:sidebar.group expandable heading="Table" class="grid" :expanded="request()->routeIs('livewire-components.table', 'livewire-components.table.*', 'development.table')">
                        <flux:sidebar.item :href="route('livewire-components.table')" :current="request()->routeIs('livewire-components.table')" wire:navigate>Overview</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.table.bulk-actions')" :current="request()->routeIs('livewire-components.table.bulk-actions')" wire:navigate>Bulk Actions</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.table.columns')" :current="request()->routeIs('livewire-components.table.columns')" wire:navigate>Columns</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.table.filters')" :current="request()->routeIs('livewire-components.table.filters')" wire:navigate>Filters</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.table.query')" :current="request()->routeIs('livewire-components.table.query')" wire:navigate>Query</flux:sidebar.item>
                        <flux:sidebar.item :href="route('livewire-components.table.row-actions')" :current="request()->routeIs('livewire-components.table.row-actions', 'development.table')" wire:navigate>Row Actions</flux:sidebar.item>
                    </flux:sidebar.group>
                </flux:sidebar.group>
            </flux:sidebar.nav>
        </flux:sidebar>

        <x-app-header :$title />

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
