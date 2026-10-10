<?php

declare(strict_types=1);

namespace App\Support;

use Composer\InstalledVersions;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

final readonly class DocumentationSources
{
    public function __construct(private Filesystem $files) {}

    public function packageChangelog(): ?string
    {
        return $this->packageFile('CHANGELOG.md');
    }

    public function documentationChangelog(): ?string
    {
        return $this->read(base_path('CHANGELOG.md'));
    }

    public function packageLicense(): ?string
    {
        return $this->packageFile('LICENSE.md');
    }

    public function packageNotices(): ?string
    {
        return $this->packageFile('dist/third-party-notices.txt');
    }

    public function documentationNotices(): ?string
    {
        return $this->read(public_path('third-party-notices.txt'));
    }

    private function packageFile(string $filename): ?string
    {
        $root = InstalledVersions::isInstalled('sirius/ui') ? InstalledVersions::getInstallPath('sirius/ui') : null;

        return $root === null ? null : $this->read($root . '/' . $filename);
    }

    private function read(string $path): ?string
    {
        if (!$this->files->isFile($path) || !$this->files->isReadable($path)) {
            return null;
        }

        try {
            /**
             * @throws FileNotFoundException
             * @throws \ErrorException Laravel converts file-read warnings if permissions change after isReadable.
             */
            return $this->files->get($path);
        } catch (FileNotFoundException|\ErrorException) {
            return null;
        }
    }
}
