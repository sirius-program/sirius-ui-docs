<?php

declare(strict_types=1);

it('updates helper and error associations without changing the field identity', function (): void {
    $page = visit('/development/fields')->assertPresent('[data-example-email]');
    $id = $page->script('document.querySelector("[data-example-email]").id');

    $page->click('[data-live-field-example] button:has-text("Submit / Validate")')
        ->assertSee('The email field is required.')
        ->assertAttribute('[data-example-email]', 'aria-invalid', 'true')
        ->assertAttribute('[data-example-email]', 'aria-describedby', $id . '-helper ' . $id . '-error')
        ->assertSee('Your address stays in this example only.')
        ->type('[data-example-email]', 'reader@example.com')
        ->click('[data-live-field-example] button:has-text("Submit / Validate")')
        ->assertSee('Validation passed. Nothing was stored.')
        ->assertAttribute('[data-example-email]', 'aria-invalid', 'false')
        ->assertAttribute('[data-example-email]', 'aria-describedby', $id . '-helper')
        ->click('Toggle Readonly')
        ->assertAttribute('[data-example-email]', 'readonly', 'readonly')
        ->click('[data-live-field-example] button:has-text("Reset Sample")')
        ->assertValue('[data-example-email]', '')
        ->assertAttribute('[data-example-email]', 'id', $id)
        ->assertAttributeMissing('[data-example-email]', 'readonly')
        ->assertNoJavaScriptErrors();
});

it('navigates to label examples and focuses their associated native controls', function (): void {
    $page = visit('/development/fields')->click('Label')->assertPresent('[data-docs-props]');
    $page->click('label[for="label-required"]');

    expect($page->script('document.activeElement.id'))->toBe('label-required');
    $page->click('[data-docs-toc] a[href="#shared-field-contract"]')
        ->assertSee('Shared field contract')
        ->assertPresent('#shared-field-contract')
        ->assertNoJavaScriptErrors();
});

it('retains ordinary Blade errors and old input after a real form redirect', function (): void {
    visit('/development/fields')
        ->type('#plain-email', 'invalid')
        ->click('[data-blade-field-example] button:has-text("Submit / Validate")')
        ->assertPresent('#plain-email-error')
        ->assertValue('#plain-email', 'invalid')
        ->assertAttribute('#plain-email', 'aria-describedby', 'plain-email-helper plain-email-error')
        ->type('#plain-email', 'reader@example.com')
        ->click('[data-blade-field-example] button:has-text("Submit / Validate")')
        ->assertSee('Validation passed. Nothing was stored.')
        ->assertMissing('#plain-email-error')
        ->assertNoJavaScriptErrors();
});

it('keeps shared fields inside a narrow viewport in light and dark themes', function (): void {
    $page = visit('/development/fields')->resize(390, 844)->assertPresent('#plain-email');
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        expect($page->script('Array.from(document.querySelectorAll(".sir-field")).every(field => field.getBoundingClientRect().right <= innerWidth)'))->toBeTrue();
        $page->screenshot(filename: $dark ? 'phase-1-mobile-dark' : 'phase-1-mobile-light');
    }
    $page->assertNoJavaScriptErrors();
});
