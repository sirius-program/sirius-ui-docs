<?php

declare(strict_types=1);

use App\Support\DocumentationMarkdown;

it('renders nested Markdown links and both code block types with Sirius components', function (): void {
    $source = <<<'MARKDOWN'
# Releases

[**Details** `version`](https://example.test/releases "Release notes")

```blade
<x-sirius::link href="/project">Project</x-sirius::link>
{{ 2 + 2 }} @php throw new Exception('must not execute'); @endphp
```

    <code>indented</code>
MARKDOWN;
    $html = app(DocumentationMarkdown::class)->render($source)->toHtml();
    $document = new DOMDocument;
    $document->loadHTML('<html><head><meta charset="utf-8"></head><body>' . $html . '</body></html>', LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);

    expect($xpath->query('//h1')->length)->toBe(0);
    expect($xpath->query('//h2')->item(0)?->textContent)->toBe('Releases');
    $link = $xpath->query('//a')->item(0);
    expect($link?->getAttribute('href'))->toBe('https://example.test/releases');
    expect($link?->getAttribute('title'))->toBe('Release notes');
    expect($link?->getAttribute('class'))->toContain('sir-link');
    expect($xpath->query('//a/strong')->item(0)?->textContent)->toBe('Details');
    expect($xpath->query('//a/code')->item(0)?->getAttribute('class'))->toContain('sir-code');
    $blocks = $xpath->query('//pre/code');
    expect($blocks->length)->toBe(2);
    expect($blocks->item(0)?->getAttribute('class'))->toContain('sir-code--block', 'language-blade');
    expect($blocks->item(0)?->textContent)->toBe("<x-sirius::link href=\"/project\">Project</x-sirius::link>\n{{ 2 + 2 }} @php throw new Exception('must not execute'); @endphp\n");
    expect($blocks->item(1)?->textContent)->toBe("<code>indented</code>\n");
    expect($xpath->query('//pre//a | //pre/code/code')->length)->toBe(0);
});

it('strips raw HTML and preserves escaped literal code without executing Blade', function (): void {
    $html = app(DocumentationMarkdown::class)->render("<script>alert('unsafe')</script>\n\nBefore <span onclick=\"bad()\">inside</span> after.\n\n`<img src=x onerror=bad()>` {{ 2 + 2 }}")->toHtml();

    expect($html)->not->toContain('<script');
    expect($html)->not->toContain('<span');
    expect($html)->not->toContain('<img');
    expect($html)->toContain('Before inside after.', '&lt;img', '{{ 2 + 2 }}');
});

it('preserves text adjacent to inline code and links without template whitespace', function (): void {
    $html = app(DocumentationMarkdown::class)->render('A`code`B [link](https://example.test)C')->toHtml();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);

    expect($document->getElementsByTagName('p')->item(0)?->textContent)->toBe('AcodeB linkC');
});

it('removes unsafe Markdown destinations while retaining their visible text', function (string $destination): void {
    $html = app(DocumentationMarkdown::class)->render('[Unsafe](<' . $destination . '>)')->toHtml();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);

    expect($xpath->query('//a[@href]')->length)->toBe(0);
    expect($document->textContent)->toContain('Unsafe');
})->with(['javascript:alert(1)', 'javascript&#58;alert(1)', 'java&#x09;script:alert(1)', 'vbscript:msgbox(1)', 'data:text/html;base64,PHNjcmlwdD4=', 'file:///private/file', 'ftp://example.test/file']);

it('keeps supported schemes and relative Markdown destinations', function (string $destination): void {
    $html = app(DocumentationMarkdown::class)->render('[Details](<' . $destination . '>)')->toHtml();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    $link = $document->getElementsByTagName('a')->item(0);

    expect($link?->getAttribute('href'))->toBe($destination);
})->with(['https://example.test/?search=two%20words', 'mailto:team@example.test', 'tel:+62123', '/releases', '#releases']);

it('escapes Markdown link titles and keeps literal template expressions as data', function (): void {
    $html = app(DocumentationMarkdown::class)->render('[{{ 7 * 7 }}](https://example.test "&quot; onmouseover=&quot;bad()")')->toHtml();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    $link = $document->getElementsByTagName('a')->item(0);

    expect($link?->textContent)->toBe('{{ 7 * 7 }}');
    expect($link?->hasAttribute('onmouseover'))->toBeFalse();
});
