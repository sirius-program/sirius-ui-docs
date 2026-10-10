<?php

declare(strict_types=1);

it('renders the Introduction and Icon reference pages in both mobile themes', function (string $path): void {
    $page = visit($path)->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true)
            ->assertScript('[...document.querySelectorAll("[data-docs-toc] a[href^=\"#\"]")].every(link => document.querySelectorAll(link.hash).length === 1)', true);
        if ($path === '/blade-components/icon') {
            $page->assertScript('[...document.querySelectorAll("[data-icon-families-demo] svg")].map(icon => icon.getAttribute("viewBox"))', ['0 0 24 24', '0 0 24 24', '0 0 20 20', '0 0 16 16'])
                ->assertScript('[...document.querySelectorAll("[data-icon-families-demo] svg")].every(icon => getComputedStyle(icon).width === "20px" && getComputedStyle(icon).height === "20px")', true);
        }
        $page->screenshot(fullPage: true, filename: ($path === '/blade-components/icon' ? 'phase3-icon' : 'phase3-introduction') . ($dark ? '-dark' : '-light'));
    }
    $page->assertNoJavaScriptErrors();
})->with(['/getting-started/introduction', '/blade-components/icon']);

it('copies extracted snippets literally and keeps highlighting after Livewire navigation', function (): void {
    $page = visit('/getting-started/installation')->assertPresent('#publish-assets .docs-token-attribute');
    $page->script('Object.defineProperty(navigator, "clipboard", { configurable: true, value: { writeText: async text => { window.copiedReference = text; } } });');
    $page->click('#install-package [data-copy-code]')->assertSeeIn('#install-package [data-copy-code]', 'Copied');
    expect($page->script('window.copiedReference'))->toBe('composer require sirius/ui');
    $page->script('Livewire.navigate("/blade-components/icon")');
    $page->assertPresent('#additional-icon-packs .docs-token-tag');
    $page->script('Object.defineProperty(navigator, "clipboard", { configurable: true, value: { writeText: async text => { window.copiedReference = text; } } });');
    $page->click('#additional-icon-packs [data-docs-code]:nth-of-type(2) [data-copy-code]')->assertSeeIn('#additional-icon-packs [data-docs-code]:nth-of-type(2) [data-copy-code]', 'Copied');
    expect($page->script('window.copiedReference'))->toBe('<x-sirius::icon name="lucide-activity" size="lg" />');
    $page->assertNoJavaScriptErrors();
});
