<?php

declare(strict_types=1);

it('navigates action menus and nested submenus by keyboard and restores focus on dismissal', function (): void {
    $page = visit('/blade-components/dropdown')->keys('#invoice-actions-trigger', 'ArrowDown');
    $page->assertScript('document.activeElement.id', 'invoice-copy')
        ->keys('#invoice-copy', 'ArrowDown')->assertScript('document.activeElement.id', 'invoice-export')
        ->keys('#invoice-export', 'ArrowRight')->assertScript('document.activeElement.id', 'invoice-pdf')
        ->keys('#invoice-pdf', 'ArrowDown')->keys('#invoice-spreadsheet', 'ArrowRight')
        ->assertScript('document.activeElement.id', 'invoice-csv')
        ->keys('#invoice-csv', 'ArrowLeft')->assertScript('document.activeElement.id', 'invoice-spreadsheet')
        ->keys('#invoice-spreadsheet', 'Escape')->assertScript('document.activeElement.id', 'invoice-export')
        ->keys('#invoice-export', 'Escape')->assertMissing('#invoice-actions-menu')
        ->assertScript('document.activeElement.id', 'invoice-actions-trigger');
    $page->keys('#invoice-actions-trigger', 'ArrowUp')->assertScript('document.activeElement.id', 'invoice-delete')
        ->keys('#invoice-delete', 'Enter')->assertSeeIn('#invoice-action-status', 'No action selected')
        ->assertAttribute('#invoice-actions-trigger', 'aria-expanded', 'true')
        ->keys('#invoice-delete', 'Home')->keys('#invoice-copy', 'Enter')
        ->assertSeeIn('#invoice-action-status', 'Invoice #1042 copied')->assertMissing('#invoice-actions-menu')
        ->assertScript('document.activeElement.id', 'invoice-actions-trigger')->assertNoJavaScriptErrors();
});

it('opens submenus by touch without hover and keeps panels inside a narrow viewport', function (): void {
    $page = visit('/blade-components/dropdown', ['hasTouch' => true])->resize(390, 844);
    $page->page()->locator('#invoice-actions-trigger')->tap();
    $page->assertPresent('#invoice-actions-menu');
    $page->page()->locator('#invoice-export')->tap();
    $page->assertPresent('#invoice-export-submenu');
    $page->page()->locator('#invoice-spreadsheet')->tap();
    $page->assertPresent('#invoice-spreadsheet-submenu');
    $page->assertScript('[...document.querySelectorAll("#invoice-actions [role=menu]:not([hidden])")].every(menu => { const r = menu.getBoundingClientRect(); return r.left >= 7 && r.right <= innerWidth - 7 && r.top >= 7 && r.bottom <= innerHeight - 7; })', true);
    $page->page()->locator('#invoice-csv')->tap();
    $page->assertSeeIn('#invoice-action-status', 'CSV export requested')->assertMissing('#invoice-actions-menu')
        ->click('#invoice-actions-trigger')->click('#workspace-actions-trigger')
        ->assertMissing('#invoice-actions-menu')->assertPresent('#workspace-actions-menu')
        ->assertSeeIn('#workspace-actions-menu .sir-nav-trailing', '3')
        ->click('#invoice-action-status')->assertMissing('#workspace-actions-menu')->assertNoJavaScriptErrors();
});

it('uses navigation disclosures and ordinary tab stops in a persistent menu', function (): void {
    $page = visit('/blade-components/menu')->assertAttribute('#workspace-menu a[data-active="true"]', 'aria-current', 'page')
        ->assertAttribute('#workspace-settings', 'aria-expanded', 'true')->assertPresent('#workspace-settings-submenu')
        ->keys('#workspace-billing', 'ArrowRight')->assertPresent('#workspace-billing-submenu');
    $page->keys('#workspace-billing-submenu button:not([disabled])', 'Enter')->assertSee('Invoice requested')
        ->keys('#workspace-billing-submenu button:not([disabled])', 'Escape')->assertMissing('#workspace-billing-submenu')
        ->assertScript('document.activeElement.id', 'workspace-billing')
        ->keys('#workspace-settings', 'Space')->assertMissing('#workspace-settings-submenu')
        ->assertScript('document.activeElement.id', 'workspace-settings')->assertNoJavaScriptErrors();
});

it('preserves open submenus through unrelated Livewire morphs and invokes each action once', function (): void {
    $page = visit('/development/navigation')->click('#livewire-actions-trigger')->click('#livewire-export')
        ->assertPresent('#livewire-export-submenu');
    $page->script('Livewire.find(document.querySelector("#livewire-actions").parentElement.getAttribute("wire:id")).rename()');
    $page->assertSeeIn('#livewire-export', 'Download')->assertPresent('#livewire-export-submenu')
        ->assertAttribute('#livewire-export', 'aria-expanded', 'true')->assertPresent('#livewire-actions-menu')
        ->click('#livewire-pdf')->assertSeeIn('#navigation-count', 'Count: 1')->assertMissing('#livewire-actions-menu')
        ->click('#livewire-actions-trigger')->click('#livewire-save')->assertSeeIn('#navigation-count', 'Count: 2')
        ->assertSeeIn('#navigation-clicks', 'Clicks: 1')->assertMissing('#livewire-actions-menu')->assertNoJavaScriptErrors();
});

