<?php

declare(strict_types=1);

it('opens every variant without stealing focus and closes through its controls', function (): void {
    $page = visit('/blade-components/toast');
    foreach (['primary', 'info', 'secondary', 'success', 'danger', 'warning', 'ghost', 'outline'] as $variant) {
        $id = 'project-toast-' . $variant;
        $page->click('[data-sir-toast-open="' . $id . '"]')->assertPresent('#' . $id . '-panel:popover-open')
            ->assertScript('document.activeElement.getAttribute("data-sir-toast-open")', $id);
        $page->assertScript('document.querySelector("[data-sir-toast-announcement]").getAttribute("role")', $variant === 'danger' ? 'alert' : 'status');
        $page->click('#' . $id . '-panel [data-sir-toast-close]')->assertMissing('#' . $id . '-panel');
    }
    $page->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});

it('closes timed notices and pauses the remaining duration during hover focus and document hiding', function (): void {
    $page = visit('/development/toast');
    $page->script('window.toastClosed = []; document.addEventListener("toast:close", e => window.toastClosed.push(e.detail)); document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "timer-toast" } }));');
    $page->assertMissing('#timer-toast-panel');
    expect($page->script('window.toastClosed.filter(e => e.id === "timer-toast").map(e => e.reason)'))->toBe(['timeout']);

    $page->click('#timer-trigger')->assertPresent('#timer-toast-panel');
    $page->script('document.querySelector("#timer-toast-panel").dispatchEvent(new PointerEvent("pointerenter"));');
    $page->script('new Promise(resolve => setTimeout(resolve, 1200))');
    $page->assertPresent('#timer-toast-panel');
    $page->script('document.querySelector("#timer-toast-panel").dispatchEvent(new PointerEvent("pointerleave")); document.querySelector("#timer-action").focus();');
    $page->script('new Promise(resolve => setTimeout(resolve, 1200))');
    $page->assertPresent('#timer-toast-panel');
    $page->script('document.querySelector("#timer-trigger").focus(); Object.defineProperty(document, "hidden", { configurable: true, value: true }); document.dispatchEvent(new Event("visibilitychange"));');
    $page->script('new Promise(resolve => setTimeout(resolve, 1200))');
    $page->assertPresent('#timer-toast-panel');
    $page->script('Object.defineProperty(document, "hidden", { configurable: true, value: false }); document.dispatchEvent(new Event("visibilitychange"));');
    $page->assertMissing('#timer-toast-panel')->assertNoJavaScriptErrors();
});

it('limits visible notifications and drains a bounded FIFO queue without duplicate requests', function (): void {
    $page = visit('/development/toast');
    $page->script('window.queueCloses = []; document.addEventListener("toast:close", e => window.queueCloses.push(e.detail)); for (let i = 1; i <= 25; i++) document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: `queued-toast-${i}` } }));');
    $page->assertScript('document.querySelectorAll("[data-sir-toast-panel]:popover-open").length', 3);
    expect($page->script('window.queueCloses.map(e => [e.id, e.reason])'))->toBe([['queued-toast-4', 'overflow'], ['queued-toast-5', 'overflow']]);
    $page->script('document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "queued-toast-7" } })); document.dispatchEvent(new CustomEvent("toast:hide", { detail: { id: "queued-toast-6" } })); document.dispatchEvent(new CustomEvent("toast:hide", { detail: { id: "queued-toast-1" } }));');
    $page->assertPresent('#queued-toast-7-panel')->assertScript('document.querySelectorAll("[data-sir-toast-panel]:popover-open").length', 3);
    $page->script('document.querySelector("#queued-toast-2").remove();');
    $page->assertPresent('#queued-toast-8-panel')->assertNoJavaScriptErrors();
});

it('starts queued timers when visible and restarts the timer when the same ID is shown again', function (): void {
    $page = visit('/development/toast');
    $page->script('for (let i = 1; i <= 3; i++) document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: `queued-toast-${i}` } })); document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "timer-toast" } }));');
    $page->script('new Promise(resolve => setTimeout(resolve, 1100))');
    $page->assertMissing('#timer-toast-panel');
    $page->script('document.dispatchEvent(new CustomEvent("toast:hide", { detail: { id: "queued-toast-1" } }));');
    $page->assertPresent('#timer-toast-panel');
    $page->script('new Promise(resolve => setTimeout(resolve, 500));');
    $page->script('document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "timer-toast" } }));');
    $page->script('new Promise(resolve => setTimeout(resolve, 500));');
    $page->assertPresent('#timer-toast-panel')->assertMissing('#timer-toast-panel')->assertNoJavaScriptErrors();
});

