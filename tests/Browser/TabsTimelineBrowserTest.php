<?php

declare(strict_types=1);

it('moves between automatic tabs with arrows Home End and Tab while skipping disabled tabs', function (): void {
    $page = visit('/blade-components/tabs')->keys('#project-sections-tab-overview', 'ArrowRight');
    $page->assertAttribute('#project-sections-tab-members', 'aria-selected', 'true')
        ->assertMissing('#project-sections-panel-overview')->assertPresent('#project-sections-panel-members')
        ->keys('#project-sections-tab-members', 'ArrowRight')->assertScript('document.activeElement.id', 'project-sections-tab-activity')
        ->keys('#project-sections-tab-activity', 'End')->assertAttribute('#project-sections-tab-activity', 'aria-selected', 'true')
        ->keys('#project-sections-tab-activity', 'ArrowRight')->assertScript('document.activeElement.id', 'project-sections-tab-overview')
        ->keys('#project-sections-tab-overview', 'Home')->keys('#project-sections-tab-overview', 'Tab')
        ->assertScript('document.activeElement.id', 'project-sections-panel-overview')->assertNoJavaScriptErrors();
});

it('requires Enter or Space in manual vertical tabs and follows RTL for horizontal tabs', function (): void {
    $page = visit('/blade-components/tabs')->keys('#workspace-settings-tab-notifications', 'ArrowDown');
    $page->assertScript('document.activeElement.id', 'workspace-settings-tab-access')
        ->assertAttribute('#workspace-settings-tab-notifications', 'aria-selected', 'true')
        ->keys('#workspace-settings-tab-access', 'Enter')->assertAttribute('#workspace-settings-tab-access', 'aria-selected', 'true')
        ->keys('#workspace-settings-tab-access', 'Home')->assertAttribute('#workspace-settings-tab-access', 'aria-selected', 'true')
        ->keys('#workspace-settings-tab-profile', 'Space')->assertAttribute('#workspace-settings-tab-profile', 'aria-selected', 'true');
    $page->script('document.querySelector("#project-sections").dir = "rtl"');
    $page->keys('#project-sections-tab-overview', 'ArrowLeft')->assertScript('document.activeElement.id', 'project-sections-tab-members')
        ->assertNoJavaScriptErrors();
});

it('preserves native form values across nested tab switches and submits inactive fields', function (): void {
    $page = visit('/development/tabs-timeline')->fill('#blade-project-title', 'New website')
        ->click('#nested-project-tabs-tab-files')->assertSeeIn('#nested-project-tabs-panel-files', 'Three files attached')
        ->assertAttribute('#blade-form-tabs-tab-overview', 'aria-selected', 'true')
        ->click('#blade-form-tabs-tab-notes')->fill('#blade-project-notes', 'Friday review')
        ->click('#blade-form-tabs-tab-overview')->assertValue('#blade-project-title', 'New website')
        ->assertAttribute('#nested-project-tabs-tab-files', 'aria-selected', 'true');
    expect($page->script('Object.fromEntries(new FormData(document.querySelector("#blade-tabs-form")))'))->toBe(['title' => 'New website', 'notes' => 'Friday review']);
    $page->keys('#blade-form-tabs-tab-overview', 'Tab')->assertScript('document.activeElement.id', 'blade-form-tabs-panel-overview')
        ->keys('#blade-form-tabs-panel-overview', 'Tab')->assertScript('document.activeElement.id', 'blade-project-title')
        ->assertNoJavaScriptErrors();
});

it('synchronizes bound Livewire tabs and retains local selection through unrelated morphs', function (): void {
    $page = visit('/development/tabs-timeline')->fill('#livewire-tab-title', 'Launch project')
        ->click('#livewire-project-tabs-tab-notes')->assertSeeIn('#tabs-server-state', 'notes')
        ->fill('#livewire-tab-notes', 'Review on Friday')->click('#save-tab-project')
        ->assertSeeIn('#tabs-revision', 'Revision: 1')->assertValue('#livewire-tab-notes', 'Review on Friday')
        ->click('#local-livewire-tabs-tab-notes')->click('#refresh-tabs')->assertSeeIn('#tabs-revision', 'Revision: 2')
        ->assertAttribute('#local-livewire-tabs-tab-notes', 'aria-selected', 'true')->assertPresent('#local-livewire-tabs-panel-notes')
        ->click('#livewire-project-tabs-tab-overview')->assertValue('#livewire-tab-title', 'Launch project')
        ->click('#server-select-notes')->assertAttribute('#livewire-project-tabs-tab-notes', 'aria-selected', 'true')
        ->assertValue('#livewire-tab-notes', 'Review on Friday')->assertNoJavaScriptErrors();
});