it('blocks disabled Alpine and Livewire actions and supports long menu keyboard scrolling', function (): void {
    $page = visit('/development/navigation')->resize(1024, 600)->click('Toggle disabled')->click('#livewire-actions-trigger');
    $page->assertAttribute('#livewire-save', 'aria-disabled', 'true')->keys('#livewire-save', 'Enter')
        ->assertSeeIn('#navigation-count', 'Count: 0')->assertSeeIn('#navigation-clicks', 'Clicks: 0')
        ->assertAttribute('#livewire-actions-trigger', 'aria-expanded', 'true')
        ->keys('#livewire-save', 'End')->assertScript('document.activeElement.id', 'recent-24')
        ->assertScript('document.querySelector("#livewire-actions-menu").scrollTop > 0', true)
        ->keys('#recent-24', 'Home')->keys('#livewire-save', 'e')->assertScript('document.activeElement.id', 'livewire-export')
        ->keys('#livewire-export', 'Tab')->assertMissing('#livewire-actions-menu')->assertNoJavaScriptErrors();
});

it('synchronizes server open state and cleans up removed instances and navigation', function (): void {
    $page = visit('/development/navigation')->click('Toggle server open')->assertPresent('#livewire-actions-menu')
        ->assertScript('document.activeElement.id', 'livewire-save')
        ->assertAttribute('#livewire-actions-trigger', 'aria-expanded', 'true')
        ->click('Toggle server open')->assertMissing('#livewire-actions-menu')
        ->click('#livewire-actions-trigger')->click('Toggle visibility')->assertNotPresent('#livewire-actions')
        ->click('Toggle visibility')->assertMissing('#livewire-actions-menu')
        ->click('#livewire-settings')->assertPresent('#livewire-settings-submenu');
    $page->script('Livewire.find(document.querySelector("#livewire-menu").parentElement.getAttribute("wire:id")).increment()');
    $page->assertSeeIn('#navigation-count', 'Count: 1')->assertPresent('#livewire-settings-submenu');
    $page->script('Livewire.navigate("/blade-components/dropdown")');
    $page->click('#workspace-actions-trigger')->click('#workspace-actions-menu a:has-text("Dashboard")')
        ->assertPathIs('/dashboard');
    $page->script('Livewire.navigate("/development/navigation")');
    $page->click('#livewire-actions-trigger')->click('#livewire-save')->assertSeeIn('#navigation-count', 'Count: 1')
        ->assertSeeIn('#navigation-clicks', 'Clicks: 1')->assertNoJavaScriptErrors();
});

it('positions menus at viewport edges in RTL and honors reduced motion', function (): void {
    $page = visit('/blade-components/dropdown', ['reducedMotion' => 'reduce']);
    $page->script('document.documentElement.dir = "rtl"; document.querySelector("#invoice-actions").style.cssText = "position: fixed; right: 8px; bottom: 8px; z-index: 50"');
    $page->click('#invoice-actions-trigger')->click('#invoice-export')->assertPresent('#invoice-export-submenu')
        ->assertScript('getComputedStyle(document.querySelector("#invoice-actions-menu")).animationName', 'none')
        ->assertScript('[...document.querySelectorAll("#invoice-actions [role=menu]:not([hidden])")].every(menu => { const r = menu.getBoundingClientRect(); return r.left >= 7 && r.right <= innerWidth - 7 && r.top >= 7 && r.bottom <= innerHeight - 7; })', true)
        ->keys('#invoice-export', 'Escape')->assertMissing('#invoice-actions-menu')->assertNoJavaScriptErrors();
});

it('renders navigation demos without horizontal overflow in both mobile themes', function (string $component): void {
    $page = visit('/blade-components/' . $component, ['reducedMotion' => 'no-preference'])->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        if ($component === 'dropdown') {
            $page->click('#invoice-actions-trigger')->assertPresent('#invoice-actions-menu')
                ->assertScript('getComputedStyle(document.querySelector("#invoice-actions-menu")).animationName', 'sir-dropdown-in');
        }
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true);
        $page->screenshot(fullPage: true, filename: $component . '-mobile-' . ($dark ? 'dark' : 'light'));
        if ($component === 'dropdown') {
            $page->keys('#invoice-copy', 'Escape')->assertMissing('#invoice-actions-menu');
        }
    }
    $page->assertNoJavaScriptErrors();
})->with(['breadcrumb', 'menu', 'dropdown']);
