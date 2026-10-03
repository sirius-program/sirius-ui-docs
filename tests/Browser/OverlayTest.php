<?php

declare(strict_types=1);

it('opens an accessible icon prompt and returns focus after keyboard dismissal', function (): void {
    $page = visit('/blade-components/alert')->click('[data-sir-dialog-open="alert-variant-success"]');
    $page->assertPresent('#alert-variant-success:modal')->assertAttribute('#alert-variant-success', 'aria-labelledby', 'alert-variant-success-title')
        ->assertAttribute('#alert-variant-success', 'aria-describedby', 'alert-variant-success-text')
        ->assertSeeIn('#alert-variant-success', 'Your project settings have been updated.');
    expect($page->script('document.activeElement.textContent.trim()'))->toBe('Done');
    $page->keys('#alert-variant-success button', 'Tab');
    $page->assertScript('document.activeElement.closest("#alert-variant-success") !== null', true);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->screenshot(fullPage: false, filename: $dark ? 'alert-dark' : 'alert-light');
    }
    $page->keys('#alert-variant-success button', 'Escape')->assertMissing('#alert-variant-success');
    $page->assertScript('document.activeElement.getAttribute("data-sir-dialog-open")', 'alert-variant-success')->assertNoJavaScriptErrors();
});

it('keeps confirmation open for prevented dismissal and runs only consumer supplied actions', function (): void {
    $page = visit('/development/overlays')->click('[data-sir-dialog-open="archive-project"]');
    $page->assertScript('document.activeElement.id', 'archive-cancel');
    $page->keys('#archive-cancel', 'Escape')->assertPresent('#archive-project:modal');
    $page->script('const d = document.querySelector("#archive-project"); d.dispatchEvent(new PointerEvent("pointerdown", { bubbles: true, clientX: 0, clientY: 0 })); d.dispatchEvent(new MouseEvent("click", { bubbles: true, clientX: 0, clientY: 0 }))');
    $page->assertPresent('#archive-project:modal')->click('#archive-cancel')->assertMissing('#archive-project')
        ->assertMissing('[data-archive-status]');
    $page->click('[data-sir-dialog-open="archive-project"]')->click('#archive-project button:has-text("Confirm archive")')
        ->assertMissing('#archive-project')->assertSeeIn('[data-archive-status]', 'Project archived in this sample. Nothing was stored.')->assertNoJavaScriptErrors();
});

it('anchors every slideover to its edge and keeps header and footer visible during body scroll', function (string $side, string $id): void {
    $page = visit('/blade-components/slideover')->resize(1280, 900)
        ->click('[data-sir-dialog-open="' . $id . '"]')->assertPresent('#' . $id . ':modal');
    $root = '#' . $id;
    $page->assertScript('(() => { const r = document.querySelector("' . $root . '").getBoundingClientRect(); return r.top >= -1 && r.left >= -1 && r.right <= innerWidth + 1 && r.bottom <= innerHeight + 1 && Math.abs(r.' . $side . ' - ' . (in_array($side, ['top', 'left'], true) ? '0' : ($side === 'right' ? 'innerWidth' : 'innerHeight')) . ') < 1; })()', true);
    $page->script('const d = document.querySelector("' . $root . '"); const content = document.createElement("div"); content.style.height = "1800px"; d.querySelector(".sir-dialog-body").append(content); window.chromeGeometry = () => Array.from(d.querySelectorAll(".sir-dialog-heading,.sir-dialog-footer")).map(el => { const r = el.getBoundingClientRect(); return [r.top,r.bottom]; }); window.beforeScroll = window.chromeGeometry()');
    $page->assertScript('(() => { const b = document.querySelector("' . $root . ' .sir-dialog-body"); return b.scrollHeight > b.clientHeight; })()', true);
    $page->script('document.querySelector("' . $root . ' .sir-dialog-body").scrollTop = 900');
    $page->assertScript('document.querySelector("' . $root . ' .sir-dialog-body").scrollTop', 900);
    expect($page->script('window.chromeGeometry()'))->toBe($page->script('window.beforeScroll'));
    $page->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->assertScript('(() => { const r = document.querySelector("' . $root . '").getBoundingClientRect(); return r.top >= -1 && r.left >= -1 && r.right <= innerWidth + 1 && r.bottom <= innerHeight + 1; })()', true);
        $page->screenshot(fullPage: false, filename: 'slideover-' . $side . ($dark ? '-dark' : '-light'));
    }
    $page->script('const d = document.querySelector("' . $root . '"); d.classList.remove("sir-dialog--sm", "sir-dialog--md", "sir-dialog--lg", "sir-dialog--xl"); d.classList.add("sir-dialog--full")');
    $page->assertScript('(() => { const r = document.querySelector("' . $root . '").getBoundingClientRect(); return Math.abs(r.width - innerWidth) < 1 && Math.abs(r.height - innerHeight) < 1; })()', true);
    $page->keys($root . ' .sir-dialog-dismiss', 'Escape')->assertMissing($root)->assertNoJavaScriptErrors();
})->with([['right', 'blade-slideover-form'], ['left', 'project-navigation'], ['top', 'delivery-updates'], ['bottom', 'billing-summary']]);

