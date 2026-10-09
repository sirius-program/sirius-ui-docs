<?php

declare(strict_types=1);

it('uses initial submenu states and closes sibling submenus through keyboard interaction', function (): void {
    $page = visit('/blade-components/menu', ['reducedMotion' => 'reduce'])
        ->assertPresent('#team-links-submenu')
        ->assertAttribute('#project-links', 'aria-expanded', 'true')
        ->assertAttribute('#account-links', 'aria-expanded', 'false')
        ->keys('#account-links', 'Enter')
        ->assertAttribute('#account-links', 'aria-expanded', 'true')
        ->assertAttribute('#project-links', 'aria-expanded', 'false')
        ->assertMissing('#team-links-submenu');
    $page->keys('#account-links', 'Space')
        ->assertAttribute('#account-links', 'aria-expanded', 'false')
        ->keys('#project-links', 'Enter')
        ->keys('#project-links', 'Tab')
        ->assertScript('document.activeElement.id', 'project-home');
    $page->script('document.querySelector("#project-links").dataset.initialOpen = "false"');
    $page->assertScript('document.activeElement.id', 'project-links')
        ->assertScript('document.querySelector("#project-links-submenu").inert', true)
        ->assertScript('document.querySelector("#account-links-submenu").getAnimations().length', 0)
        ->assertNoJavaScriptErrors();
});

it('synchronizes submenus after Livewire updates and instance removal', function (): void {
    $page = visit('/development/navigation')->click('Toggle server open')
        ->assertAttribute('#livewire-group', 'aria-expanded', 'true')
        ->keys('#livewire-save', 'Escape')
        ->click('#livewire-group-action')->assertSeeIn('#navigation-count', 'Count: 1')
        ->assertAttribute('#livewire-group', 'aria-expanded', 'true')
        ->click('Rename export')->assertSeeIn('#livewire-group-action', 'Download')
        ->click('Toggle server open')->assertAttribute('#livewire-group', 'aria-expanded', 'false')
        ->keys('#livewire-group', 'Enter')
        ->assertAttribute('#livewire-group', 'aria-expanded', 'true')
        ->click('Toggle visibility')->assertNotPresent('#livewire-group')
        ->click('Toggle visibility')->assertAttribute('#livewire-group', 'aria-expanded', 'false');
    $page->assertScript('document.querySelectorAll("#livewire-group").length', 1)
        ->assertScript('document.querySelectorAll("#livewire-group-submenu").length', 1)
        ->assertNoJavaScriptErrors();
});

it('blocks disabled submenu activation and restores interaction after a Livewire update', function (): void {
    $page = visit('/development/navigation')->keys('#livewire-group', 'Enter')
        ->assertAttribute('#livewire-group', 'aria-expanded', 'true')
        ->click('Toggle disabled')->assertAttribute('#livewire-group', 'aria-disabled', 'true')
        ->assertAttribute('#livewire-group', 'aria-expanded', 'false');
    $page->script('window.triggerClicks = 0; const trigger = document.querySelector("#livewire-group"); trigger.addEventListener("click", () => window.triggerClicks++); trigger.click();');
    $page->keys('#livewire-group', 'Enter')->keys('#livewire-group', 'Space')
        ->assertScript('window.triggerClicks', 0)
        ->assertAttribute('#livewire-group', 'aria-expanded', 'false')
        ->assertScript('document.querySelector("#livewire-group-submenu").inert', true)
        ->click('Toggle disabled')->assertAttribute('#livewire-group', 'aria-disabled', 'false')
        ->keys('#livewire-group', 'Enter')->assertAttribute('#livewire-group', 'aria-expanded', 'true')
        ->assertNoJavaScriptErrors();
});

it('animates submenu opening and hides content immediately on closing and rapid toggles', function (): void {
    $page = visit('/blade-components/menu', ['reducedMotion' => 'no-preference']);
    $closedImmediately = $page->script('(() => { document.querySelector("#project-links").click(); const panel = document.querySelector("#project-links-submenu"); return panel.hidden && panel.inert && !panel.hasAttribute("data-closing"); })()');
    expect($closedImmediately)->toBeTrue();
    $page->assertMissing('#project-links-submenu')->click('#project-links')
        ->assertScript('getComputedStyle(document.querySelector("#project-links-submenu")).animationName', 'sir-menu-submenu-in');
    $page->script('const trigger = document.querySelector("#project-links"); trigger.click(); trigger.click();');
    $page->assertAttribute('#project-links', 'aria-expanded', 'true')
        ->assertScript('document.querySelector("#project-links-submenu").hidden || document.querySelector("#project-links-submenu").inert', false)
        ->assertScript('document.querySelector("#project-links-submenu").hasAttribute("data-closing")', false)
        ->assertNoJavaScriptErrors();
});

it('updates submenu state from an Alpine binding and restores focus when collapsed', function (): void {
    $page = visit('/blade-components/menu')->assertPresent('#team-links-submenu');
    $page->script('document.querySelector("#team-links-submenu a").focus(); Alpine.$data(document.querySelector("#team-links")).expanded = false;');
    $page->assertAttribute('#team-links', 'aria-expanded', 'false')->assertMissing('#team-links-submenu')
        ->assertScript('document.activeElement.id', 'team-links');
    $page->script('Alpine.$data(document.querySelector("#team-links")).expanded = true;');
    $page->assertAttribute('#team-links', 'aria-expanded', 'true')->assertPresent('#team-links-submenu')
        ->assertNoJavaScriptErrors();
});
