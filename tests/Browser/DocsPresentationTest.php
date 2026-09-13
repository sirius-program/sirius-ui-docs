<?php

declare(strict_types=1);

it('keeps generated control associations working through Livewire updates', function (): void {
    $page = visit('/development/basic-controls');
    $scope = '[data-auto-id-example]';
    $page->click($scope . ' button:has-text("Submit / Validate")')
        ->assertAttribute($scope . ' [data-basic-title]', 'aria-invalid', 'true');
    expect($page->script(<<<'JS_WRAP'
    Array.from(document.querySelectorAll('[data-auto-id-example] input')).every(input => {
        if (!/^[a-zA-Z0-9]{5}$/.test(input.id)) return false;
        const label = Array.from(document.querySelectorAll('[data-auto-id-example] label')).find(label => label.htmlFor === input.id);
        return !!label && (input.getAttribute('aria-describedby') || '').split(' ').filter(Boolean).every(id => document.getElementById(id));
    })
    JS_WRAP))->toBeTrue();
    $page->click($scope . ' button:has-text("Load Value")')->assertValue($scope . ' [data-basic-password]', 'Workspace-demo!42')
        ->click($scope . ' [data-sir-password-toggle]')->assertAttribute($scope . ' [data-basic-password]', 'type', 'text')
        ->click($scope . ' button:has-text("Reset Sample")')->assertValue($scope . ' [data-basic-password]', '')
        ->click($scope . ' [data-sir-password-toggle]')->assertAttribute($scope . ' [data-basic-password]', 'type', 'text')
        ->assertNoJavaScriptErrors();
});

it('loads validates and resets the paired native demo', function (string $kind, string $selector, bool $choice): void {
    $path = $kind === 'label' ? '/blade-components/label' : '/blade-components/' . match ($kind) {
        'password'                    => 'input',
        'checkbox', 'radio', 'switch' => 'choices',
        default                       => $kind,
    };
    $scope = '[data-blade-example="' . $kind . '"]';
    $page = visit($path)->click($scope . ' button[value="validate"]');
    $page->assertAttribute($selector, 'aria-invalid', 'true')
        ->click($scope . ' button[value="load"]')->assertAttribute($selector, 'aria-invalid', 'false');
    if ($choice) {
        $page->assertChecked($selector);
    } else {
        $page->assertValue($selector, match ($kind) {
            'input' => 'Website redesign', 'password' => 'Workspace-demo!42',
            'label' => 'reader@example.com', default => 'Prepare the homepage draft for the design review on Friday.',
        });
    }
    $page->click($scope . ' button[value="validate"]')->assertSeeIn($scope, 'Nothing was stored.')
        ->click($scope . ' button[value="reset"]')->assertAttribute($selector, 'aria-invalid', 'false');
    if ($choice) {
        $page->assertNotChecked($selector);
    } else {
        $page->assertValue($selector, '');
    }
    $page->assertMissing($scope . ' button:has-text("Toggle Readonly")')->assertNoJavaScriptErrors();
})->with([
    ['input', '#blade-input-title', false],
    ['password', '#blade-password-password', false],
    ['textarea', '#blade-textarea-notes', false],
    ['checkbox', '#blade-checkbox-agree', true],
    ['radio', '#blade-radio-plan-zero', true],
    ['switch', '#blade-switch-enabled', true],
    ['label', '#label-required', false],
]);

it('highlights and copies exact usage text after navigation and handles clipboard denial', function (): void {
    $page = visit('/blade-components/label')->assertPresent('[data-docs-code] .docs-token-tag');
    $source = $page->script('document.querySelector("[data-docs-code] code").textContent');
    $page->script('Object.defineProperty(navigator, "clipboard", {configurable: true, value: {writeText: async (text) => { window.copiedSample = text; }}})');
    $page->click('#label-usage [data-usage-example]:nth-of-type(1) [data-copy-code]')->assertSee('Copied');
    expect($page->script('window.copiedSample'))->toBe($source);
    expect($source)->toContain('<x-sirius::label', 'name="email"');

    $page->click('Textarea')->assertPresent('[data-docs-code] .docs-token-tag');
    $page->script('Object.defineProperty(navigator, "clipboard", {configurable: true, value: {writeText: async () => { throw new Error("Denied"); }}})');
    $page->click('[data-control-demo="textarea"] [data-copy-code]')->assertSee('Select & copy');
    expect($page->script('window.getSelection().toString()'))->toContain('<x-sirius::textarea');
    $page->assertNoJavaScriptErrors();
});

it('keeps paired controls consistent and tables and code within a mobile viewport', function (): void {
    $page = visit('/blade-components/choices')->resize(390, 844)->assertPresent('[data-docs-props] table');
    expect($page->script(<<<'JS_WRAP'
    Array.from(document.querySelectorAll('[data-control-demo]')).every(section => {
        const labels = mode => Array.from(section.querySelectorAll('[data-demo-mode="'+mode+'"] label')).map(label => label.textContent.trim());
        const live = section.querySelector('[data-demo-mode="livewire"]');
        const blade = section.querySelector('[data-demo-mode="blade"]');
        return JSON.stringify(labels('livewire')) === JSON.stringify(labels('blade'))
            && live.getBoundingClientRect().bottom <= blade.getBoundingClientRect().top;
    })
    JS_WRAP))->toBeTrue();
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
        $page->screenshot(fullPage: true, filename: $dark ? 'docs-choices-dark' : 'docs-choices-light');
    }
    $page->assertNoJavaScriptErrors();
});

it('navigates content sections and copies each checkbox scenario independently', function (): void {
    $page = visit('/blade-components/choices')->resize(1440, 1000)->assertPresent('[data-docs-toc]');
    expect($page->script(<<<'JS_WRAP'
    Array.from(document.querySelectorAll('[data-docs-toc] a')).every(link => document.querySelectorAll(link.hash).length === 1)
    JS_WRAP))->toBeTrue();
    expect($page->script('document.querySelector("[data-docs-toc]").getBoundingClientRect().left >= document.querySelector("article").getBoundingClientRect().right'))->toBeTrue();
    $page->screenshot(filename: 'docs-choices-desktop');
    $page->click('[data-docs-toc] a[href="#checkbox-usage"]');
    expect($page->script('location.hash'))->toBe('#checkbox-usage');
    $page->script('Object.defineProperty(navigator, "clipboard", {configurable: true, value: {writeText: async (text) => { window.copiedSample = text; }}})');
    foreach (['workspace terms', 'Member access', 'All project notifications'] as $index => $label) {
        $selector = '#checkbox-usage [data-usage-example]:nth-of-type(' . ($index + 1) . ')';
        $page->click($selector . ' [data-copy-code]')->assertSeeIn($selector . ' [data-copy-code]', 'Copied');
        expect($page->script('window.copiedSample'))->toContain($label)->not->toContain('wire:model');
    }
    $page->click('[data-docs-toc] a[href="#radio-attributes"]');
    expect($page->script('location.hash'))->toBe('#radio-attributes');
    $page->click('Back to top');
    expect($page->script('location.hash'))->toBe('#docs-top');
    $page->resize(390, 844)->click('[data-docs-toc] a[href="#assets-and-interaction"]');
    expect($page->script('location.hash'))->toBe('#assets-and-interaction');
    $page->assertNoJavaScriptErrors();
});
