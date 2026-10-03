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

it('edits and submits all kinds of package controls inside a project dialog', function (string $mode): void {
    withUploadBrowser(function (string $url) use ($mode): void {
        $prefix = $mode === 'Livewire' ? 'dialog-form' : 'blade-dialog-form';
        $root = '#' . $prefix;
        $page = visit(str_replace('/file-upload', '/dialog', $url));
        $page->assertSee('Create project')->click('[data-dialog-form="' . strtolower($mode) . '"] > button')->assertPresent($root . ':modal');
        $page->script('const source = document.querySelector("' . $root . ' [data-richtext-source]"); source.removeAttribute("hidden"); source.removeAttribute("data-richtext-enhanced")');
        $page->assertMissing($root . '-brief')->assertPresent($root . '-brief-richtext');
        $page->script('const d = document.querySelector("' . $root . '"); const spacer = document.createElement("div"); spacer.dataset.dialogLayerSpacer = ""; spacer.style.height = "1000px"; d.querySelector(".sir-dialog-body").append(spacer)');
        foreach ([false, true] as $dark) {
            $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
            foreach (['.sir-dialog-heading', '.sir-dialog-footer'] as $section) {
                $page->script('const d = document.querySelector("' . $root . '"); const t = d.querySelector(".tiptap-toolbar").getBoundingClientRect(); const s = d.querySelector("' . $section . '").getBoundingClientRect(); d.scrollTop += t.top + t.height / 2 - s.top - 10');
                $page->assertScript('(() => { const d = document.querySelector("' . $root . '"); const s = d.querySelector("' . $section . '"); const t = d.querySelector(".tiptap-toolbar").getBoundingClientRect(); const r = s.getBoundingClientRect(); const y = r.top + 10; return t.top <= y && t.bottom >= y && s.contains(document.elementFromPoint(t.left + 20, y)); })()', true);
            }
        }
        $page->script('document.querySelector("' . $root . ' [data-dialog-layer-spacer]").remove(); document.querySelector("' . $root . '").scrollTop = 0; document.documentElement.classList.remove("dark")');
        $page->screenshot(fullPage: false, filename: 'dialog-fields-' . strtolower($mode));
        $page->click($root . ' button:has-text("Load Value")')->assertValue($root . '-title', 'Website redesign');
        $page->type($root . '-title', 'Customer portal')->type($root . '-seats', '8')
            ->type($root . '-password', 'example-password')->click($root . ' [data-sir-password-toggle]');
        $page->assertAttribute($root . '-password', 'type', 'text');
        $page->type($root . '-budget', '2500.50')->assertValue($root . '-budget', '2,500.50');
        $page->select('[data-sir-phone]:has(' . $root . '-phone) [data-phone-country]', 'GB')->type($root . '-phone', '02079460018');
        $page->click('[data-sir-select]:has(' . $root . '-delivery) .ts-control')
            ->click($root . ' .ts-dropdown .option[data-value="express"]');
        $page->click('[data-sir-select]:has(' . $root . '-services) .ts-control')
            ->click($root . ' .ts-dropdown .option[data-value="development"]');
        $page->click($root . '-date')->assertPresent($root . ' .flatpickr-calendar.open')
            ->click($root . ' .flatpickr-calendar.open .flatpickr-day[aria-label="October 16, 2028"]');
        $page->click($root . '-time')->assertPresent($root . ' .flatpickr-calendar.open .flatpickr-time');
        $page->keys($root . ' .flatpickr-calendar.open .flatpickr-hour', 'Escape')->assertPresent($root . ':modal');
        $page->click($root . '-appointment')->assertPresent($root . ' .flatpickr-calendar.open .flatpickr-time');
        $page->keys($root . ' .flatpickr-calendar.open .flatpickr-hour', 'Escape')->assertPresent($root . ':modal');
        $page->type($root . '-notes', 'Ship the first draft on Friday.')->check($root . '-editor')->check($root . '-pro')->uncheck($root . '-notifications');
        $page->keys($root . '-discount-handle', 'ArrowRight')->assertValue($root . '-discount', '15')
            ->keys($root . '-range-upper-handle', 'ArrowRight')->assertValue($root . '-range-upper', '180');
        $page->type($root . '-brief-richtext', 'Project update');
        $page->click('[data-sir-richtext]:has(' . $root . '-brief) [data-richtext-command="link"]')
            ->assertPresent($root . ' input[placeholder="Link URL"]');
        $page->keys($root . ' input[placeholder="Link URL"]', 'Escape')->assertPresent($root . ':modal');
        $richtext = '[data-sir-richtext]:has(' . $root . '-brief)';
        $page->attach($richtext . ' input[type="file"]', public_path('sample/sample.jpg'))
            ->assertSeeIn($richtext . ' .sir-richtext-upload-status', 'Image uploaded.')->assertPresent($root . '-brief-richtext img');
        $page->attach($root . ' .filepond--browser', public_path('sample/sample.pdf'))->assertSeeIn($root . ' .filepond--file-info-main', 'sample.pdf');
        if ($mode === 'Livewire') {
            $page->assertSeeIn($root . ' .filepond--file-status-main', 'Upload complete');
        }
        $page->click($root . ' button:has-text("Submit / Validate")')->assertSeeIn($root, 'Project validated. Nothing was stored.')
            ->assertValue($root . '-title', 'Customer portal')->assertPresent($root . ':modal');
        $page->assertScript('Array.from(document.querySelectorAll("' . $root . ' [data-select-source], ' . $root . ' [data-slider-source], ' . $root . ' [data-richtext-source], ' . $root . ' [data-upload-source]")).every(el => el.getClientRects().length === 0)', true);
        $page->resize(390, 844);
        $page->assertScript('(() => { const d = document.querySelector("' . $root . '"); return d.scrollWidth <= d.clientWidth && d.getBoundingClientRect().right <= innerWidth; })()', true);
        $page->script('document.querySelector("' . $root . '").scrollTop = 0; document.documentElement.classList.add("dark")');
        $page->screenshot(fullPage: false, filename: 'dialog-form-' . strtolower($mode) . '-mobile');
        if ($mode === 'Livewire') {
            $page->click($root . ' button:has-text("Toggle Readonly")')->assertAttribute($root . '-brief-richtext', 'contenteditable', 'false')
                ->assertAttribute($root . '-discount-handle', 'aria-readonly', 'true')->assertScript('document.querySelector("' . $root . '-title").readOnly', true);
        }
        $page->click($root . ' button:has-text("Reset Sample")')->assertValue($root . '-title', '')
            ->click($root . ' .sir-dialog-footer [data-sir-dialog-close]')->assertMissing($root)->assertNoJavaScriptErrors();
    });
})->with(['Livewire', 'Blade']);

