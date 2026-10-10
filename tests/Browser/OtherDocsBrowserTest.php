<?php

declare(strict_types=1);

it('matches the documented Tailwind palette in both themes', function (): void {
    $page = visit('/other/colors');
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript(<<<'JS'
        (() => {
            const dark = document.documentElement.classList.contains('dark');
            const [bg, text, border] = dark ? [950, 200, 700] : [100, 900, 300];
            const probe = document.createElement('span'); document.body.append(probe);
            const families = {primary: 'sky', secondary: 'indigo', success: 'emerald', danger: 'red', warning: 'amber'};
            const result = Object.entries(families).every(([variant, family]) => {
                probe.style.cssText = `background:var(--color-${family}-${bg});color:var(--color-${family}-${text});border:1px solid var(--color-${family}-${border})`;
                const expected = getComputedStyle(probe);
                const actual = getComputedStyle(document.querySelector(`[data-color-variants] .sir-tone--${variant}`));
                return actual.backgroundColor === expected.backgroundColor && actual.color === expected.color && actual.borderTopColor === expected.borderTopColor;
            });
            probe.style.cssText = 'background:color-mix(in oklch, var(--sir-color-surface), var(--sir-color-border) 25%);color:var(--sir-color-text);border:1px solid var(--sir-color-border)';
            const expected = getComputedStyle(probe);
            const info = getComputedStyle(document.querySelector('[data-color-variants] .sir-tone--info'));
            const infoMatches = info.backgroundColor === expected.backgroundColor && info.color === expected.color && info.borderTopColor === expected.borderTopColor;
            probe.remove(); return result && infoMatches;
        })()
        JS, true);
    }
    $page->assertNoJavaScriptErrors();
});

it('scopes presentation and widget overrides independently without changing defaults', function (): void {
    $page = visit('/other/colors')->assertChecked('#brand-color-switch')->assertChecked('#default-color-switch');
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript(<<<'JS'
        (() => {
            const dark = document.documentElement.classList.contains('dark');
            const probe = document.createElement('span'); document.body.append(probe);
            probe.style.backgroundColor = `var(--color-cyan-${dark ? 950 : 100})`;
            const brand = getComputedStyle(document.querySelector('[data-brand-color-example] .sir-badge')).backgroundColor;
            const ordinary = getComputedStyle(document.querySelector('[data-default-color-example] .sir-badge')).backgroundColor;
            const presentationMatches = brand === getComputedStyle(probe).backgroundColor && brand !== ordinary;
            probe.style.backgroundColor = `var(--color-cyan-${dark ? 400 : 600})`;
            const widget = getComputedStyle(document.querySelector('#brand-color-switch')).backgroundColor;
            const defaultWidget = getComputedStyle(document.querySelector('#default-color-switch')).backgroundColor;
            const widgetMatches = widget === getComputedStyle(probe).backgroundColor && widget !== defaultWidget;
            probe.remove(); return presentationMatches && widgetMatches;
        })()
        JS, true);
    }
    $page->keys('#brand-color-switch', 'Space')->assertNotChecked('#brand-color-switch')->assertChecked('#default-color-switch')->assertNoJavaScriptErrors();
});

it('inherits scrollbar styling into nested panels and supports native keyboard scrolling', function (): void {
    $page = visit('/other/customized-scrollbar')->resize(390, 844);
    $page->script('document.documentElement.classList.remove("sir-scrollbar")');
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript(<<<'JS'
        (() => {
            const vertical = document.querySelector('[data-scrollbar-vertical]');
            const horizontal = document.querySelector('[data-scrollbar-horizontal]');
            const custom = document.querySelector('[data-scrollbar-custom]');
            const inherited = [vertical, horizontal].every(panel => getComputedStyle(panel, '::-webkit-scrollbar').width === '8px');
            const dark = document.documentElement.classList.contains('dark');
            const probe = document.createElement('span'); document.body.append(probe);
            probe.style.backgroundColor = `var(--color-cyan-${dark ? 500 : 600})`;
            const colored = getComputedStyle(custom, '::-webkit-scrollbar-thumb').backgroundColor === getComputedStyle(probe).backgroundColor;
            probe.remove(); return inherited && colored && getComputedStyle(custom, '::-webkit-scrollbar').width === '12px'
                && vertical.scrollHeight > vertical.clientHeight && horizontal.scrollWidth > horizontal.clientWidth;
        })()
        JS, true);
    }
    $page->keys('[data-scrollbar-vertical]', 'End')->assertScript('document.querySelector("[data-scrollbar-vertical]").scrollTop > 0', true)
        ->keys('[data-scrollbar-horizontal]', 'ArrowRight')->assertScript('document.querySelector("[data-scrollbar-horizontal]").scrollLeft > 0', true)
        ->assertNoJavaScriptErrors();
});

it('leaves scrollbar styling to the browser in forced colors mode', function (): void {
    visit('/other/customized-scrollbar', ['forcedColors' => 'active'])
        ->assertScript('matchMedia("(forced-colors: active)").matches', true)
        ->assertScript('getComputedStyle(document.querySelector("[data-scrollbar-custom]")).scrollbarColor', 'auto')
        ->assertScript('getComputedStyle(document.querySelector("[data-scrollbar-custom]")).scrollbarWidth', 'auto')
        ->assertScript('getComputedStyle(document.querySelector("[data-scrollbar-custom]"), "::-webkit-scrollbar").width', 'auto')
        ->keys('[data-scrollbar-custom]', 'End')->assertScript('document.querySelector("[data-scrollbar-custom]").scrollTop > 0', true)
        ->assertNoJavaScriptErrors();
});

it('copies the exact applied override CSS and navigates to the other guide', function (): void {
    $page = visit('/other/colors')->resize(1440, 1000);
    $page->script('Object.defineProperty(navigator, "clipboard", {configurable:true, value:{writeText:async text => { window.copiedOverride = text; }}})');
    $page->click('#color-overrides > [data-docs-code] [data-copy-code]')->assertSeeIn('#color-overrides > [data-docs-code] [data-copy-code]', 'Copied');
    expect($page->script('window.copiedOverride'))->toBe(file_get_contents(resource_path('css/brand-theme-example.css')));
    $page->click('[data-docs-sidebar] a[href$="/other/customized-scrollbar"]')->assertPathIs('/other/customized-scrollbar');
    $page->script('Object.defineProperty(navigator, "clipboard", {configurable:true, value:{writeText:async text => { window.copiedOverride = text; }}})');
    $page->click('#scrollbar-overrides > [data-docs-code] [data-copy-code]')->assertSeeIn('#scrollbar-overrides > [data-docs-code] [data-copy-code]', 'Copied');
    expect($page->script('window.copiedOverride'))->toBe(file_get_contents(resource_path('css/brand-scrollbar-example.css')));
    $page->assertNoJavaScriptErrors();
});

it('contains the Other guides in both mobile themes', function (string $guide): void {
    $page = visit('/other/' . $guide)->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true)
            ->assertScript('[...document.querySelectorAll("[data-docs-toc] a[href^=\"#\"]")].every(link => document.querySelectorAll(link.hash).length === 1)', true);
        $page->screenshot(fullPage: true, filename: 'phase5-' . $guide . ($dark ? '-dark' : '-light'));
    }
    $page->assertNoJavaScriptErrors();
})->with(['colors', 'customized-scrollbar']);
