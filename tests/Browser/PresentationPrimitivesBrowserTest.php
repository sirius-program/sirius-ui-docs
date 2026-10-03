<?php

declare(strict_types=1);

it('preserves avatar dimensions during image failure and recovery and after navigation', function (): void {
    $page = visit('/blade-components/avatar')->assertPresent('#workspace-avatar[data-image-ready="true"]')
        ->assertSeeIn('#nadia-avatar [data-avatar-fallback]', 'NP');
    $page->script('window.avatarBounds = () => { const r = document.querySelector("#workspace-avatar").getBoundingClientRect(); return [r.width, r.height]; }; window.initialAvatarBounds = window.avatarBounds(); document.querySelector("#workspace-avatar img").src = "/sample/sample.pdf"');
    $page->assertPresent('#workspace-avatar[data-image-ready="false"]')->assertSeeIn('#workspace-avatar [data-avatar-fallback]', 'LS');
    expect($page->script('window.avatarBounds()'))->toBe($page->script('window.initialAvatarBounds'));
    $page->script('document.querySelector("#workspace-avatar img").src = "/sample/sample.jpg"');
    $page->assertPresent('#workspace-avatar[data-image-ready="true"]')->assertMissing('#workspace-avatar [data-avatar-fallback]');
    expect($page->script('window.avatarBounds()'))->toBe([48, 48]);
    $page->script('Livewire.navigate("/blade-components/skeleton")');
    $page->assertPresent('#skeleton-demo');
    $page->script('Livewire.navigate("/blade-components/avatar")');
    $page->assertPresent('#workspace-avatar[data-image-ready="true"]')->assertNoJavaScriptErrors();
});

it('recovers avatars after Livewire source updates unrelated morphs removal and remounting', function (): void {
    visit('/development/avatar')->assertSeeIn('#livewire-avatar [data-avatar-fallback]', 'NP')
        ->click('Load image')->assertPresent('#livewire-avatar[data-image-ready="true"]')
        ->click('Rename member')->assertAttribute('#livewire-avatar', 'aria-label', 'Alex Morgan')
        ->assertPresent('#livewire-avatar[data-image-ready="true"]')->assertMissing('#livewire-avatar [data-avatar-fallback]')
        ->click('Use invalid image')->assertPresent('#livewire-avatar[data-image-ready="false"]')
        ->assertSeeIn('#livewire-avatar [data-avatar-fallback]', 'AM')
        ->click('Load image')->assertPresent('#livewire-avatar[data-image-ready="true"]')
        ->click('Toggle visibility')->assertNotPresent('#livewire-avatar')
        ->click('Toggle visibility')->assertPresent('#livewire-avatar[data-image-ready="true"]')->assertNoJavaScriptErrors();
});

it('sizes separators and skeletons and keeps all primitive demos within mobile layouts in both themes', function (string $component): void {
    $page = visit('/blade-components/' . $component, ['reducedMotion' => 'no-preference'])->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true);
        $page->screenshot(fullPage: true, filename: $component . '-mobile-' . ($dark ? 'dark' : 'light'));
    }
    if ($component === 'separator') {
        $page->assertScript('document.querySelector("#billing-separator").getBoundingClientRect().height', 1);
        $page->assertScript('document.querySelector("#navigation-separator").getBoundingClientRect().width', 1);
        $page->assertScript('document.querySelector("#navigation-separator").getBoundingClientRect().height > 0', true);
        $page->assertAttribute('#navigation-separator', 'aria-hidden', 'true');
    }
    if ($component === 'skeleton') {
        $page->assertAttribute('#skeleton-demo [aria-busy]', 'aria-busy', 'true')
            ->assertAttribute('#skeleton-demo .sir-skeleton--circle', 'aria-hidden', 'true');
        $page->assertScript('getComputedStyle(document.querySelector("#skeleton-demo .sir-skeleton")).animationName', 'sir-skeleton-fade');
        $page->assertScript('document.querySelector("#skeleton-demo .sir-skeleton--circle").getBoundingClientRect().width', 48);
    }
    $page->assertNoJavaScriptErrors();
})->with(['avatar', 'separator', 'skeleton']);

it('disables skeleton fades for reduced motion while keeping the loading placeholder visible', function (): void {
    $page = visit('/blade-components/skeleton', ['reducedMotion' => 'reduce']);
    $page->assertScript('getComputedStyle(document.querySelector("#skeleton-demo .sir-skeleton")).animationName', 'none')
        ->assertPresent('#skeleton-demo .sir-skeleton')->assertNoJavaScriptErrors();
});
