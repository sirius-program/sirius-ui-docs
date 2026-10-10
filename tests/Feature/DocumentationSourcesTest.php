<?php

declare(strict_types=1);

use App\Support\DocumentationSources;
use Composer\InstalledVersions;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

it('reads the installed package and documentation sources from their fixed local paths', function (): void {
    $sources = app(DocumentationSources::class);
    $package = InstalledVersions::getInstallPath('sirius/ui');

    expect($sources->packageChangelog())->toBe(file_get_contents($package . '/CHANGELOG.md'));
    expect($sources->documentationChangelog())->toBe(file_get_contents(base_path('CHANGELOG.md')));
    expect($sources->packageLicense())->toBe(file_get_contents($package . '/LICENSE.md'));
    expect($sources->packageNotices())->toBe(file_get_contents($package . '/dist/third-party-notices.txt'));
    expect($sources->documentationNotices())->toBe(file_get_contents(public_path('third-party-notices.txt')));
});

it('renders independent changelogs and reads changes on each request', function (): void {
    $packagePath = InstalledVersions::getInstallPath('sirius/ui') . '/CHANGELOG.md';
    $documentationPath = base_path('CHANGELOG.md');
    $contents = [$packagePath => '# Package revision one', $documentationPath => '# Documentation revision one'];
    $files = Mockery::mock(Filesystem::class);
    $files->shouldReceive('isFile')->andReturnUsing(fn (string $path): bool => array_key_exists($path, $contents));
    $files->shouldReceive('isReadable')->andReturnTrue();
    $files->shouldReceive('get')->andReturnUsing(function (string $path) use (&$contents): string {
        return $contents[$path];
    });
    $this->instance(DocumentationSources::class, new DocumentationSources($files));

    $first = $this->get(route('started.changelog'))->assertOk();
    expect($first->viewData('packageChangelog')->toHtml())->toContain('Package revision one');
    expect($first->viewData('documentationChangelog')->toHtml())->toContain('Documentation revision one');

    $contents[$documentationPath] = '# Documentation revision two';
    $second = $this->get(route('started.changelog'))->assertOk();
    expect($second->viewData('packageChangelog')->toHtml())->toContain('Package revision one');
    expect($second->viewData('documentationChangelog')->toHtml())->toContain('Documentation revision two');

    $contents[$packagePath] = '# Package revision two';
    $third = $this->get(route('started.changelog'))->assertOk();
    expect($third->viewData('packageChangelog')->toHtml())->toContain('Package revision two');
    expect($third->viewData('documentationChangelog')->toHtml())->toContain('Documentation revision two');
});

it('shows unavailable sources without exposing paths when files are missing or unreadable', function (bool $exists): void {
    $files = Mockery::mock(Filesystem::class);
    $files->shouldReceive('isFile')->andReturn($exists);
    $files->shouldReceive('isReadable')->andReturnFalse();
    $files->shouldNotReceive('get');
    $this->instance(DocumentationSources::class, new DocumentationSources($files));

    $this->get(route('started.changelog'))->assertOk()
        ->assertSee('Package changelog is unavailable')->assertSee('Documentation changelog is unavailable')
        ->assertDontSee(base_path())->assertDontSee((string) InstalledVersions::getInstallPath('sirius/ui'));
    $this->get(route('started.license'))->assertOk()
        ->assertSee('Package license text is unavailable')->assertSee('Package dependency notices are unavailable')
        ->assertSee('Documentation dependency notices are unavailable')->assertDontSee(base_path());
})->with(['missing' => false, 'unreadable' => true]);

it('handles a source becoming unavailable between the readability check and reading', function (Throwable $exception): void {
    $files = Mockery::mock(Filesystem::class);
    $files->shouldReceive('isFile')->andReturnTrue();
    $files->shouldReceive('isReadable')->andReturnTrue();
    $files->shouldReceive('get')->andThrow($exception);
    $sources = new DocumentationSources($files);

    expect($sources->packageChangelog())->toBeNull();
    expect($sources->documentationChangelog())->toBeNull();
    expect($sources->packageLicense())->toBeNull();
})->with([new FileNotFoundException('private/local/path'), new ErrorException('private/local/path')]);
