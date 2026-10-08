<?php

declare(strict_types=1);

it('exposes the current documentation link inside an open group with unique control IDs', function (string $path): void {
    $response = $this->get($path)->assertOk();
    $document = new DOMDocument;
    $previous = libxml_use_internal_errors(true);
    $document->loadHTML($response->getContent());
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    $xpath = new DOMXPath($document);
    $ids = [];
    foreach ($xpath->query('//*[@id]') as $element) {
        $ids[] = $element->getAttribute('id');
    }
    expect($ids)->toHaveCount(count(array_unique($ids)));
    expect($xpath->query('//aside[@data-docs-sidebar]//a[@aria-current="page" and contains(@href, "' . $path . '")]/ancestor::details[@open]')->length)->toBe(1);
})->with(['/getting-started/ai-agent-skill', '/getting-started/installation', '/blade-components/input', '/livewire-components/table/query', '/livewire-components/calendar/events']);

it('renders installation asset examples as literal code instead of loading additional assets', function (): void {
    $this->get(route('started.installation'))->assertOk()->assertViewIs('installation')
        ->assertSee("@vite(['resources/css/app.css', 'resources/js/app.js'])")
        ->assertSee("{{ asset('vendor/sirius-ui/sirius.css') }}")
        ->assertSee("{{ asset('vendor/sirius-ui/sirius.js') }}");
});

it('serves the landing page and standalone appearance settings with the shared shell', function (): void {
    $this->get('/')->assertOk()->assertSee('Getting Started')->assertSee('https://laravel.com/docs', false);
    $this->get('/settings/appearance')->assertOk()->assertSee('settings-appearance-dark')->assertSee('docs-main');
});