it('anchors datetime pickers to their fields while scrolling and resizing a dialog', function (string $mode): void {
    withUploadBrowser(function (string $url) use ($mode): void {
        $root = $mode === 'Livewire' ? '#dialog-form' : '#blade-dialog-form';
        $page = visit(str_replace('/file-upload', '/dialog', $url))->resize(1280, 900)
            ->click('[data-dialog-form="' . strtolower($mode) . '"] > button');
        foreach (['date', 'time', 'appointment'] as $field) {
            $page->click($root . '-' . $field)->assertPresent($root . ' .flatpickr-calendar.open');
            $page->assertScript('getComputedStyle(document.querySelector("' . $root . ' .flatpickr-calendar.open")).position', 'fixed');
            foreach ([0, 30] as $offset) {
                $page->script('document.querySelector("' . $root . '").scrollTop += ' . $offset);
                $page->assertScript('(() => { const i = document.querySelector("' . $root . '-' . $field . '").getBoundingClientRect(); const c = document.querySelector("' . $root . ' .flatpickr-calendar.open").getBoundingClientRect(); return Math.abs(c.left - i.left) < 1 && (Math.abs(c.top - i.bottom - 2) < 1 || Math.abs(c.bottom - i.top + 2) < 1); })()', true);
            }
            $page->keys($root . '-' . $field, 'Escape');
        }
        $page->resize(1100, 760)->click($root . '-date');
        $page->assertScript('(() => { const i = document.querySelector("' . $root . '-date").getBoundingClientRect(); const c = document.querySelector("' . $root . ' .flatpickr-calendar.open").getBoundingClientRect(); return Math.abs(c.left - i.left) < 1 && (Math.abs(c.top - i.bottom - 2) < 1 || Math.abs(c.bottom - i.top + 2) < 1); })()', true)->assertNoJavaScriptErrors();
    });
})->with(['Livewire', 'Blade']);

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

it('honors prevented Escape and backdrop dismissal and initial focus with Alpine state', function (): void {
    $page = visit('/development/dialog');
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
    $page = visit('/development/dialog')->click('Edit delivery')->assertPresent('#livewire-dialog:modal');
    expect($page->script('document.activeElement.id'))->toBe('delivery-address');
    $page->click('Save delivery')->assertSee('The address field is required.')->assertPresent('#livewire-dialog:modal');
    $page->type('#delivery-address', 'Bandung studio')->click('Refresh delivery')->assertSee('Delivery revision 1')->assertPresent('#livewire-dialog:modal')->assertValue('#delivery-address', 'Bandung studio');
    $page->assertScript('document.activeElement.textContent.trim()', 'Refresh delivery');
    $page->click('#livewire-dialog .ts-control')->click('#livewire-dialog .ts-dropdown .option[data-value="express"]');
    $page->assertScript('document.querySelector("#dialog-shipping").value', 'express');
    $page->click('#dialog-date')->assertPresent('#livewire-dialog .flatpickr-calendar.open')
        ->click('#livewire-dialog .flatpickr-day[aria-label="October 16, 2028"]')->assertValue('#dialog-date', '16/10/2028');
    $page->click('Save delivery')->assertMissing('#livewire-dialog')->assertSeeIn('[data-dialog-state]', 'Closed')->assertNoJavaScriptErrors();
});

it('replaces the active dialog and cleans scroll locks after removal remounting and navigation', function (): void {
    $page = visit('/development/dialog')->click('Open Alpine dialog')->assertPresent('#alpine-dialog:modal')
        ->click('Switch to second dialog')->assertMissing('#alpine-dialog')->assertPresent('#second-dialog:modal')
        ->click('Close second dialog')->assertMissing('#second-dialog');
    $page->assertScript('document.activeElement.id', 'alpine-dialog-trigger');
    $page->assertScript('document.querySelectorAll("dialog:modal").length', 0);
    $page->click('Edit delivery')->click('Remove dialog')->assertNotPresent('#livewire-dialog');
    $page->assertScript('document.documentElement.style.overflow', '');
    $page->click('Toggle dialog visibility')->assertPresent('#livewire-dialog:modal')
        ->click('Cancel delivery')->assertSeeIn('[data-dialog-state]', 'Closed');
    $page->click('Open Alpine dialog');
    $page->script('Livewire.navigate("/blade-components/dialog")');
    $page->assertSee('Review invoice')->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('preserves page and fixed element geometry and restores previous styles with or without a scrollbar', function (bool $scrollbar, bool $fallback): void {
    $page = visit('/development/dialog');
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
