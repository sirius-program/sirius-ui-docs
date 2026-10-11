<?php

declare(strict_types=1);

it('preserves default typography and scopes documentation font overrides', function (): void {
    $page = visit('/other/colors');
    $page->script('window.fontArticle = document.querySelector("[data-docs-page] article"); window.fontHeading = window.fontArticle.querySelector("header h1"); window.fontSummary = window.fontArticle.querySelector("header p"); window.fontFooter = document.querySelector("[data-docs-page] footer");');

    expect($page->script('[getComputedStyle(window.fontHeading).fontSize, getComputedStyle(window.fontSummary).fontSize, getComputedStyle(document.body).fontSize]'))
        ->toBe(['30px', '14px', '16px']);

    $page->script('document.documentElement.style.setProperty("--sir-font-size-sm", "17px");');

    expect($page->script('[getComputedStyle(window.fontSummary).fontSize, getComputedStyle(window.fontFooter).fontSize]'))
        ->toBe(['17px', '17px']);

    $page->script('window.fontArticle.style.setProperty("--docs-font-size-sm", "19px"); window.fontArticle.style.setProperty("--docs-font-size-3xl", "40px");');

    expect($page->script('[getComputedStyle(window.fontHeading).fontSize, getComputedStyle(window.fontSummary).fontSize, getComputedStyle(window.fontFooter).fontSize]'))
        ->toBe(['40px', '19px', '17px']);

    $page->assertNoJavaScriptErrors();
});

it('preserves default font families and scopes main and monospace overrides independently', function (): void {
    $page = visit('/other/colors');
    $page->script('window.familyPage = document.querySelector("[data-docs-page]"); window.familyHeading = window.familyPage.querySelector("article header h1"); window.familyCode = document.querySelector("#color-tokens .sir-code"); window.familyTableMono = document.querySelector("#color-tokens th[scope=row]"); window.familyTableMono.classList.add("font-mono"); window.familyPre = window.familyPage.querySelector("[data-docs-code] pre"); window.familyBlock = window.familyPre.querySelector(".sir-code--block"); window.defaultMonoFamily = getComputedStyle(window.familyPre).fontFamily;');

    $page->assertScript('getComputedStyle(document.body).fontFamily.includes("Instrument Sans")', true)
        ->assertScript('getComputedStyle(window.familyCode).fontFamily === window.defaultMonoFamily && getComputedStyle(window.familyBlock).fontFamily === window.defaultMonoFamily', true);

    $page->script('document.documentElement.style.setProperty("--sir-font-family", "serif");');

    expect($page->script('[getComputedStyle(document.body).fontFamily, getComputedStyle(window.familyHeading).fontFamily]'))
        ->toBe(['serif', 'serif']);
    $page->assertScript('getComputedStyle(window.familyPre).fontFamily === window.defaultMonoFamily', true);

    $page->script('document.documentElement.style.setProperty("--sir-font-family-mono", "monospace");');

    expect($page->script('[getComputedStyle(window.familyCode).fontFamily, getComputedStyle(window.familyTableMono).fontFamily, getComputedStyle(window.familyPre).fontFamily]'))
        ->toBe(['monospace', 'monospace', 'monospace']);

    $page->script('window.familyPage.style.setProperty("--docs-font-family", "monospace"); window.familyPage.style.setProperty("--docs-font-family-mono", "serif");');

    expect($page->script('[getComputedStyle(window.familyHeading).fontFamily, getComputedStyle(window.familyCode).fontFamily, getComputedStyle(window.familyTableMono).fontFamily, getComputedStyle(window.familyPre).fontFamily, getComputedStyle(window.familyBlock).fontFamily, getComputedStyle(document.body).fontFamily]'))
        ->toBe(['monospace', 'serif', 'serif', 'serif', 'serif', 'serif']);
    $page->assertNoJavaScriptErrors();
});

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

it('shows scoped typography and copies its exact applied CSS before navigating to Colors', function (): void {
    $page = visit('/other/typography')->resize(1440, 1000);
    $page->assertPresent('[data-docs-sidebar] a[href$="/other/typography"][aria-current="page"]')
        ->assertScript(<<<'JS'
        (() => {
            const links = [...document.querySelectorAll('[data-docs-sidebar] [data-docs-navigation] a')].map(link => new URL(link.href).pathname);
            return links.indexOf('/other/typography') + 1 === links.indexOf('/other/colors');
        })()
        JS, true);

    expect($page->script('[...document.querySelectorAll("[data-typography-sizes] > p")].map(sample => getComputedStyle(sample).fontSize)'))
        ->toBe(['12px', '14px', '16px', '18px', '20px']);

    $page->script('document.querySelector("[data-typography-sizes]").style.setProperty("--sir-font-size-sm", "17px");');

    expect($page->script('[...document.querySelectorAll("[data-typography-sizes] > p")].map(sample => getComputedStyle(sample).fontSize)'))
        ->toBe(['12px', '17px', '16px', '18px', '20px']);

    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript(<<<'JS'
        (() => {
            const ordinary = document.querySelector('[data-typography-default] p');
            const custom = document.querySelector('[data-typography-custom] p');
            const ordinaryCode = document.querySelector('[data-typography-default] .sir-code');
            const customCode = document.querySelector('[data-typography-custom] .sir-code');
            return getComputedStyle(ordinary).fontFamily.includes('Instrument Sans')
                && getComputedStyle(custom).fontFamily.includes('Georgia')
                && getComputedStyle(customCode).fontFamily.includes('Courier New')
                && getComputedStyle(ordinaryCode).fontFamily !== getComputedStyle(customCode).fontFamily;
        })()
        JS, true);
    }

    $page->script('Object.defineProperty(navigator, "clipboard", {configurable:true, value:{writeText:async text => { window.copiedTypography = text; }}})');
    $page->click('[data-typography-override-source] [data-copy-code]')->assertSeeIn('[data-typography-override-source] [data-copy-code]', 'Copied');
    expect($page->script('window.copiedTypography'))->toBe(file_get_contents(resource_path('css/brand-typography-example.css')));
    $page->click('[data-docs-sidebar] a[href$="/other/colors"]')->assertPathIs('/other/colors')->assertNoJavaScriptErrors();
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
})->with(['typography', 'colors', 'customized-scrollbar']);
