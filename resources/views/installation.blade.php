@php
    $viteLayout = <<<'BLADE'
@vite(['resources/css/app.css', 'resources/js/app.js'])
BLADE;
    $publishedAssets = <<<'BLADE'
<link rel="stylesheet" href="{{ asset('vendor/sirius-ui/sirius.css') }}">
<script src="{{ asset('vendor/sirius-ui/sirius.js') }}" defer></script>
BLADE;
@endphp

<x-layouts::app :title="__('Installation')">
    <x-docs-page :navigation="['Installation' => ['requirements' => 'Requirements', 'install-package' => 'Install package', 'load-assets' => 'Load assets', 'publish-assets' => 'Publish assets', 'publish-configuration' => 'Publish configuration', 'publish-translations' => 'Publish translations', 'ai-assistance' => 'AI assistance']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">GETTING STARTED</p>
                <h1 class="text-3xl font-semibold">Installation</h1>
                <p>Install Sirius UI in your Laravel application, load its assets, and customize the resources you need.</p>
            </header>

            <section id="requirements" class="space-y-4">
                <h2 class="text-xl font-medium">Requirements</h2>
                <ul class="list-disc space-y-2 pl-5">
                    <li>PHP <x-sirius::code>^8.3</x-sirius::code></li>
                    <li>Laravel <x-sirius::code>^12.61.1</x-sirius::code> or <x-sirius::code>^13.12.0</x-sirius::code></li>
                    <li>Livewire <x-sirius::code>^4.0</x-sirius::code></li>
                </ul>
                <p>Widgets and their dependencies are bundled, including Richtext's Tiptap UI and React runtime.</p>
            </section>

            <section id="install-package" class="space-y-4">
                <h2 class="text-xl font-medium">Install package</h2>
                <x-docs-code language="Shell" source="composer require sirius/ui" />
                <p>Laravel discovers the service provider automatically. Use <x-sirius::code>&lt;x-sirius::input /&gt;</x-sirius::code> for Blade components and <x-sirius::code>sirius</x-sirius::code> as the Livewire namespace.</p>
            </section>

            <section id="load-assets" class="space-y-4">
                <h2 class="text-xl font-medium">Load assets</h2>
                <p>Choose Vite imports or published assets and load the package CSS and JavaScript once.</p>
                <h3 class="text-lg font-medium">With Vite</h3>
                <p>Add this import to <x-sirius::code>resources/css/app.css</x-sirius::code>:</p>
                <x-docs-code language="CSS" source="@import '../../vendor/sirius/ui/dist/sirius.css';" />
                <p>Add this import to <x-sirius::code>resources/js/app.js</x-sirius::code>:</p>
                <x-docs-code language="JavaScript" source="import '../../vendor/sirius/ui/dist/sirius.js';" />
                <p>Load your application entries in the layout, then build the application assets:</p>
                <x-docs-code language="Blade" :source="$viteLayout" />
                <x-docs-code language="Shell" source="npm run build" />
                <p>For Livewire views, keep Livewire's own assets enabled and use its bundled Alpine runtime.</p>
            </section>

            <section id="publish-assets" class="space-y-4">
                <h2 class="text-xl font-medium">Publish assets</h2>
                <p>For applications without a bundler, publish the compiled assets:</p>
                <x-docs-code language="Shell" source="php artisan vendor:publish --tag=sirius-ui-assets" />
                <p>Load the published files in your layout:</p>
                <x-docs-code language="Blade" :source="$publishedAssets" />
                <p>The files and dependency license notices are copied to <x-sirius::code>public/vendor/sirius-ui</x-sirius::code>. Republish assets after package upgrades, reviewing any local changes before using <x-sirius::code>--force</x-sirius::code>.</p>
            </section>

            <section id="publish-configuration" class="space-y-4">
                <h2 class="text-xl font-medium">Publish configuration</h2>
                <x-docs-code language="Shell" source="php artisan vendor:publish --tag=sirius-ui-config" />
                <p>Edit <x-sirius::code>config/sirius-ui.php</x-sirius::code> to set Blade/Livewire namespaces, locale, timezone, phone country, currency separators and precision, or Toast position and duration. Component settings take priority over shared defaults.</p>
                <p>Publishing configuration is optional; the package supplies defaults.</p>
            </section>

            <section id="publish-translations" class="space-y-4">
                <h2 class="text-xl font-medium">Publish translations</h2>
                <x-docs-code language="Shell" source="php artisan vendor:publish --tag=sirius-ui-translations" />
                <p>Edit <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code> for component UI strings, grouped by component name. Edit <x-sirius::code>lang/vendor/sirius/{locale}/validation.php</x-sirius::code> for validation rule messages.</p>
                <p>English translations are included. Add other locale directories for your application. Each component's Translations section lists its keys and placeholders.</p>
            </section>

            <section id="ai-assistance" class="space-y-4">
                <h2 class="text-xl font-medium">AI assistance</h2>
                <p>The bundled <x-sirius::code>sirius-ui-development</x-sirius::code> skill gives coding agents package-specific guidance and offline API references.</p>
                <h3 class="text-lg font-medium">Project-local installation</h3>
                <p>Choose Codex, Claude Code, or both in your consuming Laravel project:</p>
                <x-docs-code language="Shell">php artisan sirius:skills:install --agent=codex
php artisan sirius:skills:install --agent=claude-code</x-docs-code>
                <p>Use <x-sirius::code>--dry-run</x-sirius::code> to preview changes. Re-run the installer after package upgrades; customized files require confirmation before replacement.</p>
                <h3 class="text-lg font-medium">Laravel Boost</h3>
                <p>If your project uses Boost, run the installer and select <strong>Agent Skills</strong>, your agent, and <strong>sirius/ui (skills)</strong>.</p>
                <x-docs-code language="Shell" source="php artisan boost:install --skills" />
                <p>Use one installation method per agent. For activation, updates, and troubleshooting, see <x-sirius::link href="{{ route('started.ai-agent-skill') }}" wire:navigate>AI Agent Skill</x-sirius::link>.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
