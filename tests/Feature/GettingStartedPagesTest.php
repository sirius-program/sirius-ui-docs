<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Illuminate\Filesystem\Filesystem;

it('renders license and dependency notices directly as escaped source text', function (): void {
    $response = $this->get(route('started.license'))->assertOk();
    $document = new DOMDocument;
    $document->loadHTML('<meta charset="utf-8">' . $response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);
    $package = InstalledVersions::getInstallPath('sirius/ui');
    $paths = [
        'package'               => $package . '/LICENSE.md',
        'package-notices'       => $package . '/dist/third-party-notices.txt',
        'documentation-notices' => public_path('third-party-notices.txt'),
    ];
    foreach ($paths as $name => $path) {
        $source = $xpath->query('//pre[@data-license-source="' . $name . '"]')->item(0);
        expect($source?->textContent)->toBe(file_get_contents($path));
        expect($xpath->query('//pre[@data-license-source="' . $name . '"]/*')->length)->toBe(0);
    }
});

it('includes the changelog source in exported documentation archives', function (): void {
    $attributes = app(Filesystem::class)->get(base_path('.gitattributes'));

    expect($attributes)->not->toMatch('/^\/?CHANGELOG\.md\s+.*export-ignore/m');
});
