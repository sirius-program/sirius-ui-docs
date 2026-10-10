<?php

declare(strict_types=1);

it('previews local form values safely and restores keyboard focus after closing', function (): void {
    $page = visit('/')->fill('#landing-project-title', '<img src=x onerror=alert(1)>')
        ->fill('#landing-project-seats', '8')->keys('#landing-project-updates', 'Space')
        ->keys('#landing-preview-trigger', 'Enter');

    $page->assertPresent('#landing-preview:modal')
        ->assertSeeIn('#landing-preview-title', '<img src=x onerror=alert(1)>')
        ->assertSeeIn('#landing-preview-seats', '8')->assertSeeIn('#landing-preview-updates', 'Off')
        ->assertScript('document.querySelector("#landing-preview-title img") === null', true)
        ->assertScript('document.activeElement.id', 'landing-preview-close')
        ->keys('#landing-preview-close', 'Escape')->assertMissing('#landing-preview:modal')
        ->assertScript('document.activeElement.id', 'landing-preview-trigger')
        ->click('#landing-toast-trigger')->assertPresent('#landing-toast-panel:popover-open')
        ->assertSeeIn('#landing-toast-panel', 'Nothing was saved.')
        ->assertPathIs('/')->click('#landing-toast-panel [data-sir-toast-close]')
        ->assertMissing('#landing-toast-panel:popover-open')
        ->refresh()->assertValue('#landing-project-title', 'Website redesign')->assertValue('#landing-project-seats', '5')
        ->assertChecked('#landing-project-updates')->assertNoJavaScriptErrors();
});

it('keeps appearance preferences when navigating between the landing and docs shells', function (): void {
    $page = visit('/')->inLightMode()->resize(1440, 1000)
        ->click('#landing-appearance-menu-trigger')->click('#landing-appearance-dark')
        ->keys('#landing-appearance-dark', 'Escape')
        ->click('.landing-header a:has-text("Documentation")')->assertPathIs('/getting-started/introduction');

    $page->assertScript('document.documentElement.classList.contains("dark")', true)
        ->assertPresent('[data-docs-sidebar]')->click('#docs-appearance-menu-trigger')
        ->assertChecked('#header-appearance-dark')->keys('#header-appearance-dark', 'Escape')
        ->click('[data-docs-header] a:has-text("Home")')->assertPathIs('/')
        ->assertMissing('[data-docs-sidebar]')->click('#landing-appearance-menu-trigger')
        ->assertChecked('#landing-appearance-dark')->click('#landing-appearance-light')->refresh()
        ->assertScript('document.documentElement.classList.contains("dark")', false)
        ->click('#landing-appearance-menu-trigger')->assertChecked('#landing-appearance-light')
        ->click('#landing-appearance-system')->refresh()
        ->assertScript('document.documentElement.dataset.appearance', 'system')
        ->assertScript('document.documentElement.classList.contains("dark")', false)
        ->assertNoJavaScriptErrors();
});

it('contains landing floating controls in both themes and viewport sizes with reduced motion', function (int $width, bool $dark): void {
    $pending = visit('/', ['reducedMotion' => 'reduce']);
    if ($dark) {
        $pending = $pending->inDarkMode();
    } else {
        $pending = $pending->inLightMode();
    }
    $page = $pending->resize($width, 844);
    $page->assertScript('document.documentElement.classList.contains("dark")', $dark);
    $page->keys('.docs-skip-link', 'Enter')->assertScript('document.activeElement.id', 'landing-main');
    $page->click('#landing-appearance-menu-trigger')->assertPresent('#landing-appearance-menu-menu');
    $page->assertScript(<<<'JS'
    (() => {
        const panel = document.querySelector('#landing-appearance-menu-menu').getBoundingClientRect();
        return panel.left >= 0 && panel.right <= innerWidth && panel.bottom <= innerHeight
            && document.documentElement.scrollWidth <= document.documentElement.clientWidth;
    })()
    JS, true)->keys('#landing-appearance-system', 'Escape');
    $page->script('window.scrollTo(0, 0)');
    $page->screenshot(fullPage: true, filename: 'phase6-landing-' . $width . ($dark ? '-dark' : '-light'));
    $page->click('#landing-preview-trigger')->assertPresent('#landing-preview:modal')
        ->assertScript(<<<'JS'
        (() => {
            const dialog = document.querySelector('#landing-preview').getBoundingClientRect();
            return dialog.left >= 0 && dialog.right <= innerWidth && dialog.top >= 0 && dialog.bottom <= innerHeight;
        })()
        JS, true)->click('#landing-preview-close')->assertMissing('#landing-preview:modal')
        ->click('[data-landing-buttons] button:has-text("Primary")')->assertPresent('#landing-toast-panel:popover-open')
        ->assertScript(<<<'JS'
        (() => {
            const toast = document.querySelector('#landing-toast-panel').getBoundingClientRect();
            return toast.left >= 0 && toast.right <= innerWidth && toast.top >= 0 && toast.bottom <= innerHeight
                && document.documentElement.scrollWidth <= document.documentElement.clientWidth;
        })()
        JS, true)->assertNoJavaScriptErrors();
})->with([[320, true], [390, false], [390, true], [1440, false], [1440, true]]);
