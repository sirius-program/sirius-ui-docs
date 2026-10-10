<x-layouts::app title="Accessibility">
    <x-docs-page :navigation="['Accessibility' => ['fields-and-errors' => 'Fields and errors', 'icons-and-names' => 'Icons and names', 'keyboard-and-focus' => 'Keyboard and focus', 'announcements' => 'Announcements', 'display-preferences' => 'Display preferences', 'application-checks' => 'Application checks']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">GETTING STARTED</p>
                <h1 class="text-3xl font-semibold">Accessibility</h1>
                <p>Built-in behavior and the checks your application still needs.</p>
            </header>
            <section id="fields-and-errors" class="space-y-3">
                <h2 class="text-xl font-medium">Fields and errors</h2>
                <p>Form controls connect their label, helper, and errors through generated IDs. Validation adds <x-sirius::code>aria-invalid</x-sirius::code> and links error text with <x-sirius::code>aria-describedby</x-sirius::code>. Field and Group provide the same contract for custom controls and grouped choices.</p>
                <p>Use meaningful labels and stable, unique IDs when other elements refer to a field. For standalone native controls, Label's <x-sirius::code>for</x-sirius::code> must match the control ID. Use a legend for related choices.</p>
                @include('getting-started.examples.accessibility-field')
                <p>See <x-sirius::link :href="route('blade-components.label')" wire:navigate>Label</x-sirius::link> and each control's guide for error bindings and custom field composition.</p>
            </section>
            <section id="icons-and-names" class="space-y-3">
                <h2 class="text-xl font-medium">Icons and names</h2>
                <p>Icon is decorative by default: its SVG is hidden from assistive technology and is not focusable. Set <x-sirius::code>label</x-sirius::code> when the icon itself conveys information. Named icons expose <x-sirius::code>role="img"</x-sirius::code> and their label without inheriting the SVG's hidden state.</p>
                <p>Give icon-only buttons their own accessible name and leave the contained icon decorative.</p>
                @include('getting-started.examples.accessibility-icons')
            </section>
            <section id="keyboard-and-focus" class="space-y-3">
                <h2 class="text-xl font-medium">Keyboard and focus</h2>
                <ul class="list-disc space-y-2 pl-5">
                    <li>Accordion uses native details/summary. Menu submenus use disclosure buttons and ordinary tab stops; Dropdown supports arrow keys, Home/End, typeahead, and Escape.</li>
                    <li>Tabs connect each tab to its panel. Arrow keys, Home, and End move between tabs; manual activation uses Enter or Space.</li>
                    <li>Slider handles expose their current value and support arrows, Home/End, and Page Up/Down.</li>
                    <li>Dialog, Alert, and Slideover use modal dialogs, keep focus inside while open, and restore focus to the opener when it remains available. Escape dismissal can be configured.</li>
                    <li>Tooltip shows text on hover or focus and connects it with aria-describedby. Popover accepts interactive content and does not trap focus; give its panel and trigger useful names.</li>
                </ul>
                <p>Keep visible focus styling and sensible tab order. Read each component guide for its activation and dismissal options.</p>
            </section>
            <section id="announcements" class="space-y-3">
                <h2 class="text-xl font-medium">Announcements</h2>
                <p>Field errors and label status use live regions. Toast announces ordinary updates politely; danger uses an assertive announcement. Toast does not move focus automatically when opened.</p>
                <p>Use concise messages and avoid announcing the same update through several components at once.</p>
            </section>
            <section id="display-preferences" class="space-y-3">
                <h2 class="text-xl font-medium">Display preferences</h2>
                <p>Overlays, disclosures, floating panels, choice controls, loading indicators, and bundled calendar/file-upload motion honor <x-sirius::code>prefers-reduced-motion</x-sirius::code>. Code and Link use system colors in forced-colors mode; the custom scrollbar defers to the browser there.</p>
                <p>Check contrast, zoom, and text scaling after customizing colors or dimensions. A variant name alone does not guarantee contrast in every context.</p>
            </section>
            <section id="application-checks" class="space-y-3">
                <h2 class="text-xl font-medium">Application checks</h2>
                <p>Your application supplies useful names, validation messages, error routing, and accessible content. Give Chart a descriptive label and an equivalent text summary or data table, as shown in its <x-sirius::link :href="route('livewire-components.chart')" wire:navigate>guide</x-sirius::link>.</p>
                <p>Automated tests cover markup, keyboard, focus, state updates, and browser interaction. This is not a WCAG certification or a completed screen-reader audit. Test your final pages with keyboards, assistive technology, and your supported browsers.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
