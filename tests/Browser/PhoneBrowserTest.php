<?php

declare(strict_types=1);

it('formats native phone fields and submits only canonical values', function (): void {
    $page = visit('/development/phone')->assertValue('#native-phone', '812 3456 7890')->assertValue('#native-multiple', '20-7946-0018')->assertValue('#native-compact', '81234567890');
    expect($page->script('typeof window.Livewire'))->toBe('undefined');
    expect($page->script('Object.fromEntries(new FormData(document.querySelector("form")))'))->toBe([
        'phone' => '+6281234567890', 'multiple' => '+442079460018', 'all' => '', 'compact' => '+6281234567890', 'locked' => '+6281234567890', 'external' => '+6281234567890',
    ]);
    $page->type('#native-phone', '081234567891')->assertValue('#native-phone', '812 3456 7891');
    expect($page->script('new FormData(document.querySelector("form")).get("phone")'))->toBe('+6281234567891');
    $page->type('#native-phone', '0812')->click('Phone integration')->assertValue('#native-phone', '0812')->assertSee('Enter a valid phone number');
    expect($page->script('new FormData(document.querySelector("form")).get("phone")'))->toBe('');
    $page->type('#native-phone', '+442079460018')->click('Phone integration')->assertValue('#native-phone', '+442079460018');
    expect($page->script('document.querySelector("#native-phone").validity.valid'))->toBeFalse();
    $page->type('#external-phone', '0812')->click('Native reset')->assertValue('#external-phone', '812 3456 7890')->assertValue('#native-phone', '812 3456 7890')->assertNoJavaScriptErrors();
});

it('handles international paste country selection extensions and display delimiters', function (): void {
    $page = visit('/development/phone');
    $page->script('const input = document.querySelector("#native-all"); input.focus(); const data = new DataTransfer(); data.setData("text/plain", "+12025550123"); input.dispatchEvent(new ClipboardEvent("paste", { clipboardData: data, bubbles: true, cancelable: true }));');
    $page->assertValue('#native-all', '202.555.0123')->assertValue('[data-sir-phone]:has(#native-all) select', 'US');
    $prefixWidth = $page->script('document.querySelector("[data-sir-phone]:has(#native-all) select").getBoundingClientRect().width');
    $page->select('[data-sir-phone]:has(#native-all) select', 'IO');
    expect($page->script('document.querySelector("[data-sir-phone]:has(#native-all) select").getBoundingClientRect().width'))->toBe($prefixWidth);
    expect($page->script('document.querySelector("[data-sir-phone]:has(#native-all) select").selectedOptions[0].textContent.trim()'))->toStartWith('+246 - ');
    $page->select('[data-sir-phone]:has(#native-multiple) select', 'ID');
    expect($page->script('new FormData(document.querySelector("form")).get("multiple")'))->toBe('');
    $page->type('#native-multiple', '081234567890')->assertValue('#native-multiple', '812-3456-7890');
    $page->type('#native-all', '+12025550123 ext 12')->click('Phone integration')->assertValue('#native-all', '+12025550123 ext 12');
    expect($page->script('new FormData(document.querySelector("form")).get("all")'))->toBe('');
    $page->assertDisabled('[data-sir-phone]:has(#native-locked) select')->assertDisabled('#native-disabled')->assertNoJavaScriptErrors();
});

