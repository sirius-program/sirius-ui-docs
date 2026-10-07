<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\Filesystem;
use Laravel\Boost\Console\InstallCommand;
use Laravel\Boost\Console\UpdateCommand;
use Laravel\Boost\Install\SkillComposer;
use Laravel\Boost\Install\ThirdPartyPackage;
use Laravel\Roster\ProjectManager;
use Sirius\Ui\Support\SkillInstallation;
use Sirius\Ui\Support\SkillInstaller;

it('discovers installs and refreshes the package skill through real Boost commands without writing the docs agent files', function (): void {
    $files = new Filesystem;
    $original = base_path();
    $project = $original . '/.phpunit.cache/boost-consumers/' . bin2hex(random_bytes(8));
    $files->ensureDirectoryExists($project);
    $manifest = json_decode($files->get($original . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
    $manifest['config']['vendor-dir'] = $original . '/vendor';
    $files->put($project . '/composer.json', json_encode($manifest, JSON_THROW_ON_ERROR));
    $files->copy($original . '/composer.lock', $project . '/composer.lock');
    $files->put($project . '/boost.json', json_encode([
        'agents'     => ['codex', 'claude_code'], 'packages' => ['sirius/ui'], 'skills' => ['sirius-ui-development'],
        'guidelines' => false, 'mcp' => false, 'cloud' => false, 'nightwatch' => false, 'sail' => false,
    ], JSON_THROW_ON_ERROR));
    $originalInstructions = $files->get($original . '/AGENTS.md');
    app()->setBasePath($project);
    try {
        $manager = new ProjectManager;
        $manager->fresh();
        app()->instance(ProjectManager::class, $manager);
        app()->forgetInstance(SkillComposer::class);
        // Boost deliberately disables command registration while running PHPUnit.
        app(Kernel::class)->registerCommand(app(InstallCommand::class));
        app(Kernel::class)->registerCommand(app(UpdateCommand::class));
        $package = ThirdPartyPackage::discover($manager)->get('sirius/ui');
        expect($package)->not->toBeNull();
        expect($package?->hasSkills)->toBeTrue();
        $this->artisan(InstallCommand::class, ['--skills' => true, '--no-interaction' => true])->assertSuccessful();
        $source = $original . '/vendor/sirius/ui/resources/boost/skills/sirius-ui-development';
        foreach (['.agents/skills', '.claude/skills'] as $directory) {
            foreach ($files->allFiles($source) as $file) {
                expect($files->get($project . '/' . $directory . '/sirius-ui-development/' . $file->getRelativePathname()))->toBe($file->getContents());
            }
        }
        expect(fn (): SkillInstallation => (new SkillInstaller($files))->plan($project, 'codex'))->toThrow(RuntimeException::class, 'boost:update');
        $installed = $project . '/.agents/skills/sirius-ui-development/SKILL.md';
        $files->put($installed, 'Direct local edits are replaced by Boost');
        $this->artisan(UpdateCommand::class, ['--no-discover' => true, '--no-interaction' => true])->assertSuccessful();
        expect($files->get($installed))->toBe($files->get($source . '/SKILL.md'));

        $custom = $project . '/.ai/skills/sirius-ui-development';
        $files->copyDirectory($source, $custom);
        $files->append($custom . '/SKILL.md', "\nConsumer-specific instructions\n");
        app()->forgetInstance(SkillComposer::class);
        $this->artisan(UpdateCommand::class, ['--no-discover' => true, '--no-interaction' => true])->assertSuccessful();
        expect($files->get($installed))->toContain('Consumer-specific instructions');
        expect($files->get($project . '/.claude/skills/sirius-ui-development/references/table.md'))->toBe($files->get($custom . '/references/table.md'));
        expect($files->get($custom . '/SKILL.md'))->toContain('Consumer-specific instructions');
        expect($files->get($original . '/AGENTS.md'))->toBe($originalInstructions);
    } finally {
        app()->setBasePath($original);
        app()->forgetInstance(ProjectManager::class);
        app()->forgetInstance(SkillComposer::class);
    }
});
