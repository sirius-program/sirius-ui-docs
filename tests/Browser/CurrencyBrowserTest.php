<?php

declare(strict_types=1);

it('formats exact values and rejects malformed pastes without changing the previous amount', function (): void {
    $page = visit('/development/currency')->assertValue('#native-amount', '1,234.50')->assertValue('#native-reversed', '-1.250,125');
    expect($page->script('typeof window.Livewire'))->toBe('undefined');
    $page->type('#native-amount', '123456789012345678901234567890.50')->assertValue('#native-amount', '123,456,789,012,345,678,901,234,567,890.50');
    expect($page->script('new FormData(document.querySelector("form")).get("amount")'))->toBe('123456789012345678901234567890.50');
    foreach ([[' 1,234.50 ', '1,234.50'], ['.50', '0.50'], ['0', '0'], ['12.345', '12.345']] as [$pasted, $display]) {
        $page->script('(() => { const input = document.querySelector("#native-amount"); input.focus(); input.select(); const data = new DataTransfer(); data.setData("text/plain", ' . json_encode($pasted) . '); input.dispatchEvent(new ClipboardEvent("paste", {bubbles:true, cancelable:true, clipboardData:data})); })()');
        $page->assertValue('#native-amount', $display);
    }
    expect($page->script('document.querySelector("#native-amount").validationMessage'))->toBe('Use at most 2 decimal places.');
    foreach (['1,23', ',123', '123,', '1,,234', 'USD 50', '1e6', '1.234,50', '-50', '1.2.3'] as $pasted) {
        $page->script('(() => { const input = document.querySelector("#native-amount"); input.select(); const data = new DataTransfer(); data.setData("text/plain", ' . json_encode($pasted) . '); input.dispatchEvent(new ClipboardEvent("paste", {bubbles:true, cancelable:true, clipboardData:data})); })()');
        $page->assertValue('#native-amount', '12.345');
    }
    $page->type('#native-amount', '')->assertValue('#native-amount', '');
    expect($page->script('new FormData(document.querySelector("form")).get("amount")'))->toBe('');
    $page->type('#native-reversed', '-1234,50')->assertValue('#native-reversed', '-1.234,50');
    expect($page->script('new FormData(document.querySelector("form")).get("reversed")'))->toBe('-1234.50');
    $page->assertNoJavaScriptErrors();
});

it('preserves editing at decimal and grouping boundaries and enforces exact bounds', function (): void {
    $page = visit('/development/currency')->type('#native-amount', '.')->assertValue('#native-amount', '0.');
    $page->keys('#native-amount', '5')->assertValue('#native-amount', '0.5');
    $page->type('#native-amount', '1234');
    $page->script('document.querySelector("#native-amount").setSelectionRange(2,2)');
    $page->keys('#native-amount', 'Backspace')->assertValue('#native-amount', '234');
    expect($page->script('document.querySelector("#native-amount").selectionStart'))->toBe(0);
    $page->type('#native-amount', '1234');
    $page->script('document.querySelector("#native-amount").setSelectionRange(1,1)');
    $page->keys('#native-amount', 'Delete')->assertValue('#native-amount', '134');
    $page->type('#native-amount', '12.')->click('Currency integration')->assertValue('#native-amount', '12');
    $page->type('#native-reversed', '-')->click('Currency integration')->assertValue('#native-reversed', '');
    $page->type('#native-whole', '1.5');
    expect($page->script('document.querySelector("#native-whole").validity.valid'))->toBeFalse();
    $page->type('#native-bounds', '99999999999999999999.04');
    expect($page->script('document.querySelector("#native-bounds").validationMessage'))->toBe('The amount must not exceed 99999999999999999999.03.');
    $page->type('#native-bounds', '99999999999999999999.00');
    expect($page->script('document.querySelector("#native-bounds").validationMessage'))->toBe('The amount must be at least 99999999999999999999.01.');
    $page->click('Native reset')->assertValue('#native-amount', '1,234.50')->assertValue('#native-reversed', '-1.250,125')->assertValue('#native-whole', '0');
    expect($page->script('document.querySelector("#native-bounds").validity.valid'))->toBeTrue();
    $page->assertNoJavaScriptErrors();
});

it('submits only canonical native values and preserves disabled readonly and external form semantics', function (): void {
    $page = visit('/development/currency')->type('#external-amount', '3000.50');
    expect($page->script('Array.from(new FormData(document.querySelector("form")).entries())'))->toBe([
        ['amount', '1234.50'], ['reversed', '-1250.125'], ['whole', '0'], ['bounded', '99999999999999999999.02'],
        ['locked', '42.50'], ['space', '1234.50'], ['external', '3000.50'],
    ]);
    $page->assertDisabled('#native-disabled')->assertAttribute('#native-locked', 'readonly', 'readonly')
        ->click('Native reset')->assertValue('#external-amount', '2,500.00');
    $page = visit('/blade-components/currency')->type('#blade-currency-budget', '1234.50')->type('#blade-currency-adjustment', '-12,125')
        ->click('[data-blade-currency] button[value="validate"]')->assertSee('Amounts validated. Nothing was stored.')
        ->assertValue('#blade-currency-budget', '1,234.50')->assertValue('#blade-currency-adjustment', '-12,125');
    $page->type('#blade-currency-budget', '12.345')->click('[data-blade-currency] button[value="validate"]')
        ->assertSee('Enter a non-negative budget with at most 2 decimal places.')->assertValue('#blade-currency-budget', '12.345')
        ->click('[data-blade-currency] button[value="load"]')->assertValue('#blade-currency-budget', '1,234,567.50')
        ->click('[data-blade-currency] button[value="reset"]')->assertValue('#blade-currency-budget', '')->assertNoJavaScriptErrors();
});

