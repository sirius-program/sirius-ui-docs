<x-layouts::app title="Changelog">
    <x-docs-page :navigation="['Changelog' => ['changes' => 'Release notes']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">GETTING STARTED</p>
                <h1 class="text-3xl font-semibold">Changelog</h1>
                <p>Release notes from the package and documentation source files.</p>
            </header>
            <section id="changes" class="space-y-3">
                <h2 class="text-xl font-medium">Release notes</h2>
                <p>Each tab reads its own <x-sirius::code>CHANGELOG.md</x-sirius::code> from the installed package or documentation checkout.</p>
                <x-sirius::tabs id="release-notes" label="Changelog sources" :items="['package' => 'Package', 'documentation' => 'Documentation']">
                    <x-slot:panel-package>
                        @if ($packageChangelog === null)
                            <p role="status">Package changelog is unavailable in this installation.</p>
                        @else
                            <div class="docs-markdown" data-changelog-source="package">{{ $packageChangelog }}</div>
                        @endif
                    </x-slot:panel-package>
                    <x-slot:panel-documentation>
                        @if ($documentationChangelog === null)
                            <p role="status">Documentation changelog is unavailable in this installation.</p>
                        @else
                            <div class="docs-markdown" data-changelog-source="documentation">{{ $documentationChangelog }}</div>
                        @endif
                    </x-slot:panel-documentation>
                </x-sirius::tabs>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
