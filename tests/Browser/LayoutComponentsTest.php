<?php

declare(strict_types=1);

it('toggles independent disclosures with the keyboard and restores focus from closed content', function (): void {
    $page = visit('/blade-components/accordion');
    $page->assertAttribute('#shipping-details-trigger', 'aria-expanded', 'false')
        ->keys('#shipping-details-trigger', 'Space')->assertAttribute('#shipping-details-trigger', 'aria-expanded', 'true')
        ->assertAttribute('#returns-policy-trigger', 'aria-expanded', 'true')
        ->keys('#shipping-details-trigger', 'Enter')->assertAttribute('#shipping-details-trigger', 'aria-expanded', 'false');
    $page->script('document.querySelector("#shipping-details-content a").focus()');
    expect($page->script('document.activeElement.closest("#shipping-details-content") === null'))->toBeTrue();
    $page->keys('#shipping-details-trigger', 'Enter')->assertAttribute('#shipping-details-trigger', 'aria-expanded', 'true');
    $page->script('document.querySelector("#shipping-details-content a").focus(); document.querySelector("#shipping-details").open = false');
    $page->assertAttribute('#shipping-details-trigger', 'aria-expanded', 'false');
    expect($page->script('document.activeElement.id'))->toBe('shipping-details-trigger');
    $page->assertNoJavaScriptErrors();
});

it('synchronizes disclosure state with Livewire updates and remounts', function (): void {
    $page = visit('/development/layout-components');
    $page->click('Toggle from server')->assertAttribute('#livewire-shipping-trigger', 'aria-expanded', 'true')
        ->click('Refresh invoice')->assertSee('Invoice revision 1')->assertAttribute('#livewire-shipping-trigger', 'aria-expanded', 'true')
        ->click('#livewire-shipping-trigger')->assertSeeIn('[data-layout-state]', 'Closed')
        ->click('Refresh invoice')->assertSee('Invoice revision 2')->assertAttribute('#livewire-shipping-trigger', 'aria-expanded', 'false')
        ->click('Toggle visibility')->assertNotPresent('#livewire-shipping')
        ->click('Toggle visibility')->assertPresent('#livewire-shipping')
        ->keys('#livewire-shipping-trigger', 'Space')->assertSeeIn('[data-layout-state]', 'Open')->assertNoJavaScriptErrors();
});

it('opens one accordion item per group and allows every item to close', function (): void {
    $page = visit('/blade-components/accordion');
    $page->assertAttribute('#order-payment-trigger', 'aria-expanded', 'true')
        ->assertAttribute('#order-delivery-trigger', 'aria-expanded', 'false')
        ->keys('#order-delivery-trigger', 'Enter')
        ->assertAttribute('#order-delivery-trigger', 'aria-expanded', 'true')
        ->assertAttribute('#order-payment-trigger', 'aria-expanded', 'false')
        ->assertAttribute('#returns-policy-trigger', 'aria-expanded', 'true')
        ->keys('#order-refund-trigger', 'Space')
        ->assertAttribute('#order-refund-trigger', 'aria-expanded', 'true')
        ->assertAttribute('#order-delivery-trigger', 'aria-expanded', 'false')
        ->click('#order-refund-trigger')
        ->assertAttribute('#order-refund-trigger', 'aria-expanded', 'false');
    expect($page->script('document.querySelectorAll("details[name=order-help][open]").length'))->toBe(0);
    $page->assertNoJavaScriptErrors();
});

it('supports bound open state and emits one state change per actual toggle', function (): void {
    $page = visit('/blade-components/accordion');
    $page->script('window.disclosureEvents = []; document.addEventListener("accordion:toggle", event => window.disclosureEvents.push(event.detail)); document.querySelector("#shipping-details").open = true');
    $page->assertAttribute('#shipping-details-trigger', 'aria-expanded', 'true');
    expect($page->script('window.disclosureEvents'))->toBe([['id' => 'shipping-details', 'open' => true]]);
    $page->script('document.querySelector("#shipping-details").open = false');
    $page->assertAttribute('#shipping-details-trigger', 'aria-expanded', 'false');
    expect($page->script('window.disclosureEvents.length'))->toBe(2);
    $page->assertNoJavaScriptErrors();
});
