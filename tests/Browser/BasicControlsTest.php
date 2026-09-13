<?php

declare(strict_types=1);

it('shows one required marker and error per choice group after Livewire validation', function (string $kind, string $option): void {
    $page = visit('/blade-components/choices');
    $scope = '[data-control-demo="' . $kind . '"]';
    $page->click($scope . ' [data-basic-example] button:has-text("Submit / Validate")')->assertAttribute($option, 'aria-invalid', 'true');
    $group = 'document.querySelector(' . json_encode($option) . ').closest("fieldset")';
    expect($page->script($group . '.querySelectorAll(".sir-required").length'))->toBe(1);
    expect($page->script($group . '.querySelectorAll("[id$=\"-error\"]").length'))->toBe(1);
    expect($page->script($group . '.querySelectorAll("[id$=\"-error\"] li").length'))->toBe(1);
    expect($page->script('document.querySelector(' . json_encode($option) . ').getAttribute("aria-describedby").includes(' . $group . '.id + "-error")'))->toBeTrue();
    $page->click($scope . ' [data-basic-example] button:has-text("Load Value")')->assertAttribute($option, 'aria-invalid', 'false');
    expect($page->script($group . '.querySelectorAll("[id$=\"-error\"]").length'))->toBe(0);
    $page->assertNoJavaScriptErrors();
})->with([
    ['checkbox', '[data-basic-role-zero]'],
    ['radio', '[data-basic-plan-zero]'],
]);

it('preserves password selection and independent visibility through server updates and remounts', function (): void {
    $page = visit('/development/basic-controls')->assertPresent('[data-basic-password]');
    $first = 'main > [data-basic-example]:first-of-type';
    $input = $first . ' [data-basic-password]';
    $toggle = $first . ' [data-sir-password-toggle]';
    $page->click($first . ' button:has-text("Load Value")')->assertValue($input, 'Workspace-demo!42')->assertAttributeMissing($toggle, 'hidden')
        ->assertAttribute($toggle, 'title', 'Show')->assertAttribute($toggle, 'aria-label', 'Show');
    $page->type($input, 'typed-secret');
    $page->script('document.querySelector("[data-basic-password]").setSelectionRange(2, 5)');
    $page->click($toggle)->assertAttribute($input, 'type', 'text')->assertValue($input, 'typed-secret')
        ->assertAttribute($toggle, 'title', 'Hide')->assertAttribute($toggle, 'aria-label', 'Hide');
    expect($page->script('document.querySelector("[data-basic-password]").selectionStart'))->toBe(2);
    expect($page->script('document.querySelector("[data-basic-password]").selectionEnd'))->toBe(5);
    expect($page->script('document.querySelectorAll("[data-basic-password]")[1].type'))->toBe('password');
    $page->click($first . ' button:has-text("Load Value")')->assertValue($input, 'Workspace-demo!42')->assertAttribute($input, 'type', 'text')->assertAttribute($toggle, 'title', 'Hide')
        ->click($first . ' button:has-text("Reset Sample")')->assertValue($input, '');
    $page->script('Livewire.find(document.querySelector("[data-basic-example]").getAttribute("wire:id")).$set("showControls", false)');
    $page->assertMissing($input);
    $page->script('Livewire.find(document.querySelector("[data-basic-example]").getAttribute("wire:id")).$set("showControls", true)');
    $page->assertPresent($input)->assertAttribute($input, 'type', 'password')->assertAttribute($toggle, 'title', 'Show')
        ->click($toggle)->assertAttribute($input, 'type', 'text')->assertNoJavaScriptErrors();
});

it('binds checkbox booleans and arrays including zero and protects readonly state', function (): void {
    $page = visit('/blade-components/checkbox')->assertPresent('[data-basic-agree]');
    expect($page->script('document.querySelector("[data-basic-mixed]").indeterminate'))->toBeTrue();
    $page->click('[data-basic-agree]')->assertChecked('[data-basic-agree]')
        ->click('[data-basic-role-zero]')->assertChecked('[data-basic-role-zero]')
        ->click('[data-basic-role-editor]')->assertChecked('[data-basic-role-editor]')
        ->click('[data-control-demo="checkbox"] [data-basic-example] button:has-text("Toggle Readonly")')->assertSeeIn('[data-control-demo="checkbox"] [data-basic-lock-status]', 'Readonly: on')
        ->click('[data-basic-agree]')->assertChecked('[data-basic-agree]')
        ->click('[data-basic-role-zero]')->assertChecked('[data-basic-role-zero]')
        ->click('[data-control-demo="checkbox"] [data-basic-example] button:has-text("Load Value")')->assertNotChecked('[data-basic-role-editor]');
    expect($page->script('document.querySelector("[data-basic-mixed]").indeterminate'))->toBeFalse();
    $page->click('[data-control-demo="checkbox"] [data-basic-example] button:has-text("Reset Sample")')->assertNotChecked('[data-basic-agree]')->assertNotChecked('[data-basic-role-zero]');
    expect($page->script('document.querySelector("[data-basic-mixed]").indeterminate'))->toBeTrue();
    $page->click('[data-basic-mixed]');
    expect($page->script('document.querySelector("[data-basic-mixed]").indeterminate'))->toBeFalse();
    $page->assertNoJavaScriptErrors();
});