it('synchronizes livewire values validation readonly reset remounts and navigation', function (): void {
    $page = visit('/blade-components/currency')->click('[data-currency-example] button:has-text("Load Value")')
        ->assertValue('[data-currency-budget]', '1,234,567.50')->assertValue('[data-currency-adjustment]', '-1.250,125');
    $page->type('[data-currency-budget]', '5000.50')->type('[data-currency-adjustment]', '-100,125')
        ->click('[data-currency-example] button:has-text("Submit / Validate")')->assertSee('Amounts validated. Nothing was stored.');
    expect($page->script('Livewire.find(document.querySelector("[data-currency-example]").getAttribute("wire:id")).$get("budget")'))->toBe('5000.50');
    expect($page->script('Livewire.find(document.querySelector("[data-currency-example]").getAttribute("wire:id")).$get("adjustment")'))->toBe('-100.125');
    $page->click('[data-currency-example] button:has-text("Toggle Readonly")')->assertAttribute('[data-currency-budget]', 'readonly', 'readonly')
        ->click('[data-currency-example] button:has-text("Load Value")')->assertValue('[data-currency-budget]', '1,234,567.50')
        ->click('[data-currency-example] button:has-text("Reset Sample")')->assertValue('[data-currency-budget]', '')
        ->click('[data-currency-example] button:has-text("Submit / Validate")')->assertSee('The budget field is required.');
    $page->script('Livewire.find(document.querySelector("[data-currency-example]").getAttribute("wire:id")).$set("showControls", false)');
    $page->assertMissing('[data-currency-budget]');
    $page->script('Livewire.find(document.querySelector("[data-currency-example]").getAttribute("wire:id")).$set("showControls", true)');
    $page->assertPresent('[data-currency-budget]')->click('[data-currency-example] button:has-text("Load Value")')->assertValue('[data-currency-budget]', '1,234,567.50');
    $page->click('Textarea')->click('Currency')->assertValue('[data-currency-budget]', '')->type('[data-currency-budget]', '0.50')->assertValue('[data-currency-budget]', '0.50')->assertNoJavaScriptErrors();
});

it('keeps modifier timing Alpine state and multiple Livewire instances independent', function (): void {
    $page = visit('/development/currency-bindings')->assertValue('#alpine-currency', '1,234.50');
    $state = 'Livewire.find(document.querySelector("[data-currency-bindings]").getAttribute("wire:id"))';
    $page->type('#binding-change', '1234.50');
    expect($page->script($state . '.$get("change")'))->toBe('');
    $page->click('Currency binding integration');
    expect($page->script($state . '.$get("change")'))->toBe('1234.50');
    $page->type('#binding-lazy', '4567.50')->click('Currency binding integration')->assertValue('#binding-lazy', '4,567.50');
    expect($page->script($state . '.$get("lazy")'))->toBe('4567.50');
    $page->type('#binding-enter', '7654.50')->keys('#binding-enter', 'Enter');
    expect($page->script($state . '.$get("enter")'))->toBe('7654.50');
    $page->type('#binding-deferred', '9876.50')->click('Refresh bindings')->assertValue('#binding-deferred', '9,876.50');
    expect($page->script($state . '.$get("deferred")'))->toBe('9876.50');
    $page->type('#alpine-currency', '2500.50')->assertSeeIn('[data-alpine-amount]', '2500.50')
        ->click('Load Alpine value')->assertValue('#alpine-currency', '9,876.50');
    $page->click('[data-currency-instance="first"] button:has-text("Load Value")')
        ->assertValue('[data-currency-instance="first"] [data-currency-budget]', '1,234,567.50')
        ->assertValue('[data-currency-instance="second"] [data-currency-budget]', '')
        ->assertNoJavaScriptErrors();
});

it('keeps currency documentation usable on narrow screens in both themes', function (): void {
    $page = visit('/blade-components/currency')->resize(390, 844)->assertPresent('[data-docs-props]');
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
        $page->screenshot(fullPage: true, filename: $dark ? 'currency-mobile-dark' : 'currency-mobile-light');
    }
    $page->assertNoJavaScriptErrors();
});

it('retains typed currency after a debounced Livewire render without a follow-up action', function (): void {
    $page = visit('/blade-components/currency');
    $page->typeSlowly('[data-currency-budget]', '1234.50', 250)->waitForEvent('networkidle')
        ->assertValue('[data-currency-budget]', '1,234.50');
    $page->type('[data-currency-budget]', '1234.')->waitForEvent('networkidle')
        ->assertValue('[data-currency-budget]', '1,234.');
    $page->keys('[data-currency-budget]', '5')->waitForEvent('networkidle')->assertValue('[data-currency-budget]', '1,234.5');
    $page->keys('[data-currency-budget]', '0')->waitForEvent('networkidle')->assertValue('[data-currency-budget]', '1,234.50');
    expect($page->script('Livewire.find(document.querySelector("[data-currency-example]").getAttribute("wire:id")).$get("budget")'))->toBe('1234.50');
    $page->assertNoJavaScriptErrors();
});