it('recovers disabled or removed active tabs and does not duplicate events after remounting', function (): void {
    $page = visit('/development/tabs-timeline')->click('#livewire-project-tabs-tab-notes')->click('#disable-notes');
    $page->assertAttribute('#livewire-project-tabs-tab-overview', 'aria-selected', 'true')->assertSeeIn('#tabs-server-state', 'overview')
        ->click('#disable-notes')->click('#livewire-project-tabs-tab-notes')->click('#remove-notes')
        ->assertAttribute('#livewire-project-tabs-tab-overview', 'aria-selected', 'true')->assertSeeIn('#tabs-server-state', 'overview')
        ->click('#remove-notes')->click('#toggle-tabs')->assertMissing('#livewire-project-tabs')
        ->click('#toggle-tabs')->assertPresent('#livewire-project-tabs');
    $page->script('window.tabChanges = []; document.querySelector("#tabs-livewire-fixture").addEventListener("tabs:change", event => { if (event.detail.id === "livewire-project-tabs") window.tabChanges.push(event.detail.value); })');
    $page->click('#livewire-project-tabs-tab-notes')->assertSeeIn('#tabs-server-state', 'notes');
    expect($page->script('window.tabChanges'))->toBe(['notes']);
    $page->assertNoJavaScriptErrors();
});

it('moves focus out of a hidden panel and responds to Alpine changes', function (): void {
    $page = visit('/development/tabs-timeline')->fill('#blade-project-title', 'Website');
    $page->script('document.querySelector("#blade-form-tabs").setAttribute("data-active", "notes")');
    $page->assertScript('document.activeElement.id', 'blade-form-tabs-tab-notes')
        ->assertAttribute('#blade-form-tabs-panel-overview', 'inert', '')
        ->click('#alpine-select-notes')->assertAttribute('#alpine-project-tabs-tab-notes', 'aria-selected', 'true')
        ->click('#alpine-project-tabs-tab-overview')->assertSeeIn('#alpine-tab-state', 'overview');
    $page->fill('#blade-project-notes', 'Draft');
    $page->script('document.querySelectorAll("#blade-form-tabs > [data-sir-tab-list] > button").forEach(tab => { tab.disabled = true; })');
    $page->assertScript('document.activeElement.id', 'blade-form-tabs')->assertMissing('#blade-form-tabs-panel-notes')
        ->assertNoJavaScriptErrors();
});

it('switches Dialog panels without losing values and reinitializes after navigation', function (): void {
    $page = visit('/development/tabs-timeline')->click('#tabs-overlay-trigger')->fill('#dialog-tab-title', 'New project')
        ->click('#dialog-project-tabs-tab-notes')->fill('#dialog-tab-notes', 'New notes')
        ->click('#dialog-project-tabs-tab-overview')->assertValue('#dialog-tab-title', 'New project')
        ->keys('#dialog-tab-title', 'Escape')->assertMissing('#tabs-overlay')
        ->click('#tabs-navigation')->assertPathIs('/blade-components/tabs')
        ->click('#project-sections-tab-members')->assertAttribute('#project-sections-tab-members', 'aria-selected', 'true')
        ->assertNoJavaScriptErrors();
});

it('renders Tabs and Timeline in both themes without mobile overflow', function (string $component): void {
    $page = visit('/blade-components/' . $component)->resize(390, 750);
    foreach (['light', 'dark'] as $theme) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($theme === 'dark' ? 'true' : 'false') . ')');
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true);
        if ($component === 'tabs') {
            $page->click('#project-sections-tab-activity')->assertPresent('#project-sections-panel-activity');
        } else {
            $page->assertPresent('#timeline-demo [aria-current="step"]');
        }
    }
    $page->assertNoJavaScriptErrors();
})->with(['tabs', 'timeline']);
