<?php

declare(strict_types=1);

it('keeps native date values canonical and rejects invalid days and time bounds', function (): void {
    $page = visit('/development/datetime-picker')->assertValue('#native-date', '29/02/2028')->assertValue('#native-time', '09:30')->assertValue('#native-datetime', '31/12/2028 14:30:45');
    expect($page->script('typeof window.Livewire'))->toBe('undefined');
    expect($page->script('Array.from(new FormData(document.querySelector("form")).entries())'))->toBe([
        ['date', '2028-02-29'], ['time', '09:30'], ['datetime', '2028-12-31 14:30:45'], ['locked', '2028-02-29'], ['external', '2028-01-01'],
    ]);
    foreach (['30/02/2028', '29/02/2027', '01/03/2028', '01/01/2029'] as $value) {
        $page->type('#native-date', $value)->click('Datetime picker integration')->assertValue('#native-date', $value);
        expect($page->script('document.querySelector("#native-date").validity.valid'))->toBeFalse();
    }
    $page->type('#native-time', '07:59')->click('Datetime picker integration');
    expect($page->script('document.querySelector("#native-time").validity.valid'))->toBeFalse();
    $page->type('#external-date', '31/12/2028')->click('Native reset')->assertValue('#native-date', '29/02/2028')->assertValue('#native-time', '09:30')->assertValue('#external-date', '01/01/2028');
    $page->assertDisabled('#native-disabled')->assertAttribute('#native-locked', 'readonly', 'readonly')->assertNoJavaScriptErrors();
});

it('synchronizes date values through Livewire typing server loads validation and readonly changes', function (): void {
    $page = visit('/blade-components/datetime-picker')->click('[data-date-example] button:has-text("Load Value")')
        ->assertValue('[data-date-departure]', '29/02/2028')->assertValue('[data-date-reminder]', '09:30')->assertValue('[data-date-appointment]', '31 Desember 2028 14:30:45');
    $page->type('[data-date-departure]', '')->typeSlowly('[data-date-departure]', '28/02/2028', 200)->waitForEvent('networkidle')->assertValue('[data-date-departure]', '28/02/2028');
    $page->click('[data-date-example] button:has-text("Submit / Validate")')->assertSee('Travel dates validated. Nothing was stored.');
    expect($page->script('Livewire.find(document.querySelector("[data-date-example]").getAttribute("wire:id")).$get("departure")'))->toBe('2028-02-28');
    $page->click('[data-date-example] button:has-text("Toggle Readonly")')->assertAttribute('[data-date-departure]', 'readonly', 'readonly')
        ->click('[data-date-example] button:has-text("Load Value")')->assertValue('[data-date-departure]', '29/02/2028')
        ->click('[data-date-example] button:has-text("Reset Sample")')->assertValue('[data-date-departure]', '')
        ->click('[data-date-example] button:has-text("Submit / Validate")')->assertSee('The departure field is required.')->assertNoJavaScriptErrors();
});

it('submits native date demos and exposes localized keyboard calendar selection', function (): void {
    $page = visit('/blade-components/datetime-picker')->click('[data-blade-datetime-picker] button[value="load"]')->assertValue('#blade-date-departure', '29/02/2028');
    $page->click('#blade-date-departure')->assertPresent('.flatpickr-calendar.open');
    $page->click('.flatpickr-calendar.open .flatpickr-day[aria-label="Februari 28, 2028"]');
    $page->assertValue('#blade-date-departure', '28/02/2028')->click('[data-blade-datetime-picker] button[value="validate"]')->assertSee('Travel dates validated. Nothing was stored.');
    $page->type('#blade-date-departure', '30/02/2028')->click('[data-blade-datetime-picker] button[value="validate"]')->assertSee('The departure field must match the format Y-m-d.')->assertValue('#blade-date-departure', '30/02/2028')->assertNoJavaScriptErrors();
});

it('cleans up remounted datetime pickers and synchronizes Alpine and independent Livewire instances', function (): void {
    $page = visit('/development/date-bindings')->assertValue('#alpine-date', '29/02/2028');
    $page->type('#alpine-date', '28/02/2028')->assertSeeIn('[data-alpine-date]', '2028-02-28')
        ->click('Load Alpine date')->assertValue('#alpine-date', '31/12/2028');
    $page->click('[data-date-instance="first"] button:has-text("Load Value")')
        ->assertValue('[data-date-instance="first"] [data-date-departure]', '29/02/2028')
        ->assertValue('[data-date-instance="second"] [data-date-departure]', '');
    $wire = 'Livewire.find(document.querySelector("[data-date-instance=first] [data-date-example]").getAttribute("wire:id"))';
    $page->script($wire . '.$set("disabled", true)');
    $page->assertDisabled('[data-date-instance="first"] [data-date-departure]');
    $page->script($wire . '.$set("showControls", false)');
    $page->assertMissing('[data-date-instance="first"] [data-date-departure]');
    expect($page->script('document.querySelectorAll(".sir-date-calendar").length'))->toBe(4);
    $page->script($wire . '.$set("showControls", true)');
    $page->assertPresent('[data-date-instance="first"] [data-date-departure]');
    $page->click('[data-date-instance="first"] button:has-text("Reset Sample")')->assertValue('[data-date-instance="first"] [data-date-departure]', '');
    expect($page->script('document.querySelectorAll(".sir-date-calendar").length'))->toBe(7);
    $page->click('Currency')->assertPresent('[data-currency-budget]')->assertMissing('[data-date-example]');
    expect($page->script('document.querySelectorAll(".sir-date-calendar").length'))->toBe(0);
    $page->click('Datetime Picker')->assertPresent('[data-date-departure]');
    expect($page->script('document.querySelectorAll(".sir-date-calendar").length'))->toBe(6);
    $page->assertNoJavaScriptErrors();
});

it('supports keyboard date selection clearing time controls and responsive themes', function (): void {
    $page = visit('/development/datetime-picker')->keys('#native-date', 'ArrowDown')->assertPresent('.flatpickr-calendar.open');
    $page->keys('.flatpickr-calendar.open .selected', 'ArrowLeft')->keys('.flatpickr-calendar.open .flatpickr-day:focus', 'Enter')->assertValue('#native-date', '28/02/2028');
    $page->click('[data-sir-datetime-picker]:has(#native-date) [data-sir-date-clear]')->assertValue('#native-date', '');
    expect($page->script('new FormData(document.querySelector("form")).get("date")'))->toBe('');
    $page->click('#native-time')->type('.flatpickr-calendar.open .flatpickr-hour', '10')->type('.flatpickr-calendar.open .flatpickr-minute', '45')
        ->keys('.flatpickr-calendar.open .flatpickr-minute', 'ArrowUp')->click('Datetime picker integration');
    $page->assertValue('#native-time', '10:50');
    expect($page->script('new FormData(document.querySelector("form")).get("time")'))->toBe('10:50');
    $page = visit('/blade-components/datetime-picker')->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->click('[data-date-departure]')->assertPresent('.flatpickr-calendar.open');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
        $page->screenshot(fullPage: true, filename: $dark ? 'datetime-picker-mobile-dark' : 'datetime-picker-mobile-light');
        $page->keys('[data-date-departure]', 'Escape');
    }
    $page->assertNoJavaScriptErrors();
});