it('keeps modal state and scroll locks until the slideover exit animation finishes', function (): void {
    $page = visit('/blade-components/slideover');
    $page->script('document.dispatchEvent(new CustomEvent("dialog:show", { detail: { id: "blade-slideover-form" } })); document.querySelector("#blade-slideover-form").getAnimations().forEach(a => { a.pause(); a.currentTime = 90; })');
    $page->assertScript('(() => { const style = getComputedStyle(document.querySelector("#blade-slideover-form")); return style.transform !== "none" && Number(style.opacity) > 0 && Number(style.opacity) < 1; })()', true);
    $page->script('document.querySelector("#blade-slideover-form").getAnimations().forEach(a => a.finish()); document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "blade-slideover-form" } })); document.querySelector("#blade-slideover-form").getAnimations().forEach(a => { a.pause(); a.currentTime = 70; })');
    $page->assertPresent('#blade-slideover-form:modal')->assertScript('getComputedStyle(document.documentElement).overflow', 'hidden');
    $page->script('document.querySelector("#blade-slideover-form").getAnimations().forEach(a => a.finish())');
    $page->assertMissing('#blade-slideover-form')->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('disables overlay animation and closes immediately for reduced motion', function (): void {
    $page = visit('/blade-components/slideover', ['reducedMotion' => 'reduce'])->click('[data-sir-dialog-open="blade-slideover-form"]');
    $page->assertScript('matchMedia("(prefers-reduced-motion: reduce)").matches', true);
    $page->assertScript('getComputedStyle(document.querySelector("#blade-slideover-form")).animationName', 'none');
    $page->script('document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "blade-slideover-form" } })); window.closedImmediately = !document.querySelector("#blade-slideover-form").open');
    $page->assertScript('window.closedImmediately', true)->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('shares one active overlay across Alpine Alert Slideover and Dialog and blocks nesting', function (): void {
    $page = visit('/development/overlays')->click('#alpine-alert-trigger')->assertPresent('#alpine-alert:modal')
        ->click('Open delivery panel')->assertMissing('#alpine-alert')->assertPresent('#blade-slideover:modal')
        ->click('Open invoice dialog')->assertMissing('#blade-slideover')->assertPresent('#blade-dialog:modal')
        ->click('Try nested alert')->assertMissing('#nested-alert')->assertPresent('#blade-dialog:modal');
    $page->assertScript('document.querySelectorAll("dialog:modal").length', 1);
    $page->keys('#blade-dialog .sir-dialog-dismiss', 'Escape')->assertMissing('#blade-dialog');
    $page->assertScript('document.activeElement.id', 'alpine-alert-trigger')->assertScript('document.documentElement.style.overflow', '')
        ->click('#alpine-alert-trigger')->assertPresent('#alpine-alert:modal')->assertNoJavaScriptErrors();
});

it('preserves Livewire overlay state during updates validation removal and navigation', function (): void {
    $page = visit('/development/overlays')->click('#server-alert-trigger')->assertPresent('#server-alert:modal')
        ->click('#server-alert button:has-text("Edit delivery")')->assertMissing('#server-alert')->assertPresent('#server-slideover:modal');
    $page->assertScript('document.activeElement.id', 'overlay-note');
    $page->click('Save delivery note')->assertSee('The note field is required.')->assertPresent('#server-slideover:modal')
        ->type('#overlay-note', 'Leave at reception')->click('Refresh delivery note')->assertSee('Delivery revision 1')
        ->assertValue('#overlay-note', 'Leave at reception')->assertPresent('#server-slideover:modal');
    $page->click('Save delivery note')->assertMissing('#server-slideover')->assertSeeIn('[data-overlay-state]', 'Closed');
    $page->click('#server-slideover-trigger')->click('Remove active overlay')->assertNotPresent('#server-slideover')
        ->assertScript('document.documentElement.style.overflow', '');
    $page->click('Toggle overlay visibility')->assertPresent('#server-slideover:modal')
        ->click('#server-slideover button:has-text("Review delivery")')->assertMissing('#server-slideover')->assertPresent('#server-alert:modal');
    $page->script('Livewire.navigate("/blade-components/slideover")');
    $page->assertSee('Create project')->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('preserves scrolled sticky and fixed content for every overlay and restores existing styles', function (string $id, bool $fallback): void {
    $page = visit('/blade-components/slideover')->resize(1920, 1080);
    $page->script('document.documentElement.style.overflowX = "clip"; document.documentElement.style.paddingRight = "3px"; document.body.style.overflowX = "clip"; const fixed = document.createElement("div"); fixed.dataset.overlayFixed = ""; fixed.style.cssText = "position:fixed;right:10px;top:10px;width:20px;height:20px;pointer-events:none"; document.body.append(fixed); window.overlayStyles = () => [document.documentElement.style, document.body.style, fixed.style].map(s => Array.from(s).sort().map(k => [k, s.getPropertyValue(k), s.getPropertyPriority(k)])); window.originalStyles = window.overlayStyles();');
    if ($fallback) {
        $page->script('const supports = CSS.supports; CSS.supports = (...args) => args[0] === "scrollbar-gutter" ? false : supports(...args); document.documentElement.style.scrollbarGutter = "auto"; window.originalStyles = window.overlayStyles()');
    }
    $page->script('window.scrollTo(0, 200)');
    $page->assertScript('scrollY', 200);
    $page->script('window.backgroundGeometry = () => Array.from(document.querySelectorAll("[data-flux-header], [data-flux-sidebar], [data-docs-page], [data-overlay-fixed]")).map(el => { const r = el.getBoundingClientRect(); return [r.top,r.left,r.right]; }); window.originalGeometry = window.backgroundGeometry(); document.dispatchEvent(new CustomEvent("dialog:show", { detail: { id: "' . $id . '" } }))');
    $page->assertPresent('#' . $id . ':modal')->assertScript('scrollY', 200);
    expect($page->script('window.backgroundGeometry()'))->toBe($page->script('window.originalGeometry'));
    $page->script('document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "' . $id . '" } }))');
    $page->assertMissing('#' . $id);
    expect($page->script('window.overlayStyles()'))->toBe($page->script('window.originalStyles'));
    $page->assertScript('scrollY', 200)->assertNoJavaScriptErrors();
})->with([['blade-slideover-form', false], ['project-navigation', false], ['delivery-updates', false], ['billing-summary', false], ['blade-slideover-form', true]]);

it('honors prevented Escape and backdrop dismissal and initial focus with Alpine state', function (): void {
    $page = visit('/development/overlays');
    $page->script('const d = document.querySelector("#alpine-dialog"); d.dataset.closeOnEscape = "false"; d.dataset.closeOnBackdrop = "false"; const button = d.querySelector("button"); button.id = "alpine-confirm"; d.dataset.initialFocus = "#alpine-confirm"');
    $page->click('Open Alpine dialog')->assertPresent('#alpine-dialog:modal');
    expect($page->script('document.activeElement.id'))->toBe('alpine-confirm');
    $page->keys('#alpine-confirm', 'Escape')->assertPresent('#alpine-dialog:modal');
    $page->script('const d = document.querySelector("#alpine-dialog"); d.dispatchEvent(new PointerEvent("pointerdown", { bubbles: true, clientX: 0, clientY: 0 })); d.dispatchEvent(new MouseEvent("click", { bubbles: true, clientX: 0, clientY: 0 }))');
    $page->assertPresent('#alpine-dialog:modal')->click('Switch to second dialog')->assertPresent('#second-dialog:modal');
    $page->script('const d = document.querySelector("#second-dialog"); d.dispatchEvent(new PointerEvent("pointerdown", { bubbles: true, clientX: 0, clientY: 0 })); d.dispatchEvent(new MouseEvent("click", { bubbles: true, clientX: 0, clientY: 0 }))');
    $page->assertMissing('#second-dialog')->assertNoJavaScriptErrors();
});

it('keeps a Livewire dialog and its focus through validation updates and interactive widgets', function (): void {
    $page = visit('/development/overlays')->click('#livewire-dialog-trigger')->assertPresent('#livewire-dialog:modal');
    expect($page->script('document.activeElement.id'))->toBe('delivery-address');
    $page->click('#livewire-dialog button:has-text("Save delivery")')->assertSee('The address field is required.')->assertPresent('#livewire-dialog:modal');
    $page->type('#delivery-address', 'Bandung studio')->click('#livewire-dialog button:has-text("Refresh delivery")')->assertSee('Delivery revision 1')->assertPresent('#livewire-dialog:modal')->assertValue('#delivery-address', 'Bandung studio');
    $page->assertScript('document.activeElement.textContent.trim()', 'Refresh delivery');
    $page->click('#livewire-dialog .ts-control')->click('#livewire-dialog .ts-dropdown .option[data-value="express"]');
    $page->assertScript('document.querySelector("#dialog-shipping").value', 'express');
    $page->click('#dialog-date')->assertPresent('#livewire-dialog .flatpickr-calendar.open')
        ->click('#livewire-dialog .flatpickr-day[aria-label="October 16, 2028"]')->assertValue('#dialog-date', '16/10/2028');
    $page->click('#livewire-dialog button:has-text("Save delivery")')->assertMissing('#livewire-dialog')->assertSeeIn('[data-dialog-state]', 'Closed')->assertNoJavaScriptErrors();
});

it('replaces the active dialog and cleans scroll locks after removal remounting and navigation', function (): void {
    $page = visit('/development/overlays')->click('Open Alpine dialog')->assertPresent('#alpine-dialog:modal')
        ->click('Switch to second dialog')->assertMissing('#alpine-dialog')->assertPresent('#second-dialog:modal')
        ->click('Close second dialog')->assertMissing('#second-dialog');
    $page->assertScript('document.activeElement.id', 'alpine-dialog-trigger');
    $page->assertScript('document.querySelectorAll("dialog:modal").length', 0);
    $page->click('#livewire-dialog-trigger')->click('Remove dialog')->assertNotPresent('#livewire-dialog');
    $page->assertScript('document.documentElement.style.overflow', '');
    $page->click('Toggle dialog visibility')->assertPresent('#livewire-dialog:modal')
        ->click('#livewire-dialog button:has-text("Cancel delivery")')->assertSeeIn('[data-dialog-state]', 'Closed');
    $page->click('Open Alpine dialog');
    $page->script('Livewire.navigate("/blade-components/dialog")');
    $page->assertSee('Review invoice')->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('preserves page and fixed element geometry and restores previous styles with or without a scrollbar', function (bool $scrollbar, bool $fallback): void {
    $page = visit('/development/overlays');
    $page->script('document.querySelector("[data-dialog-layout]").style.height = "' . ($scrollbar ? '1800px' : '0') . '"; document.documentElement.style.scrollbarGutter = "' . ($scrollbar ? 'stable' : 'auto') . '"; document.body.style.overflow = "clip"; document.documentElement.style.paddingRight = "3px"; window.savedStyles = [document.documentElement.getAttribute("style"), document.body.getAttribute("style"), document.querySelector("[data-dialog-fixed]").getAttribute("style")]; window.savedGeometry = [document.querySelector("[data-dialog-example]").getBoundingClientRect().right, document.querySelector("[data-dialog-fixed]").getBoundingClientRect().right]');
    if ($fallback) {
        $page->script('window.supportsCSS = CSS.supports; CSS.supports = (...args) => args[0] === "scrollbar-gutter" ? false : window.supportsCSS(...args); document.documentElement.style.scrollbarGutter = "auto"; window.savedStyles[0] = document.documentElement.getAttribute("style"); window.savedGeometry = [document.querySelector("[data-dialog-example]").getBoundingClientRect().right, document.querySelector("[data-dialog-fixed]").getBoundingClientRect().right]');
    }
    $page->click('Open Alpine dialog')->assertPresent('#alpine-dialog:modal');
    $page->assertScript('getComputedStyle(document.documentElement).overflow', 'hidden');
    $page->assertScript('Math.abs(document.querySelector("[data-dialog-example]").getBoundingClientRect().right - window.savedGeometry[0]) < 1');
    $page->assertScript('Math.abs(document.querySelector("[data-dialog-fixed]").getBoundingClientRect().right - window.savedGeometry[1]) < 1');
    $page->click('#alpine-dialog [data-sir-dialog-close]')->assertMissing('#alpine-dialog');
    expect($page->script('[document.documentElement.getAttribute("style"), document.body.getAttribute("style"), document.querySelector("[data-dialog-fixed]").getAttribute("style")]'))->toBe($page->script('window.savedStyles'));
    $page->assertNoJavaScriptErrors();
})->with([[true, false], [false, false], [true, true]]);
