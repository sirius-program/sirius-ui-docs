@props(['prefix' => 'desktop'])
<x-sirius::menu label="Documentation" data-docs-navigation>
    <x-sirius::menu.category :title="__('Getting Started')" class="docs-nav-section">
        <x-sirius::menu.item icon="heroicon-s-rocket-launch" :link="route('started.introduction')" :active="request()->routeIs('started.introduction')" wire:navigate>Introduction</x-sirius::menu.item>
        <x-sirius::menu.item icon="heroicon-s-clipboard-document-list" :link="route('started.installation')" :active="request()->routeIs('started.installation')" wire:navigate>Installation</x-sirius::menu.item>
        <x-sirius::menu.item icon="heroicon-s-cog-6-tooth" :link="route('started.ai-agent-skill')" :active="request()->routeIs('started.ai-agent-skill')" wire:navigate>AI Agent Skill</x-sirius::menu.item>
        <x-sirius::menu.item icon="heroicon-s-eye" :link="route('started.accessibility')" :active="request()->routeIs('started.accessibility')" wire:navigate>Accessibility</x-sirius::menu.item>
        <x-sirius::menu.item icon="heroicon-s-scale" :link="route('started.license')" :active="request()->routeIs('started.license')" wire:navigate>License</x-sirius::menu.item>
        <x-sirius::menu.item icon="heroicon-s-clock" :link="route('started.changelog')" :active="request()->routeIs('started.changelog')" wire:navigate>Changelog</x-sirius::menu.item>
    </x-sirius::menu.category>
    <x-sirius::menu.category :title="__('Blade Components')" class="docs-nav-section">
        <x-sirius::menu.item :id="$prefix.'-group-2'" name="Form Control" :open="request()->routeIs('blade-components.label', 'blade-components.input', 'blade-components.textarea', 'blade-components.choices', 'blade-components.slider', 'blade-components.currency', 'blade-components.datetime-picker', 'blade-components.phone', 'blade-components.select', 'blade-components.file-upload', 'blade-components.richtext', 'blade-components.form')"  class="docs-nav-group" transition>
            <x-slot:submenu>
                <x-sirius::menu.item :link="route('blade-components.form')" :active="request()->routeIs('blade-components.form')" wire:navigate>Form</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.label')" :active="request()->routeIs('blade-components.label')" wire:navigate>Label</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.choices')" :active="request()->routeIs('blade-components.choices')" wire:navigate>Choices</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.currency')" :active="request()->routeIs('blade-components.currency')" wire:navigate>Currency</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.datetime-picker')" :active="request()->routeIs('blade-components.datetime-picker')" wire:navigate>Datetime Picker</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.file-upload')" :active="request()->routeIs('blade-components.file-upload')" wire:navigate>File Upload</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.input')" :active="request()->routeIs('blade-components.input')" wire:navigate>Input</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.phone')" :active="request()->routeIs('blade-components.phone')" wire:navigate>Phone</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.richtext')" :active="request()->routeIs('blade-components.richtext')" wire:navigate>Richtext</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.select')" :active="request()->routeIs('blade-components.select')" wire:navigate>Select</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.slider')" :active="request()->routeIs('blade-components.slider')" wire:navigate>Slider</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.textarea')" :active="request()->routeIs('blade-components.textarea')" wire:navigate>Textarea</x-sirius::menu.item>
            </x-slot:submenu>
        </x-sirius::menu.item>
        <x-sirius::menu.item :id="$prefix.'-group-3'" name="Presentation" :open="request()->routeIs('blade-components.alert', 'blade-components.avatar', 'blade-components.skeleton', 'blade-components.icon', 'blade-components.button', 'blade-components.button-group', 'blade-components.code', 'blade-components.link', 'blade-components.badge', 'blade-components.message', 'blade-components.popover', 'blade-components.timeline', 'blade-components.toast', 'blade-components.tooltip')"  class="docs-nav-group" transition>
            <x-slot:submenu>
                <x-sirius::menu.item :link="route('blade-components.alert')" :active="request()->routeIs('blade-components.alert')" wire:navigate>Alert</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.avatar')" :active="request()->routeIs('blade-components.avatar')" wire:navigate>Avatar</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.badge')" :active="request()->routeIs('blade-components.badge')" wire:navigate>Badge</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.button')" :active="request()->routeIs('blade-components.button')" wire:navigate>Button</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.button-group')" :active="request()->routeIs('blade-components.button-group')" wire:navigate>Button Group</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.code')" :active="request()->routeIs('blade-components.code')" wire:navigate>Code</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.icon')" :active="request()->routeIs('blade-components.icon')" wire:navigate>Icon</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.link')" :active="request()->routeIs('blade-components.link')" wire:navigate>Link</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.message')" :active="request()->routeIs('blade-components.message')" wire:navigate>Message</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.popover')" :active="request()->routeIs('blade-components.popover')" wire:navigate>Popover</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.skeleton')" :active="request()->routeIs('blade-components.skeleton')" wire:navigate>Skeleton</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.timeline')" :active="request()->routeIs('blade-components.timeline')" wire:navigate>Timeline</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.toast')" :active="request()->routeIs('blade-components.toast')" wire:navigate>Toast</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.tooltip')" :active="request()->routeIs('blade-components.tooltip')" wire:navigate>Tooltip</x-sirius::menu.item>
            </x-slot:submenu>
        </x-sirius::menu.item>
        <x-sirius::menu.item :id="$prefix.'-group-4'" name="Layout" :open="request()->routeIs('blade-components.card', 'blade-components.accordion', 'blade-components.breadcrumb', 'blade-components.dialog', 'blade-components.dropdown', 'blade-components.menu', 'blade-components.separator', 'blade-components.slideover', 'blade-components.tabs')"  class="docs-nav-group" transition>
            <x-slot:submenu>
                <x-sirius::menu.item :link="route('blade-components.accordion')" :active="request()->routeIs('blade-components.accordion')" wire:navigate>Accordion</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.breadcrumb')" :active="request()->routeIs('blade-components.breadcrumb')" wire:navigate>Breadcrumb</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.card')" :active="request()->routeIs('blade-components.card')" wire:navigate>Card</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.dialog')" :active="request()->routeIs('blade-components.dialog')" wire:navigate>Dialog</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.dropdown')" :active="request()->routeIs('blade-components.dropdown')" wire:navigate>Dropdown</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.menu')" :active="request()->routeIs('blade-components.menu')" wire:navigate>Menu</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.separator')" :active="request()->routeIs('blade-components.separator')" wire:navigate>Separator</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.slideover')" :active="request()->routeIs('blade-components.slideover')" wire:navigate>Slideover</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('blade-components.tabs')" :active="request()->routeIs('blade-components.tabs')" wire:navigate>Tabs</x-sirius::menu.item>
            </x-slot:submenu>
        </x-sirius::menu.item>
    </x-sirius::menu.category>
    <x-sirius::menu.category :title="__('Livewire Components')" class="docs-nav-section">
        <x-sirius::menu.item :id="$prefix.'-group-6'" name="Calendar" :open="request()->routeIs('livewire-components.calendar', 'livewire-components.calendar.*')"  class="docs-nav-group" transition>
            <x-slot:submenu>
                <x-sirius::menu.item :link="route('livewire-components.calendar')" :active="request()->routeIs('livewire-components.calendar')" wire:navigate>Overview</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.calendar.actions')" :active="request()->routeIs('livewire-components.calendar.actions')" wire:navigate>Actions</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.calendar.events')" :active="request()->routeIs('livewire-components.calendar.events')" wire:navigate>Events</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.calendar.options')" :active="request()->routeIs('livewire-components.calendar.options')" wire:navigate>Options</x-sirius::menu.item>
            </x-slot:submenu>
        </x-sirius::menu.item>
        <x-sirius::menu.item :id="$prefix.'-group-7'" name="Chart" :open="request()->routeIs('livewire-components.chart', 'livewire-components.chart.*')"  class="docs-nav-group" transition>
            <x-slot:submenu>
                <x-sirius::menu.item :link="route('livewire-components.chart')" :active="request()->routeIs('livewire-components.chart')" wire:navigate>Overview</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.chart.data')" :active="request()->routeIs('livewire-components.chart.data')" wire:navigate>Data</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.chart.extensions')" :active="request()->routeIs('livewire-components.chart.extensions')" wire:navigate>Extensions</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.chart.options')" :active="request()->routeIs('livewire-components.chart.options')" wire:navigate>Options</x-sirius::menu.item>
            </x-slot:submenu>
        </x-sirius::menu.item>
        <x-sirius::menu.item :id="$prefix.'-group-8'" name="Table" :open="request()->routeIs('livewire-components.table', 'livewire-components.table.*')"  class="docs-nav-group" transition>
            <x-slot:submenu>
                <x-sirius::menu.item :link="route('livewire-components.table')" :active="request()->routeIs('livewire-components.table')" wire:navigate>Overview</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.table.query')" :active="request()->routeIs('livewire-components.table.query')" wire:navigate>Query</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.table.columns')" :active="request()->routeIs('livewire-components.table.columns')" wire:navigate>Columns</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.table.filters')" :active="request()->routeIs('livewire-components.table.filters')" wire:navigate>Filters</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.table.row-actions')" :active="request()->routeIs('livewire-components.table.row-actions')" wire:navigate>Row Actions</x-sirius::menu.item>
                <x-sirius::menu.item :link="route('livewire-components.table.bulk-actions')" :active="request()->routeIs('livewire-components.table.bulk-actions')" wire:navigate>Bulk Actions</x-sirius::menu.item>
            </x-slot:submenu>
        </x-sirius::menu.item>
    </x-sirius::menu.category>
</x-sirius::menu>
