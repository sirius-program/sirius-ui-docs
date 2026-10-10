<x-layouts::app title="License">
    <x-docs-page :navigation="['License' => ['package-license' => 'Sirius UI', 'bundled-dependencies' => 'Bundled dependencies', 'application-dependencies' => 'Application dependencies', 'documentation-license' => 'Documentation']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">GETTING STARTED</p>
                <h1 class="text-3xl font-semibold">License</h1>
                <p>License text and notices shipped with Sirius UI.</p>
            </header>
            <section id="package-license" class="space-y-3">
                <h2 class="text-xl font-medium">Sirius UI</h2>
                <p>Sirius UI is licensed under MIT. The text below is read directly from the installed package's <x-sirius::code>LICENSE.md</x-sirius::code>.</p>
                @if ($packageLicense === null)
                    <p role="status">Package license text is unavailable in this installation.</p>
                @else
                    <pre class="whitespace-pre-wrap wrap-anywhere rounded-lg border border-slate-300 p-4 text-sm dark:border-slate-600" data-license-source="package">{{ $packageLicense }}</pre>
                @endif
            </section>
            <section id="bundled-dependencies" class="space-y-3">
                <h2 class="text-xl font-medium">Bundled dependencies</h2>
                <p>The compiled assets include the following libraries. The generated notices below contain their license text, copyright, and transitive dependencies.</p>
                <div class="overflow-x-auto rounded-xl border border-slate-300 dark:border-slate-600">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-100 dark:bg-slate-900"><tr><th class="px-4 py-3">Library</th><th class="px-4 py-3">License</th></tr></thead>
                        <tbody class="divide-y divide-slate-300 dark:divide-slate-600">
                            <tr><td class="px-4 py-3">Flatpickr</td><td class="px-4 py-3">MIT</td></tr>
                            <tr><td class="px-4 py-3">libphonenumber-js and numbering metadata</td><td class="px-4 py-3">MIT and Apache-2.0</td></tr>
                            <tr><td class="px-4 py-3">Tom Select, Sifter, Unicode Variants</td><td class="px-4 py-3">Apache-2.0</td></tr>
                            <tr><td class="px-4 py-3">FilePond and bundled validation/preview plugins</td><td class="px-4 py-3">MIT</td></tr>
                            <tr><td class="px-4 py-3">Tiptap, Tiptap UI, React, ProseMirror, Radix UI, Floating UI</td><td class="px-4 py-3">MIT</td></tr>
                            <tr><td class="px-4 py-3">FullCalendar Standard and Preact</td><td class="px-4 py-3">MIT</td></tr>
                            <tr><td class="px-4 py-3">Chart.js, its date adapter, date-fns, and @kurkle/color</td><td class="px-4 py-3">MIT</td></tr>
                        </tbody>
                    </table>
                </div>
                <p>Keep these notices when distributing the bundled assets. Optional icon packs, FullCalendar Premium, and paid Tiptap extensions are not included; review their licenses separately if you add them.</p>
                <x-sirius::accordion id="package-notices" trigger="Full package dependency notices">
                    @if ($packageNotices === null)
                        <p role="status">Package dependency notices are unavailable in this installation.</p>
                    @else
                        <pre tabindex="0" class="max-h-96 overflow-y-auto whitespace-pre-wrap wrap-anywhere text-sm" data-license-source="package-notices">{{ $packageNotices }}</pre>
                    @endif
                </x-sirius::accordion>
            </section>
            <section id="application-dependencies" class="space-y-3">
                <h2 class="text-xl font-medium">Application dependencies</h2>
                <p>Composer installs Blade Icons, Heroicons, Illuminate, and Livewire as runtime dependencies. They declare MIT licenses and retain their own license files under <x-sirius::code>vendor</x-sirius::code>. Application dependencies and optional icon packs retain their own terms.</p>
            </section>
            <section id="documentation-license" class="space-y-3">
                <h2 class="text-xl font-medium">Documentation</h2>
                <p>The docs project declares MIT in <x-sirius::code>composer.json</x-sirius::code>. It currently has no separate root license file. Its integration assets have their own generated dependency notices:</p>
                <p>The Markdown renderer uses League CommonMark (BSD-3-Clause). Composer retains its license file in the installed dependency.</p>
                <p>The documentation font is Instrument Sans (<x-sirius::link href="https://raw.githubusercontent.com/google/fonts/main/ofl/instrumentsans/OFL.txt" target="_blank" rel="noopener noreferrer">SIL Open Font License 1.1</x-sirius::link>). Its copyright and license text are included in the notices below.</p>
                <x-sirius::accordion id="documentation-notices" trigger="Full documentation dependency notices">
                    @if ($documentationNotices === null)
                        <p role="status">Documentation dependency notices are unavailable in this installation.</p>
                    @else
                        <pre tabindex="0" class="max-h-96 overflow-y-auto whitespace-pre-wrap wrap-anywhere text-sm" data-license-source="documentation-notices">{{ $documentationNotices }}</pre>
                    @endif
                </x-sirius::accordion>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