it('preserves livewire partial drafts and nullable models across validation and explicit resets', function (): void {
    $page = visit('/blade-components/phone')->typeSlowly('[data-phone-delivery]', '0812', 180)->waitForEvent('networkidle')->assertValue('[data-phone-delivery]', '0812');
    $wire = 'Livewire.find(document.querySelector("[data-phone-example]").getAttribute("wire:id"))';
    expect($page->script($wire . '.$get("delivery")'))->toBeNull();
    $page->click('[data-phone-example] button:has-text("Submit / Validate")')->assertSee('The delivery field is required.')->assertValue('[data-phone-delivery]', '0812');
    $page->click('[data-phone-example] button:has-text("Reset Sample")')->assertValue('[data-phone-delivery]', '');
    $page->click('[data-phone-example] button:has-text("Load Value")')->assertValue('[data-phone-delivery]', '812 3456 7890')->assertValue('[data-phone-partner]', '20-7946-0018');
    $page->type('[data-phone-delivery]', '081234567891')->click('[data-phone-example] button:has-text("Submit / Validate")')->assertSee('Phone contacts validated. Nothing was stored.');
    expect($page->script($wire . '.$get("delivery")'))->toBe('+6281234567891');
    $page->click('[data-phone-example] button:has-text("Toggle Readonly")')->assertAttribute('[data-phone-delivery]', 'readonly', 'readonly')
        ->assertDisabled('[data-phone-example] [data-sir-phone]:has([data-phone-partner]) select')->assertNoJavaScriptErrors();
});

it('restores native invalid drafts and submits loaded international contacts', function (): void {
    $page = visit('/blade-components/phone')->type('#blade-phone-delivery', '0812')
        ->click('[data-blade-phone] button[value="validate"]')->assertSee('The delivery field is required.')->assertValue('#blade-phone-delivery', '0812');
    $page->click('[data-blade-phone] button[value="load"]')->assertValue('#blade-phone-partner', '20-7946-0018')
        ->click('[data-blade-phone] button[value="validate"]')->assertSee('Phone contacts validated. Nothing was stored.')->assertNoJavaScriptErrors();
});

it('synchronizes Alpine and independent livewire instances through remount and navigation', function (): void {
    $page = visit('/development/phone-bindings')->assertValue('#alpine-phone', '812 3456 7890');
    $page->type('#alpine-phone', '0812')->assertSeeIn('[data-alpine-phone]', 'null')->click('Load Alpine phone')->assertValue('#alpine-phone', '812 3456 7891');
    $page->click('[data-phone-instance="first"] button:has-text("Load Value")')->assertValue('[data-phone-instance="first"] [data-phone-delivery]', '812 3456 7890')->assertValue('[data-phone-instance="second"] [data-phone-delivery]', '');
    $wire = 'Livewire.find(document.querySelector("[data-phone-instance=first] [data-phone-example]").getAttribute("wire:id"))';
    $page->script($wire . '.$set("showControls", false)');
    $page->assertMissing('[data-phone-instance="first"] [data-phone-delivery]');
    $page->script($wire . '.$set("showControls", true)');
    $page->assertValue('[data-phone-instance="first"] [data-phone-delivery]', '812 3456 7890');
    $page->click('Currency')->assertPresent('[data-currency-budget]')->click('Phone')->assertPresent('[data-phone-delivery]')->assertNoJavaScriptErrors();
});

it('keeps keyboard editing accessible and the phone layout within mobile light and dark screens', function (): void {
    $page = visit('/development/phone');
    $page->click('#native-phone');
    $page->script('document.querySelector("#native-phone").setSelectionRange(4, 4)');
    $page->keys('#native-phone', 'Backspace');
    expect($page->script('document.querySelector("#native-phone").value.replace(/\D/g, "")'))->toBe('8134567890');
    $page->type('#native-all', '+1')->click('Phone integration')->assertValue('#native-all', '+1');
    expect($page->script('new FormData(document.querySelector("form")).get("all")'))->toBe('');
    $page->type('#native-all', '+14165550123')->assertValue('[data-sir-phone]:has(#native-all) select', 'CA');
    expect($page->script('new FormData(document.querySelector("form")).get("all")'))->toBe('+14165550123');
    $page->script('document.querySelector("#native-phone").disabled = true');
    $page->assertDisabled('#native-phone');
    expect($page->script('new FormData(document.querySelector("form")).has("phone")'))->toBeFalse();
    $page->assertNoJavaScriptErrors();

    $page = visit('/blade-components/phone')->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
        $page->screenshot(fullPage: true, filename: $dark ? 'phone-mobile-dark' : 'phone-mobile-light');
    }
    $page->assertNoJavaScriptErrors();
});
