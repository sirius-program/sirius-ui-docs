<?php

declare(strict_types=1);

it('preserves inline and block formatting in light and dark themes without affecting native code', function (): void {
    $page = visit('/blade-components/code')->resize(390, 844)->assertPresent('[data-code-block-demo] .sir-code--block');
    $page->script('const native = document.createElement("code"); native.id = "native-code-probe"; native.textContent = "untouched"; document.querySelector("article").append(native);');
    $nativeBefore = $page->script('getComputedStyle(document.querySelector("#native-code-probe")).padding');
    $colors = [];
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $colors[] = $page->script('getComputedStyle(document.querySelector("[data-code-inline-demo] .sir-tone--primary")).backgroundColor');
        $page->assertScript('(() => { const code = document.querySelector("[data-code-block-demo] code"); const style = getComputedStyle(code); const parent = getComputedStyle(code.parentElement); return style.padding === "0px" && style.borderTopWidth === "0px" && style.color === parent.color && style.fontSize === parent.fontSize && code.textContent === "<main>\\n    <h1>Project overview</h1>\\n</main>\\n"; })()', true);
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true);
    }
    expect($colors[0])->not->toBe($colors[1]);
    expect($page->script('getComputedStyle(document.querySelector("#native-code-probe")).padding'))->toBe($nativeBefore);
    $page->assertNoJavaScriptErrors();
});

it('preserves exact copied examples and highlighting when navigating between the new pages', function (): void {
    $page = visit('/blade-components/code')->resize(1440, 1000)->assertPresent('#code-usage .docs-token-tag');
    $source = $page->script('document.querySelector("#code-usage [data-docs-code] code").textContent');
    $page->script('Object.defineProperty(navigator, "clipboard", {configurable: true, value: {writeText: async text => { window.copiedSource = text; }}});');
    $page->click('#code-usage [data-usage-example]:nth-of-type(1) [data-copy-code]')->assertSee('Copied');
    expect($page->script('window.copiedSource'))->toBe($source);
    $page->click('[data-docs-sidebar] a[href$="/blade-components/link"]')->assertPathIs('/blade-components/link')->assertPresent('#link-usage .docs-token-tag');
    $page->assertAttribute('[data-link-variants-demo] .sir-link:first-child', 'href', '#')
        ->click('[data-link-variants-demo] .sir-link:first-child')->assertScript('location.href.endsWith("#")', true);
    $page->assertAttribute('.sir-link[download]', 'download', 'project-brief.pdf')->assertNoJavaScriptErrors();
});

it('keeps link tones legible and keyboard focus visible without changing native anchors', function (): void {
    $page = visit('/blade-components/link')->resize(1440, 1000);
    $page->script('const native = document.createElement("a"); native.id = "native-link-probe"; native.href = "#probe"; native.textContent = "Native"; document.querySelector("article").append(native); window.nativeLinkColor = getComputedStyle(native).color;');
    $colors = [];
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $colors[] = $page->script('getComputedStyle(document.querySelector("[data-link-variants-demo] .sir-link:first-child")).color');
        $page->assertScript('Array.from(document.querySelectorAll("[data-link-variants-demo] .sir-link")).every(link => getComputedStyle(link).textDecorationLine.includes("underline"))', true);
    }
    expect($colors[0])->not->toBe($colors[1]);
    $page->script('document.documentElement.classList.remove("dark"); document.querySelector("[data-link-variants-demo] .sir-link:first-child").focus();');
    $page->keys('[data-link-variants-demo] .sir-link:first-child', 'Tab');
    $page->assertScript('document.activeElement.matches("[data-link-variants-demo] .sir-link:nth-child(2)") && getComputedStyle(document.activeElement).outlineStyle === "solid"', true);
    $page->assertScript('getComputedStyle(document.querySelector("#native-link-probe")).color === window.nativeLinkColor', true)->assertNoJavaScriptErrors();
});
