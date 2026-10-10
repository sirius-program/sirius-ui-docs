<?php

declare(strict_types=1);

it('exposes meaningful icons through their accessible role and keeps decorative icons hidden', function (): void {
    visit('/blade-components/icon')
        ->assertPresent('role=img[name="Payment verified"]')
        ->assertAttributeMissing('role=img[name="Payment verified"]', 'aria-hidden')
        ->assertAttribute('role=img[name="Payment verified"]', 'focusable', 'false')
        ->assertScript('[...document.querySelectorAll("#icon-demo svg:not([role=\"img\"])")].every(icon => icon.getAttribute("aria-hidden") === "true")', true)
        ->assertNoJavaScriptErrors();
});

it('changes changelog tabs through keyboard interaction after Livewire navigation', function (): void {
    $page = visit('/getting-started/accessibility')->resize(1440, 1000)
        ->click('[data-docs-sidebar] a[href$="/getting-started/changelog"]')
        ->assertPathIs('/getting-started/changelog')->assertPresent('#release-notes-panel-package')
        ->assertMissing('#release-notes-panel-documentation')
        ->keys('#release-notes-tab-package', 'ArrowRight')
        ->assertAttribute('#release-notes-tab-documentation', 'aria-selected', 'true')
        ->assertPresent('#release-notes-panel-documentation')->assertMissing('#release-notes-panel-package')
        ->keys('#release-notes-tab-documentation', 'Home')
        ->assertAttribute('#release-notes-tab-package', 'aria-selected', 'true')
        ->assertPresent('#release-notes-panel-package')->assertNoJavaScriptErrors();
});

it('contains the new Getting Started pages in both mobile themes', function (string $pageName): void {
    $page = visit('/getting-started/' . $pageName)->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        if ($pageName === 'license') {
            $page->click('#package-notices-trigger')->assertVisible('[data-license-source="package-notices"]');
        }
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true)
            ->assertScript('[...document.querySelectorAll("[data-docs-toc] a[href^=\"#\"]")].every(link => document.querySelectorAll(link.hash).length === 1)', true);
        $page->script('window.scrollTo(0, 0)');
        $page->screenshot(fullPage: true, filename: 'phase4-' . $pageName . ($dark ? '-dark' : '-light'));
        if ($pageName === 'license') {
            $page->click('#package-notices-trigger')->assertMissing('[data-license-source="package-notices"]');
        }
    }
    $page->assertNoJavaScriptErrors();
})->with(['accessibility', 'license', 'changelog']);
