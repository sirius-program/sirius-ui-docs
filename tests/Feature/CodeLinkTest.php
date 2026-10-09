<?php

declare(strict_types=1);

it('renders Code and Link documentation with six tones separate snippets and working navigation', function (string $name, array $demos): void {
    $response = $this->get(route('blade-components.' . $name))->assertOk()
        ->assertSee('id="' . $name . '-demo"', false)
        ->assertSee('id="' . $name . '-usage"', false)
        ->assertSee('id="' . $name . '-attributes"', false)
        ->assertSee('data-demo-mode="blade"', false)->assertDontSee('data-demo-mode="livewire"', false);
    foreach (['primary', 'info', 'secondary', 'success', 'danger', 'warning'] as $tone) {
        $response->assertSee('sir-' . $name . ' sir-tone--' . $tone, false);
    }
    foreach ($demos as $demo) {
        $source = trim(file_get_contents(resource_path('views/blade-components/demos/' . $demo . '.blade.php')));
        $response->assertSee(e($source), false);
    }
    $document = new DOMDocument;
    $previous = libxml_use_internal_errors(true);
    $document->loadHTML($response->getContent());
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    $xpath = new DOMXPath($document);
    $active = '//aside[@data-docs-sidebar]//a[@aria-current="page" and contains(@href, "/blade-components/' . $name . '")]';
    expect($xpath->query($active)->length)->toBe(1);
    expect($xpath->query($active . '/ancestor::details[not(@open)]')->length)->toBe(0);
    $this->get(route('started.introduction'))->assertSee(route('blade-components.' . $name));
})->with([['code', ['code-inline', 'code-block']], ['link', ['link-variants', 'link-navigation']]]);

it('keeps block source whitespace and markup safe in the rendered demo', function (): void {
    $response = $this->get(route('blade-components.code'));
    expect($response->getContent())->toContain('&lt;main&gt;' . "\n    " . '&lt;h1&gt;Project overview&lt;/h1&gt;' . "\n" . '&lt;/main&gt;' . "\n</code>");
});
