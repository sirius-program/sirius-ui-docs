<?php

declare(strict_types=1);

it('keeps dismissed messages hidden through Livewire updates and allows explicit reset', function (): void {
    $page = visit('/development/presentation');
    $page->script('window.dismissedIds = []; document.addEventListener("message:dismiss", event => window.dismissedIds.push(event.detail.id))');
    $page->click('#livewire-invoice-message [data-sir-message-dismiss]')->assertMissing('#livewire-invoice-message');
    $page->click('Refresh status')->assertSee('Status refreshed.')->assertMissing('#livewire-invoice-message');
    $page->click('Show message again')->assertVisible('#livewire-invoice-message');
    $page->click('#blade-invoice-message [data-sir-message-dismiss]')->assertMissing('#blade-invoice-message')->assertVisible('#livewire-invoice-message');
    expect($page->script('window.dismissedIds'))->toBe(['livewire-invoice-message', 'blade-invoice-message']);
    $page->assertNoJavaScriptErrors();
});

it('blocks disabled link actions and restores them after a Livewire update', function (): void {
    $page = visit('/development/presentation');
    $scope = '[data-presentation-example="button"]';
    $page->click($scope . ' button:has-text("Toggle disabled")')->assertAttribute($scope . ' [data-disabled-link]', 'aria-disabled', 'true');
    $page->script('document.querySelector("[data-disabled-link]").click()');
    $page->assertSee('Draft not saved.');
    $page->script('document.querySelector("[data-disabled-link]").dispatchEvent(new KeyboardEvent("keydown", { key: "Enter", bubbles: true, cancelable: true }))');
    $page->assertSee('Draft not saved.')->assertAttributeMissing($scope . ' [data-disabled-link]', 'href');
    $page->click($scope . ' button:has-text("Toggle disabled")')->assertAttribute($scope . ' [data-disabled-link]', 'aria-disabled', 'false');
    $page->click($scope . ' [data-disabled-link]')->assertSee('Draft saved.')->assertNoJavaScriptErrors();
});

it('runs native actions and grouped Livewire actions without introducing selection state', function (): void {
    $page = visit('/blade-components/button-group');
    $page->click('[data-demo-mode="blade"] button:has-text("Next")')->assertSee('Page 2')->assertNoJavaScriptErrors();
    $page = visit('/development/presentation');
    $page->click('[data-presentation-example="button-group"] button:has-text("Next")')->assertSee('Page 2')
        ->click('[data-presentation-example="button-group"] button:has-text("Previous")')->assertDontSee('Page 2')->assertNoJavaScriptErrors();
});

it('styles presentation components in both themes and preserves connected group corners', function (): void {
    $page = visit('/blade-components/badge');
    $page->script('document.documentElement.classList.add("dark")');
    $dark = $page->script('getComputedStyle(document.querySelector(".sir-badge.sir-tone--success")).backgroundColor');
    $page->script('document.documentElement.classList.remove("dark")');
    $light = $page->script('getComputedStyle(document.querySelector(".sir-badge.sir-tone--success")).backgroundColor');
    expect($light)->not->toBe($dark);
    $page->assertNoJavaScriptErrors();
    $page = visit('/blade-components/button-group');
    expect($page->script('getComputedStyle(document.querySelector(".sir-button-group > :first-child")).borderTopRightRadius'))->toBe('0px');
    expect($page->script('getComputedStyle(document.querySelector(".sir-button-group > :last-child")).borderTopLeftRadius'))->toBe('0px');
    expect($page->script('parseFloat(getComputedStyle(document.querySelector(".sir-button-group > :first-child")).borderTopLeftRadius) > 0'))->toBeTrue();
    $page->assertNoJavaScriptErrors();
});
