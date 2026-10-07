<x-layouts::app :title="__('AI Agent Skill')">
    <x-docs-page :navigation="['AI Agent Skill' => ['overview' => 'Overview', 'boost' => 'Laravel Boost', 'standalone' => 'Without Boost', 'activation' => 'Using the skill', 'updates' => 'Updates and customization', 'troubleshooting' => 'Troubleshooting', 'compatibility' => 'Compatibility']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header id="overview" class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">GETTING STARTED</p>
                <h1 class="text-3xl font-semibold">AI Agent Skill</h1>
                <p>Give your coding agent the Sirius UI APIs and examples that match your installed package.</p>
            </header>

            <section id="boost" class="space-y-4">
                <h2 class="text-2xl font-semibold">Laravel Boost</h2>
                <p>If your project uses Boost, run the installer and select <strong>Agent Skills</strong>, your agent, and <strong>sirius/ui (skills)</strong>.</p>
                <x-docs-code language="Shell">php artisan boost:install --skills</x-docs-code>
                <p>The package includes <code>resources/boost/skills/sirius-ui-development</code>, following <a class="underline" href="https://github.com/laravel/docs/blob/13.x/boost.md#third-party-package-skills" target="_blank" rel="noopener noreferrer">Boost's third-party skill convention</a>. Sirius UI must be a direct Composer dependency. Boost is optional for standalone installation.</p>
                <p>Boost writes Codex skills to <code>.agents/skills</code> and Claude Code skills to <code>.claude/skills</code>. Use one installation method per agent.</p>
            </section>

            <section id="standalone" class="space-y-4">
                <h2 class="text-2xl font-semibold">Without Boost</h2>
                <p>Run these commands in the Laravel project that installs Sirius UI. Choose one or both agents explicitly.</p>
                <x-docs-code language="Shell">php artisan sirius:skills:install --agent=codex --dry-run
php artisan sirius:skills:install --agent=codex
php artisan sirius:skills:install --agent=claude-code
php artisan sirius:skills:install --agent=codex --agent=claude-code</x-docs-code>
                <p>The command previews destinations and file changes before applying them. Repeating it updates the same skill; unchanged files stay untouched. It does not change <code>AGENTS.md</code>, <code>CLAUDE.md</code>, MCP settings, or other skills. Composer installation and provider boot do not install agent files.</p>
                <p>For manual installation, copy the <strong>entire</strong> <code>vendor/sirius/ui/resources/boost/skills/sirius-ui-development</code> folder to <code>.agents/skills/sirius-ui-development</code> or <code>.claude/skills/sirius-ui-development</code>. Keep all references beside <code>SKILL.md</code>. Manual copies are user-owned; compare and copy updates manually.</p>
            </section>

            <section id="activation" class="space-y-4">
                <h2 class="text-2xl font-semibold">Using the skill</h2>
                <p>Start a new agent session in the consuming project after installing or updating. Ask for a Sirius UI task, or invoke the skill explicitly.</p>
                <h3 class="text-lg font-medium">Codex</h3>
                <x-docs-code language="Text">$sirius-ui-development Build a validated Livewire project form using Sirius UI.</x-docs-code>
                <h3 class="text-lg font-medium">Claude Code</h3>
                <x-docs-code language="Text">/sirius-ui-development Build a scoped Sirius UI Table with date filters.</x-docs-code>
                <p>The skill covers components, form values, validation, themes, overlays, Table, Calendar, Chart, and application-owned actions. It loads detailed references only when needed. Your agent still needs to inspect the application's models, permissions, and tests.</p>
            </section>

            <section id="updates" class="space-y-4">
                <h2 class="text-2xl font-semibold">Updates and customization</h2>
                <p>After upgrading Sirius UI, refresh through the method that installed the skill.</p>
                <x-docs-code language="Shell"># Boost installation
php artisan boost:update

# Standalone installation
php artisan sirius:skills:install --agent=codex --dry-run
php artisan sirius:skills:install --agent=codex</x-docs-code>
                <p><strong>Boost:</strong> direct edits to installed package skill files are replaced on update. To customize, copy the complete bundle into <code>.ai/skills/sirius-ui-development</code>, edit it there, and run <code>boost:update</code>. The custom bundle overrides the package bundle; merge new package guidance into it manually.</p>
                <p><strong>Standalone:</strong> the ownership manifest tracks installed files. Customized files require confirmation before replacement. Originals are saved under <code>.sirius-ui-backups</code> inside the skill folder. <code>--no-interaction</code> refuses conflicts and leaves files intact. Review the preview, then run interactively to confirm, or merge your edits manually.</p>
                <p>Keep the ownership manifest with standalone files. Restore a damaged manifest from version control before updating. Unrelated files remain intact. If a destination uses a symlink or junction, use its existing owner rather than the standalone installer.</p>
            </section>

            <section id="troubleshooting" class="space-y-4">
                <h2 class="text-2xl font-semibold">Troubleshooting</h2>
                <ul class="list-disc space-y-2 pl-5">
                    <li><strong>Boost cannot find the skill:</strong> check <code>composer show sirius/ui</code>, the bundled <code>SKILL.md</code>, and the selected <code>sirius/ui</code> package. Check Boost exclusions and update its package scan.</li>
                    <li><strong>Agent cannot find it:</strong> open the consuming project root, check the chosen agent directory, and start a new session. Copying only <code>SKILL.md</code> omits required references.</li>
                    <li><strong>Old guidance:</strong> refresh after Composer upgrades. A custom Boost bundle must be merged manually.</li>
                    <li><strong>Ownership conflict:</strong> use <code>boost:update</code> for Boost-installed files. Standalone installation will not overwrite them.</li>
                </ul>
            </section>

            <section id="compatibility" class="space-y-4">
                <h2 class="text-2xl font-semibold">Compatibility</h2>
                <p>Tested with Boost 2.8.1 and Codex CLI 0.160.1, using Laravel 13.31.0 and Livewire 4.4.4. Both Boost and standalone Codex installations produced working form, Table, and Calendar examples. Claude Code installation is verified; its direct runtime evaluation is deferred. Other agents have not been tested.</p>
                <p>The skill ships with each package release and works offline. Review generated code and run your application's tests before relying on it.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
