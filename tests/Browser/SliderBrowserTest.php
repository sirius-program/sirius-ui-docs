<?php

declare(strict_types=1);

it('moves independent slider grids with the keyboard and submits ordered native values', function (): void {
    $page = visit('/development/slider')->assertPresent('#native-slider-handle');
    expect($page->script('typeof window.Livewire'))->toBe('undefined');
    $page->keys('#native-slider-handle', 'ArrowRight')->assertValue('#native-slider', '0.4');
    $page->keys('#native-range-handle', 'End')->assertValue('#native-range', '78');
    $page->assertAttribute('#native-range-upper-handle', 'aria-valuemin', '80');
    $page->keys('#native-range-upper-handle', 'Home')->assertValue('#native-range-upper', '80');
    $page->keys('#native-range-handle', 'ArrowRight')->assertValue('#native-range', '78');
    $page->keys('#native-range-upper-handle', 'End')->assertValue('#native-range-upper', '100');
    $page->keys('#native-range-handle', 'Home')->assertValue('#native-range', '0');
    $page->keys('#native-range-handle', 'PageUp')->assertValue('#native-range', '30');
    expect($page->script('new FormData(document.querySelector("form")).getAll("prices[]")'))->toBe(['30', '100']);
    expect($page->script('Object.fromEntries(new FormData(document.querySelector("form")))'))->toMatchArray(['amount' => '0.4', 'locked' => '30', 'external' => '50']);
    expect($page->script('new FormData(document.querySelector("form")).has("disabled")'))->toBeFalse();
    $page->keys('#native-range-upper-handle', 'Home')->assertValue('#native-range-upper', '30');
    $page->keys('#native-range-handle', 'ArrowRight')->assertValue('#native-range', '30');
    $page->keys('#external-slider-handle', 'End')->assertValue('#external-slider', '100');
    $page->keys('#locked-slider-handle', 'End')->assertValue('#locked-slider', '30')->assertDisabled('#disabled-slider-handle');
    $page->click('Native reset')->assertValue('#native-slider', '0.3')->assertValue('#native-range', '21')->assertValue('#native-range-upper', '80')->assertValue('#external-slider', '50');
    $page->click('label[for="native-slider"]');
    expect($page->script('document.activeElement.id'))->toBe('native-slider-handle');
    $page->assertNoJavaScriptErrors();
});

it('synchronizes scalar and array bindings through server actions readonly and remounts', function (): void {
    $page = visit('/blade-components/slider')->assertValue('#discount', '10')->assertValue('#budget', '40');
    $page->keys('#discount-handle', 'ArrowRight')->keys('#discount-handle', 'ArrowRight')->keys('#discount-handle', 'ArrowRight')->assertValue('#discount', '25');
    $page->keys('#budget-handle', 'ArrowRight')->assertValue('#budget', '45');
    $page->click('[data-slider-example] button:has-text("Submit / Validate")')->assertSeeIn('[data-slider-example]', 'Preferences validated')->assertValue('#discount', '25')->assertValue('#budget', '45');
    $page->click('[data-slider-example] button:has-text("Toggle Readonly")')->assertAttribute('#budget-handle', 'aria-readonly', 'true')->keys('#budget-handle', 'End')->assertValue('#budget', '45');
    $page->click('[data-slider-example] button:has-text("Load Value")')->assertValue('#discount', '25')->assertValue('#budget', '80')->assertValue('#budget-upper', '220');
    $page->click('[data-slider-example] button:has-text("Reset Sample")')->assertValue('#discount', '10')->assertValue('#budget', '40');
    $page->script('Livewire.find(document.querySelector("[data-slider-example]").getAttribute("wire:id")).$set("visible", false)');
    $page->assertMissing('#discount-handle');
    $page->script('Livewire.find(document.querySelector("[data-slider-example]").getAttribute("wire:id")).$set("visible", true)');
    $page->assertValue('#discount', '10');
    expect($page->script('document.querySelectorAll("[role=slider]").length'))->toBe(6);
    foreach (['discount', 'budget', 'budget-upper'] as $id) {
        $page->assertMissing('#' . $id);
    }
    $page->script('document.querySelectorAll("[data-slider-example] [data-slider-source]").forEach(source => { source.removeAttribute("hidden"); source.removeAttribute("data-slider-enhanced"); })');
    foreach (['discount', 'budget', 'budget-upper'] as $id) {
        $page->assertMissing('#' . $id);
    }

    $page->assertNoJavaScriptErrors();
});

it('handles Alpine updates rejects invalid pairs and survives navigation in mobile themes', function (): void {
    $page = visit('/development/slider-bindings')->assertValue('#alpine-slider', '20');
    $page->keys('#alpine-range-upper-handle', 'ArrowRight')->assertSeeIn('[data-alpine-values]', '[20,[20,85]]');
    $page->click('Set invalid range')->assertSee('Choose ordered values')->assertValue('#alpine-range', '20')->assertValue('#alpine-range-upper', '85');
    expect($page->script('document.querySelector("#alpine-range").validity.valid'))->toBeFalse();
    $page->click('Load Alpine value')->assertValue('#alpine-slider', '60')->assertValue('#alpine-range', '40')->assertValue('#alpine-range-upper', '90');
    expect($page->script('document.querySelector("#alpine-range").validity.valid'))->toBeTrue();
    $page->click('Toggle Alpine readonly')->assertAttribute('#alpine-slider-handle', 'aria-readonly', 'true')->keys('#alpine-slider-handle', 'End')->assertValue('#alpine-slider', '60');
    $page->click('Form Control')->click('Slider')->assertPresent('#discount-handle')->click('Input')->assertMissing('#discount-handle')->click('Slider')->assertPresent('#discount-handle');
    $page->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->screenshot(fullPage: true, filename: $dark ? 'slider-mobile-dark' : 'slider-mobile-light');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
    }
    $page->assertNoJavaScriptErrors();
});

it('moves sliders by pointer and submits Blade selections', function (): void {
    $page = visit('/blade-components/slider')->assertPresent('#blade-discount-handle');
    $page->click('[data-sir-slider]:has(#blade-discount) .sir-slider-track')->assertValue('#blade-discount', '25');
    $page->drag('#blade-budget-handle', '#blade-budget-upper-handle')->assertValue('#blade-budget', '160');
    $page->click('[data-slider-blade] button:has-text("Submit / Validate")')->assertSeeIn('[data-slider-blade]', 'Preferences validated')->assertValue('#blade-discount', '25')->assertValue('#blade-budget', '160');
    $page->click('[data-slider-blade] button:has-text("Load Value")')->assertValue('#blade-budget', '80');
    $page->click('[data-slider-blade] button:has-text("Reset Sample")')->assertValue('#blade-budget', '40')->assertNoJavaScriptErrors();
});

it('responds to touch on the common track', function (): void {
    $page = visit('/development/slider')->on()->mobile()->assertPresent('#native-slider-handle');
    $page->script('document.querySelector("[data-sir-slider]").addEventListener("pointerdown", event => { window.sliderPointerType = event.pointerType; }, {once:true})');
    $page->page()->locator('[data-sir-slider]:has(#native-slider) .sir-slider-track')->tap();
    $page->assertValue('#native-slider', '0.6');
    expect($page->script('window.sliderPointerType'))->toBe('touch');
    $page->assertNoJavaScriptErrors();
});
