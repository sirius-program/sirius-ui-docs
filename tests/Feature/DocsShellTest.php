<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('exposes the current documentation link with unique control IDs and no collapsed ancestor', function (string $path): void {
    $response = $this->get($path)->assertOk();
    $document = new DOMDocument;
    $previous = libxml_use_internal_errors(true);
    $document->loadHTML($response->getContent());
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    $xpath = new DOMXPath($document);
    expect($xpath->query('//*[@data-docs-navigation]//ul/*[not(self::li)]')->length)->toBe(0);
    expect($xpath->query('//*[@data-docs-navigation]//li[not(parent::ul)]')->length)->toBe(0);
    foreach ($xpath->query('//*[@data-docs-navigation]//button[@aria-controls]') as $trigger) {
        expect($xpath->query('//*[@id="' . $trigger->getAttribute('aria-controls') . '"]')->length)->toBe(1);
    }
    $ids = [];
    foreach ($xpath->query('//*[@id]') as $element) {
        $ids[] = $element->getAttribute('id');
    }
    expect($ids)->toHaveCount(count(array_unique($ids)));
    foreach ($xpath->query('//*[@data-docs-toc]//a[starts-with(@href, "#")]') as $link) {
        expect($ids)->toContain(substr($link->getAttribute('href'), 1));
    }
    $currentLink = '//aside[@data-docs-sidebar]//a[@aria-current="page" and contains(@href, "' . $path . '")]';
    expect($xpath->query($currentLink)->length)->toBe(1);
    expect($xpath->query($currentLink . '/ancestor::*[@hidden]')->length)->toBe(0);
})->with(['/getting-started/introduction', '/getting-started/ai-agent-skill', '/getting-started/installation', '/blade-components/input', '/livewire-components/table/query', '/livewire-components/calendar/events']);

it('renders installation asset examples as literal code instead of loading additional assets', function (): void {
    $this->get(route('started.installation'))->assertOk()->assertViewIs('installation')
        ->assertSee("@vite(['resources/css/app.css', 'resources/js/app.js'])")
        ->assertSee("{{ asset('vendor/sirius-ui/sirius.css') }}")
        ->assertSee("{{ asset('vendor/sirius-ui/sirius.js') }}");
});

it('renders exact escaped source through block Code inside the existing pre container', function (): void {
    $source = "\n\t<a href=\"#details\">Details</a>\n<code>literal code</code>\n\n";
    $html = Blade::render('<x-docs-code language="HTML" :source="$source" />', ['source' => $source]);
    $document = new DOMDocument;
    $previous = libxml_use_internal_errors(true);
    $document->loadHTML($html);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    $xpath = new DOMXPath($document);
    $code = $xpath->query('//pre/code')->item(0);

    expect($code?->textContent)->toBe($source);
    expect($code?->getAttribute('class'))->toContain('sir-code--block');
    expect($xpath->query('//pre')->item(0)?->getAttribute('tabindex'))->toBe('0');
    expect($xpath->query('//pre/a | //pre/code/code')->length)->toBe(0);
});

it('serves the landing page and standalone appearance settings with the shared shell', function (): void {
    $this->get('/')->assertOk()->assertSee('Getting Started')->assertSee('https://laravel.com/docs', false);
    $this->get('/settings/appearance')->assertOk()->assertSee('settings-appearance-dark')->assertSee('docs-main');
});