it('synchronizes Livewire events bound state footer actions and removal without reviving expired notices', function (): void {
    $page = visit('/development/toast')->click('#event-notify')->assertPresent('#event-toast-panel')->assertSeeIn('#event-toast-panel', 'Delivery revision 1')
        ->click('#toast-acknowledge')->assertSeeIn('#toast-actions', 'Actions: 1')->assertPresent('#event-toast-panel')
        ->click('#toast-refresh')->assertSeeIn('#event-toast-panel', 'Delivery revision 2')
        ->click('#bound-notify')->assertSeeIn('#toast-server-state', 'Open')->assertPresent('#bound-toast-panel')
        ->assertMissing('#bound-toast-panel')->assertSeeIn('#toast-server-state', 'Closed')
        ->click('#toast-refresh')->assertMissing('#bound-toast-panel')->assertPresent('#event-toast-panel')
        ->click('#toast-toggle')->assertMissing('#event-toast-panel')->click('#toast-toggle')
        ->click('#event-notify')->assertPresent('#event-toast-panel')->click('#event-hide')->assertMissing('#event-toast-panel')
        ->assertNoJavaScriptErrors();
    $page->script('for (let i = 1; i <= 3; i++) document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: `queued-toast-${i}` } }));');
    $page->click('#event-notify')->assertMissing('#event-toast-panel')->click('#toast-refresh')->assertSeeIn('#toast-revision', 'Revision: 6');
    $page->script('document.dispatchEvent(new CustomEvent("toast:hide", { detail: { id: "queued-toast-1" } }));');
    $page->assertPresent('#event-toast-panel')->assertSeeIn('#event-toast-panel', 'Delivery revision 6')->assertNoJavaScriptErrors();
});

it('keeps Toast actions usable above modal overlays while preserving overlay focus and scroll locks', function (string $kind, string $notify): void {
    $page = visit('/development/toast')->click('#persistent-trigger')->assertPresent('#persistent-toast-panel')
        ->click('#toast-' . $kind . '-trigger')->assertScript('document.querySelector("#persistent-toast-panel").parentElement.id', 'toast-' . $kind)
        ->click('#persistent-toast-panel [data-sir-toast-close]')->assertMissing('#persistent-toast-panel')->assertPresent('#toast-' . $kind . ':modal')
        ->click('#' . $notify)
        ->assertPresent('#event-toast-panel')->assertPresent('#toast-' . $kind . ':modal');
    $page->assertScript('document.activeElement.id', $notify);
    $page->assertScript('document.querySelector("#event-toast-panel").parentElement.id', 'toast-' . $kind);
    $page->screenshot(fullPage: false, filename: 'toast-over-' . $kind);
    $page->click('#toast-acknowledge')->assertSeeIn('#toast-actions', 'Actions: 1')->assertPresent('#event-toast-panel')
        ->assertPresent('#toast-' . $kind . ':modal')->assertScript('getComputedStyle(document.documentElement).overflow', 'hidden')
        ->keys('#toast-acknowledge', 'Escape')->assertMissing('#event-toast-panel')
        ->assertScript('document.activeElement.id', $notify)->assertPresent('#toast-' . $kind . ':modal')
        ->keys('#' . $notify, 'Escape')->assertMissing('#toast-' . $kind)->assertNoJavaScriptErrors();
})->with([['dialog', 'dialog-notify'], ['slideover', 'slideover-notify']]);

it('handles Alpine state persistent notices and navigation without leaking queued instances or events', function (): void {
    $page = visit('/development/toast')->click('#alpine-toast-trigger')->assertPresent('#alpine-toast-panel')
        ->click('#alpine-toast-panel [data-sir-toast-close]')->assertMissing('#alpine-toast-panel')
        ->click('#alpine-toast-trigger')->assertPresent('#alpine-toast-panel');
    $page->script('document.dispatchEvent(new CustomEvent("toast:hide", { detail: { id: "alpine-toast" } })); document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "persistent-toast" } }));');
    $page->script('new Promise(resolve => setTimeout(resolve, 1200))');
    $page->assertPresent('#persistent-toast-panel');
    $page->script('for (let i = 1; i <= 5; i++) document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: `queued-toast-${i}` } }));');
    $page->click('#toast-navigation')->assertPathIs('/blade-components/toast')->assertMissing('[data-sir-toast-panel]:popover-open');
    $page->script('window.toastEvents = 0; document.addEventListener("toast:open", () => window.toastEvents++);');
    $page->click('[data-sir-toast-open="draft-toast"]')->assertPresent('#draft-toast-panel')->assertScript('window.toastEvents', 1)
        ->assertNoJavaScriptErrors();
});

