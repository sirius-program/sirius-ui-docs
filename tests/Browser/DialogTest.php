<?php

declare(strict_types=1);

it('fades dialogs in and out while preserving modal state until the exit finishes', function (): void {
    $page = visit('/blade-components/dialog');
    $page->script('document.dispatchEvent(new CustomEvent("dialog:show", { detail: { id: "invoice-review" } })); const d = document.querySelector("#invoice-review"); d.getAnimations().forEach(a => { a.pause(); a.currentTime = 80; });');
    $page->assertScript('(() => { const opacity = Number(getComputedStyle(document.querySelector("#invoice-review")).opacity); return opacity > 0 && opacity < 1; })()', true);
    $page->script('document.querySelector("#invoice-review").getAnimations().forEach(a => a.finish()); document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "invoice-review" } })); document.querySelector("#invoice-review").getAnimations().forEach(a => { a.pause(); a.currentTime = 60; });');
    $page->assertScript('document.querySelector("#invoice-review").matches(":modal")', true);
    $page->assertScript('getComputedStyle(document.documentElement).overflow', 'hidden');
    $page->assertScript('(() => { const opacity = Number(getComputedStyle(document.querySelector("#invoice-review")).opacity); return opacity > 0 && opacity < 1; })()', true);
    $page->script('document.querySelector("#invoice-review").getAnimations().forEach(a => a.finish())');
    $page->assertMissing('#invoice-review')->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('cancels a pending exit when reopened and skips the exit delay for reduced motion', function (): void {
    $page = visit('/blade-components/dialog');
    $page->script('window.closedDialogs = 0; document.addEventListener("dialog:close", () => window.closedDialogs++); const request = name => document.dispatchEvent(new CustomEvent("dialog:" + name, { detail: { id: "invoice-review" } })); request("show"); request("hide"); document.querySelector("#invoice-review").getAnimations().forEach(a => a.pause()); request("show");');
    $page->assertPresent('#invoice-review:modal')->assertAttribute('#invoice-review', 'data-open', 'true')->assertScript('window.closedDialogs', 0);
    $page->script('const original = window.matchMedia.bind(window); window.matchMedia = query => query === "(prefers-reduced-motion: reduce)" ? { matches: true } : original(query); document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "invoice-review" } })); window.closedImmediately = !document.querySelector("#invoice-review").open;');
    $page->assertScript('window.closedImmediately', true)->assertScript('window.closedDialogs', 1)->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('preserves docs content and sticky header and sidebar geometry when opening and closing a dialog', function (int $scroll): void {
    $page = visit('/blade-components/dialog')->resize(1920, 1080);
    $page->script('window.scrollTo(0, ' . $scroll . ')');
    $page->assertScript('scrollY', $scroll);
    $page->script('window.docsGeometry = () => Array.from(document.querySelectorAll("[data-docs-page], [data-docs-toc], [data-flux-sidebar], [data-flux-header]")).map(el => { const r = el.getBoundingClientRect(); return [r.left, r.right, r.width, r.top, r.bottom]; }); window.beforeDialog = window.docsGeometry(); document.dispatchEvent(new CustomEvent("dialog:show", { detail: { id: "invoice-review" } }))');
    $page->assertPresent('#invoice-review:modal')->assertScript('scrollY', $scroll);
    expect($page->script('window.docsGeometry()'))->toBe($page->script('window.beforeDialog'));
    $page->click('#invoice-review [data-sir-dialog-close]');
    expect($page->script('window.docsGeometry()'))->toBe($page->script('window.beforeDialog'));
    $page->assertNoJavaScriptErrors();
})->with([0, 300]);

it('opens an accessible modal and contains focus before returning it to its opener', function (): void {
    $page = visit('/blade-components/dialog')->click('Review invoice')->assertPresent('#invoice-review:modal');
    expect($page->script('document.activeElement.closest("#invoice-review") !== null'))->toBeTrue();
    $page->keys('#invoice-review [data-sir-dialog-close]', 'Tab');
    expect($page->script('document.activeElement.closest("#invoice-review") !== null'))->toBeTrue();
    $page->keys('#invoice-review [data-sir-dialog-close]', 'Escape')->assertMissing('#invoice-review');
    expect($page->script('document.activeElement.getAttribute("data-sir-dialog-open")'))->toBe('invoice-review');
    $page->click('Review invoice')->click('#invoice-review [data-sir-dialog-close]')->assertMissing('#invoice-review')->assertNoJavaScriptErrors();
});

it('supports initial and programmatic native dialog state without Livewire and emits events once', function (): void {
    $page = visit('/development/dialog-native')->assertPresent('#native-dialog:modal');
    $page->assertScript('typeof window.Livewire', 'undefined');
    $page->assertScript('document.activeElement.id', 'native-dialog-close');
    $page->script('window.dialogEvents = []; document.addEventListener("dialog:open", e => window.dialogEvents.push(e.type)); document.addEventListener("dialog:close", e => window.dialogEvents.push(e.type)); document.querySelector("#native-dialog").close()');
    $page->assertAttribute('#native-dialog', 'data-open', 'false')->assertScript('document.documentElement.style.overflow', '');
    $page->script('document.dispatchEvent(new CustomEvent("dialog:show", { detail: { id: "native-dialog" } })); document.dispatchEvent(new CustomEvent("dialog:show", { detail: { id: "native-dialog" } }))');
    $page->assertPresent('#native-dialog:modal');
    $page->script('document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "native-dialog" } }))');
    $page->assertMissing('#native-dialog')->assertScript('window.dialogEvents.join(",")', 'dialog:close,dialog:open,dialog:close')->assertNoJavaScriptErrors();
});

it('fits dialogs and their scrollable content within a mobile viewport in both themes', function (): void {
    $page = visit('/development/dialog-native')->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript('(() => { const r = document.querySelector("#native-dialog").getBoundingClientRect(); return r.left >= 0 && r.right <= innerWidth && r.top >= 0 && r.bottom <= innerHeight; })()');
        $page->screenshot(fullPage: false, filename: $dark ? 'dialog-mobile-dark' : 'dialog-mobile-light');
    }
    $page->script('document.querySelector("#native-dialog-body").style.height = "1800px"');
    $page->assertScript('document.querySelector("#native-dialog").scrollHeight > document.querySelector("#native-dialog").clientHeight');
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        foreach ([0, 900, 1800] as $offset) {
            $page->script('document.querySelector("#native-dialog").scrollTop = ' . $offset);
            $page->assertScript('(() => { const d = document.querySelector("#native-dialog"); const r = d.getBoundingClientRect(); const h = d.querySelector(".sir-dialog-heading").getBoundingClientRect(); const f = d.querySelector(".sir-dialog-footer").getBoundingClientRect(); return Math.abs(h.top - r.top - d.clientTop) < 1 && Math.abs(f.bottom - r.top - d.clientTop - d.clientHeight) < 1; })()');
        }
    }
    $page->click('Close notice')->assertMissing('#native-dialog')->assertNoJavaScriptErrors();
});
