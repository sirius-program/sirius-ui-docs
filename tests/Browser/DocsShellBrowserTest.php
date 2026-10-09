<?php

declare(strict_types=1);

it('keeps the appearance dropdown aligned with its trigger without horizontal overflow after scrolling', function (int $width): void {
    $page = visit('/blade-components/dropdown')->inDarkMode()->resize($width, 844);
    $page->script('window.scrollTo(0, 200);');
    $page->assertScript('scrollY', 200)->click('#docs-appearance-menu-trigger')->assertPresent('#docs-appearance-menu-menu');
    $page->assertScript(<<<'JS'
    (() => {
        const panel = document.querySelector('#docs-appearance-menu-menu').getBoundingClientRect();
        const trigger = document.querySelector('#docs-appearance-menu-trigger').getBoundingClientRect();
        return panel.left >= 0 && panel.right <= document.documentElement.clientWidth
            && panel.top >= trigger.bottom && panel.bottom <= innerHeight
            && Math.abs(panel.right - trigger.right) <= 1
            && document.documentElement.scrollWidth <= document.documentElement.clientWidth;
    })()
    JS, true)->click('#header-appearance-light')->assertScript('document.documentElement.classList.contains("dark")', false)
        ->keys('#header-appearance-light', 'Escape')->assertMissing('#docs-appearance-menu-menu')->assertNoJavaScriptErrors();
})->with([390, 1440]);

it('persists light dark and system appearance across navigation and reload', function (): void {
    $page = visit('/blade-components/input')->inLightMode()->resize(1440, 1000);
    $page->click('#docs-appearance-menu-trigger')->click('#header-appearance-dark')
        ->assertScript('document.documentElement.classList.contains("dark")', true);
    $page->click('#docs-appearance-menu-trigger')
        ->click('[data-docs-sidebar] a[href$="/blade-components/textarea"]')
        ->assertPathIs('/blade-components/textarea')
        ->assertScript('document.documentElement.dataset.appearance', 'dark')
        ->click('#docs-appearance-menu-trigger')->assertChecked('#header-appearance-dark');
    $page->click('#header-appearance-light')->refresh()
        ->assertScript('document.documentElement.classList.contains("dark")', false)
        ->click('#docs-appearance-menu-trigger')->assertChecked('#header-appearance-light')
        ->click('#header-appearance-system')->refresh()
        ->assertScript('document.documentElement.dataset.appearance', 'system')
        ->assertScript('document.documentElement.classList.contains("dark")', false)
        ->assertNoJavaScriptErrors();
    $page->screenshot(fullPage: false, filename: 'phase25-desktop-light');
});

it('follows the operating system and survives unavailable appearance storage', function (): void {
    $page = visit('/settings/appearance')->inDarkMode()->assertChecked('#settings-appearance-system')
        ->assertScript('document.documentElement.classList.contains("dark")', true);
    $page->script('Storage.prototype.setItem = () => { throw new Error("Storage unavailable"); }; void 0;');
    $page->click('#settings-appearance-light')->assertScript('document.documentElement.classList.contains("dark")', false)
        ->click('#settings-appearance-system')->assertScript('document.documentElement.classList.contains("dark")', true)
        ->assertNoJavaScriptErrors();
});

it('keeps an existing appearance preference after upgrading the docs shell', function (): void {
    $page = visit('/dashboard')->inLightMode();
    $page->script('localStorage.setItem("flux.appearance", "dark"); void 0;');
    $page->refresh()->assertScript('document.documentElement.dataset.appearance', 'dark')
        ->assertScript('document.documentElement.classList.contains("dark")', true)
        ->click('#docs-appearance-menu-trigger')->click('#header-appearance-light')->refresh()
        ->assertScript('document.documentElement.dataset.appearance', 'light')
        ->assertNoJavaScriptErrors();
});

it('navigates on mobile and restores interaction after dismissal navigation and desktop resize', function (): void {
    $page = visit('/blade-components/input')->inDarkMode()->resize(390, 844)
        ->click('[aria-label="Open navigation"]')->assertPresent('#docs-navigation:modal')
        ->assertAttribute('#mobile-group-2', 'aria-expanded', 'true')
        ->click('#docs-navigation a[href$="/blade-components/textarea"]')
        ->assertPathIs('/blade-components/textarea')->assertMissing('#docs-navigation:modal');
    $page->assertScript('document.querySelector(".docs-workspace").inert', false)
        ->click('[aria-label="Open navigation"]')->keys('#docs-navigation', 'Escape')
        ->assertMissing('#docs-navigation:modal')
        ->assertScript('document.activeElement.getAttribute("aria-label")', 'Open navigation')
        ->click('[aria-label="Open navigation"]')->resize(1440, 1000)
        ->assertMissing('#docs-navigation:modal')
        ->assertScript('document.querySelector(".docs-workspace").inert', false)
        ->click('[data-docs-sidebar] button[data-sir-submenu-trigger]:has-text("Table")')
        ->click('[data-docs-sidebar] a[href$="/livewire-components/table/query"]')
        ->assertPathIs('/livewire-components/table/query')->assertAttribute('#desktop-group-8', 'aria-expanded', 'true')
        ->assertAttribute('[data-docs-sidebar] a[href$="/livewire-components/table/query"]', 'aria-current', 'page')
        ->assertNoJavaScriptErrors();
    $page->screenshot(fullPage: false, filename: 'phase25-desktop-dark');
    $page->resize(390, 844)->click('[aria-label="Open navigation"]');
    $page->screenshot(fullPage: false, filename: 'phase25-mobile-dark');
});