it('positions notifications within the mobile viewport in both directions and themes with reduced motion', function (): void {
    $page = visit('/blade-components/toast', ['reducedMotion' => 'reduce'])->resize(390, 750);
    foreach (['ltr', 'rtl'] as $direction) {
        foreach ([false, true] as $dark) {
            $page->script('document.documentElement.dir = "' . $direction . '"; document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ');');
            foreach (['top-start', 'top-center', 'top-end', 'bottom-start', 'bottom-center', 'bottom-end'] as $position) {
                $id = 'position-toast-' . $position;
                $page->click('[data-sir-toast-open="' . $id . '"]')->assertPresent('#' . $id . '-panel');
                $page->assertScript('getComputedStyle(document.querySelector("#' . $id . '-panel")).animationName', 'none');
                $page->assertScript('(() => { const r = document.querySelector("#' . $id . '-panel").getBoundingClientRect(); return r.left >= 0 && r.right <= innerWidth && r.top >= 0 && r.bottom <= innerHeight; })()', true)
                    ->click('#' . $id . '-panel [data-sir-toast-close]')->assertMissing('#' . $id . '-panel');
            }
            if ($direction === 'ltr') {
                $page->click('[data-sir-toast-open="project-toast-primary"]')->assertPresent('#project-toast-primary-panel');
                $page->screenshot(fullPage: false, filename: $dark ? 'toast-mobile-dark' : 'toast-mobile-light');
                $page->click('#project-toast-primary-panel [data-sir-toast-close]')->assertMissing('#project-toast-primary-panel');
            }
        }
    }
    $page->assertNoJavaScriptErrors();
});

it('animates entry exit and reopening without duplicate close events or focus theft', function (): void {
    $page = visit('/development/toast', ['reducedMotion' => 'no-preference']);
    $page->script('window.toastsClosed = []; document.addEventListener("toast:close", e => window.toastsClosed.push(e.detail)); document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "missing-toast", text: "Unexpected" } })); document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "persistent-toast" } })); document.querySelector("#persistent-toast-panel").getAnimations().forEach(a => { a.pause(); a.currentTime = 80; });');
    $page->assertScript('document.querySelectorAll("[data-sir-toast-panel]:popover-open").length', 1)
        ->assertScript('(() => { const s = getComputedStyle(document.querySelector("#persistent-toast-panel")); return s.animationName === "sir-toast-in" && Number(s.opacity) > 0 && Number(s.opacity) < 1; })()', true);
    $page->script('document.querySelector("#persistent-toast-panel").getAnimations().forEach(a => a.finish()); document.dispatchEvent(new CustomEvent("toast:hide", { detail: { id: "persistent-toast" } })); window.exitStyle = getComputedStyle(document.querySelector("#persistent-toast-panel")).animationName; document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: "persistent-toast" } }));');
    $page->assertScript('window.exitStyle', 'sir-toast-out')->assertPresent('#persistent-toast-panel')
        ->assertScript('window.toastsClosed.length', 0);
    $page->click('#persistent-toast-panel [data-sir-toast-close]')->assertMissing('#persistent-toast-panel')
        ->assertScript('window.toastsClosed.length', 1)->assertNoJavaScriptErrors();
});

it('fits long stacked notices inside the viewport and ignores duplicate DOM IDs', function (): void {
    $page = visit('/development/toast', ['reducedMotion' => 'reduce'])->resize(390, 750);
    $page->script('const duplicate = document.querySelector("#queued-toast-1").cloneNode(true); document.body.append(duplicate); duplicate.dataset.open = "true"; for (let i = 1; i <= 3; i++) { const root = document.querySelector(`#queued-toast-${i}`); root.dataset.position = "top-start"; root.querySelector("p").textContent = "Long project update. ".repeat(120); document.dispatchEvent(new CustomEvent("toast:show", { detail: { id: root.id } })); }');
    $page->assertScript('document.querySelectorAll("[data-sir-toast-panel]:popover-open").length', 3)
        ->assertScript('Array.from(document.querySelectorAll("[data-sir-toast-panel]:popover-open")).every(el => { const r = el.getBoundingClientRect(); return r.top >= 0 && r.bottom <= innerHeight && r.left >= 0 && r.right <= innerWidth && el.scrollHeight > el.clientHeight; })', true)
        ->assertNoJavaScriptErrors();
});
