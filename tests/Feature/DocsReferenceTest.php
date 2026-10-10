<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;

it('keeps code snippet rendering inside example partials', function (): void {
    $violations = [];
    foreach ((new Filesystem)->allFiles(resource_path('views')) as $file) {
        $path = str_replace('\\', '/', $file->getRelativePathname());
        if (!str_contains('/' . $path, '/examples/') && preg_match('/<x-docs-code(?:\s|>)/', $file->getContents())) {
            $violations[] = $path;
        }
    }

    expect($violations)->toBeEmpty();
});

it('retains every component directory link and connects its Introduction sections', function (): void {
    $response = $this->get(route('started.introduction'))->assertOk();
    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);
    $directoryLinks = [];
    foreach ($xpath->query('//article//a[@href]') as $link) {
        $directoryLinks[] = $link->getAttribute('href');
    }
    $navigation = new DOMDocument;
    $navigation->loadHTML(Blade::render('<x-docs-navigation />'), LIBXML_NOERROR | LIBXML_NOWARNING);
    $navigationXPath = new DOMXPath($navigation);
    foreach ($navigationXPath->query('//a[contains(@href, "/blade-components/") or contains(@href, "/livewire-components/")]') as $link) {
        expect($directoryLinks)->toContain($link->getAttribute('href'));
    }
    foreach ($xpath->query('//*[@data-docs-toc]//a[starts-with(@href, "#")]') as $link) {
        expect($xpath->query('//*[@id="' . substr($link->getAttribute('href'), 1) . '"]')->length)->toBe(1);
    }
});

it('renders all bundled icon families and keeps optional icon examples literal', function (): void {
    $response = $this->get(route('blade-components.icon'))->assertOk();
    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);
    $viewBoxes = [];
    foreach ($xpath->query('//*[@data-icon-families-demo]//svg') as $svg) {
        $viewBoxes[] = $svg->getAttribute('viewbox');
    }

    expect($viewBoxes)->toBe(['0 0 24 24', '0 0 24 24', '0 0 20 20', '0 0 16 16']);
    expect($xpath->query('//article//svg')->length)->toBe(6);
    expect($xpath->query('//*[@id="additional-icon-packs"]//pre/code')->item(1)?->textContent)->toBe('<x-sirius::icon name="lucide-activity" size="lg" />');
    expect($xpath->query('//*[@id="custom-icon-sets"]//pre/code')->item(2)?->textContent)->toBe('<x-sirius::icon name="workspace-project" />');
});

it('preserves exact demo source through the shared example partial', function (): void {
    $view = 'blade-components.demos.icon-families';
    $source = trim(file_get_contents(resource_path('views/blade-components/demos/icon-families.blade.php')));
    $html = Blade::render('<x-docs-example :view="$view" />', ['view' => $view]);
    $document = new DOMDocument;
    $document->loadHTML('<html><head><meta charset="utf-8"></head><body>' . $html . '</body></html>', LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);

    expect($xpath->query('//pre/code')->item(0)?->textContent)->toBe($source);
    expect($xpath->query('//*[@data-copy-code]')->length)->toBe(1);
});