it('updates radio and switch states from the server while readonly blocks user changes', function (): void {
    $radio = visit('/blade-components/radio')->assertNotChecked('[data-basic-plan-zero]')->assertNotChecked('[data-basic-plan-pro]');
    $radio->click('[data-basic-plan-pro]')->assertChecked('[data-basic-plan-pro]')
        ->click('[data-control-demo="radio"] [data-basic-example] button:has-text("Toggle Readonly")')->assertSeeIn('[data-control-demo="radio"] [data-basic-lock-status]', 'Readonly: on')
        ->click('[data-basic-plan-zero]')->assertNotChecked('[data-basic-plan-zero]')->assertChecked('[data-basic-plan-pro]')
        ->click('[data-control-demo="radio"] [data-basic-example] button:has-text("Load Value")')->assertChecked('[data-basic-plan-zero]')->assertNotChecked('[data-basic-plan-pro]')
        ->click('[data-control-demo="radio"] [data-basic-example] button:has-text("Reset Sample")')->assertNotChecked('[data-basic-plan-zero]')->assertNoJavaScriptErrors();

    $switch = visit('/blade-components/switch')->click('[data-basic-enabled]')->assertChecked('[data-basic-enabled]')
        ->click('[data-control-demo="switch"] [data-basic-example] button:has-text("Toggle Readonly")')->assertSeeIn('[data-control-demo="switch"] [data-basic-lock-status]', 'Readonly: on')
        ->click('[data-basic-enabled]')->assertChecked('[data-basic-enabled]')
        ->click('[data-control-demo="switch"] [data-basic-example] button:has-text("Reset Sample")')->assertNotChecked('[data-basic-enabled]')->assertNoJavaScriptErrors();
});

it('submits canonical native values and resets Blade controls without hidden duplicate inputs', function (): void {
    $page = visit('/development/basic-controls')->assertPresent('#plain-title');
    $page->type('#plain-title', 'Changed title')->click('#plain-editor')->click('#plain-pro')
        ->click('[data-sir-password-toggle="plain-password"]')->assertAttribute('#plain-password', 'type', 'text')
        ->click('Reset Blade sample')->assertValue('#plain-title', 'Initial title')->assertNotChecked('#plain-editor')
        ->assertChecked('#plain-free')->assertAttribute('#plain-password', 'type', 'password');
    expect($page->script('document.querySelector("#plain-mixed").indeterminate'))->toBeTrue();
    $page->click('#plain-enabled')->assertChecked('#plain-enabled')->click('#plain-editor')->click('#plain-pro')
        ->assertValue('#plain-title', 'Initial title')->assertValue('#plain-quantity', '0')
        ->assertChecked('#plain-pro')->assertChecked('#plain-editor');
    expect($page->script('new FormData(document.querySelector("#plain-basic-form")).has("ignored")'))->toBeFalse();
    expect($page->script('new FormData(document.querySelector("#plain-basic-form")).getAll("roles[]")'))->toBe(['0', 'editor']);
    $page->click('Submit Blade sample')->assertSee('Blade sample received. Nothing was stored.')->assertNoJavaScriptErrors();
});

it('updates text number and textarea values and errors after Livewire reset', function (): void {
    $page = visit('/blade-components/input')->click('[data-control-demo="input"] [data-basic-example] button:has-text("Submit / Validate")')->assertAttribute('[data-basic-title]', 'aria-invalid', 'true')
        ->type('[data-basic-title]', 'My project')->type('[data-basic-quantity]', '5')->click('[data-control-demo="input"] [data-basic-example] button:has-text("Submit / Validate")')
        ->assertSee('Sample validated. Nothing was stored.')->assertAttribute('[data-basic-title]', 'aria-invalid', 'false')
        ->click('[data-control-demo="input"] [data-basic-example] button:has-text("Load Value")')->assertValue('[data-basic-title]', 'Website redesign')->assertValue('[data-basic-quantity]', '12')
        ->click('[data-control-demo="input"] [data-basic-example] button:has-text("Reset Sample")')->assertValue('[data-basic-title]', '')->assertValue('[data-basic-quantity]', '0')->assertNoJavaScriptErrors();
    $page->click('Textarea')->type('[data-basic-notes]', 'Typed notes')->click('[data-basic-example] button:has-text("Submit / Validate")')
        ->assertSee('Sample validated. Nothing was stored.')->click('[data-basic-example] button:has-text("Load Value")')->assertValue('[data-basic-notes]', 'Prepare the homepage draft for the design review on Friday.')
        ->click('[data-basic-example] button:has-text("Reset Sample")')->assertValue('[data-basic-notes]', '')->assertNoJavaScriptErrors();
});

it('supports native keyboard and label interactions with readonly choices', function (): void {
    $checkbox = visit('/blade-components/checkbox')->keys('[data-basic-agree]', 'Space')->assertChecked('[data-basic-agree]')
        ->click('[data-control-demo="checkbox"] [data-basic-example] button:has-text("Toggle Readonly")')->assertSeeIn('[data-control-demo="checkbox"] [data-basic-lock-status]', 'Readonly: on')
        ->keys('[data-basic-agree]', 'Space')->assertChecked('[data-basic-agree]')->assertNoJavaScriptErrors();

    $radio = visit('/blade-components/radio')->click('[data-basic-plan-zero]')->keys('[data-basic-plan-zero]', 'ArrowRight')
        ->assertChecked('[data-basic-plan-pro]')
        ->click('[data-control-demo="radio"] [data-basic-example] button:has-text("Toggle Readonly")')->assertSeeIn('[data-control-demo="radio"] [data-basic-lock-status]', 'Readonly: on')
        ->keys('[data-basic-plan-pro]', 'ArrowLeft')->assertChecked('[data-basic-plan-pro]')->assertNoJavaScriptErrors();

    $switch = visit('/blade-components/switch')->click('[data-basic-example] label:has-text("Enable security alerts")')->assertChecked('[data-basic-enabled]')
        ->keys('[data-basic-enabled]', 'Space')->assertNotChecked('[data-basic-enabled]')->assertNoJavaScriptErrors();
});

it('runs without Livewire or Alpine and retains native submission focus and resets', function (): void {
    $page = visit('/development/standalone-controls')->assertPresent('#standalone-password');
    expect($page->script('typeof window.Livewire'))->toBe('undefined');
    expect($page->script('typeof window.Alpine'))->toBe('undefined');
    $page->click('[data-sir-password-toggle]')->assertAttribute('#standalone-password', 'type', 'text')
        ->click('label[for="standalone-check"]')->assertChecked('#standalone-check')
        ->keys('#standalone-check', 'Space')->assertChecked('#standalone-check')
        ->click('#standalone-radio-b')->assertNotChecked('#standalone-radio-b')
        ->keys('#standalone-radio-a', 'ArrowRight')->assertChecked('#standalone-radio-a')
        ->click('#independent-radio')->assertChecked('#independent-radio')->assertChecked('#standalone-radio-a')
        ->click('#standalone-switch')->assertChecked('#standalone-switch');
    expect($page->script('document.activeElement.id'))->toBe('standalone-switch');
    expect($page->script('Array.from(new FormData(document.querySelector("#standalone-form")).entries())'))->toBe([
        ['check', 'on'], ['plan', 'a'], ['other-plan', 'other'], ['switch', 'on'],
    ]);
    foreach (['check', 'radio', 'switch'] as $kind) {
        $page->assertDisabled('#standalone-disabled-' . $kind)->assertNotChecked('#standalone-disabled-' . $kind);
    }
    $page->click('#standalone-mixed')->click('Reset standalone')->assertAttribute('#standalone-password', 'type', 'password');
    expect($page->script('document.querySelector("#standalone-mixed").indeterminate'))->toBeTrue();
    $page->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
        $page->screenshot(filename: $dark ? 'phase-2-mobile-dark' : 'phase-2-mobile-light');
    }
    $page->assertNoJavaScriptErrors();
});
