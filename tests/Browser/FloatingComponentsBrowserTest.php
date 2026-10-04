<?php

declare(strict_types=1);

it('shows tooltip text by hover and focus with persistent ARIA associations and Escape dismissal', function (): void {
    $page = visit('/blade-components/tooltip');
    $page->page()->locator('#project-help-primary-trigger')->hover();
    $page->assertPresent('#project-help-primary-content:popover-open')
        ->assertAttribute('#project-help-primary-trigger', 'aria-describedby', 'project-help-primary-content');
    $page->page()->locator('#project-help-primary-content')->hover();
    $page->assertPresent('#project-help-primary-content:popover-open');
    $page->keys('#project-help-primary-trigger', 'Escape')->assertMissing('#project-help-primary-content');
    $page->script('document.querySelector("#download-help-trigger").focus()');
    $page->assertPresent('#download-help-content:popover-open')
        ->assertAttribute('#download-help-trigger', 'aria-label', 'Download project brief')
        ->keys('#download-help-trigger', 'Escape')->assertMissing('#download-help-content')->assertNoJavaScriptErrors();
});

it('opens interactive popovers from the keyboard and returns focus after applying a filter', function (): void {
    $page = visit('/blade-components/popover')->keys('#project-filter-trigger', 'Enter');
    $page->assertPresent('#project-filter-content:popover-open')->assertScript('document.activeElement.id', 'include-archived')
        ->assertAttribute('#project-filter-trigger', 'aria-controls', 'project-filter-content')
        ->assertAttribute('#project-filter-trigger', 'aria-expanded', 'true')
        ->check('#include-archived')->click('#apply-project-filter')
        ->assertMissing('#project-filter-content')->assertSee('Showing active and archived projects.')
        ->assertScript('document.activeElement.id', 'project-filter-trigger')
        ->keys('#project-filter-trigger', 'Space')->assertPresent('#project-filter-content:popover-open')
        ->keys('#include-archived', 'Escape')->assertMissing('#project-filter-content')
        ->assertScript('document.activeElement.id', 'project-filter-trigger')->assertNoJavaScriptErrors();
});

it('closes replaced popovers and allows normal Tab navigation outside the panel', function (): void {
    $page = visit('/blade-components/popover')->click('#project-sharing-info-trigger')->click('#project-sharing-primary-trigger');
    $page->assertMissing('#project-sharing-info-content')->assertPresent('#project-sharing-primary-content:popover-open')
        ->keys('#project-sharing-primary-content button', 'Tab')
        ->assertMissing('#project-sharing-primary-content')->assertScript('document.activeElement.id', 'project-sharing-secondary-trigger')
        ->click('#project-filter-trigger')->click('#project-filter + p')->assertMissing('#project-filter-content')->assertNoJavaScriptErrors();
});

it('keeps floating panels inside viewport edges and removes fades for reduced motion', function (string $component): void {
    $page = visit('/blade-components/' . $component, ['reducedMotion' => 'reduce'])->resize(390, 600);
    $id = $component === 'tooltip' ? 'project-help-primary' : 'project-sharing-primary';
    $page->script('document.documentElement.dir = "rtl"; document.querySelector("#' . $id . '").style.cssText = "position:fixed;right:8px;bottom:8px;z-index:50"; document.querySelector("#' . $id . '-trigger").focus()');
    if ($component === 'popover') {
        $page->click('#' . $id . '-trigger');
    }
    $page->assertPresent('#' . $id . '-content:popover-open')->assertScript('getComputedStyle(document.querySelector("#' . $id . '-content")).animationName', 'none')
        ->assertScript('(() => { const r = document.querySelector("#' . $id . '-content").getBoundingClientRect(); return r.left >= 7 && r.right <= innerWidth - 7 && r.top >= 7 && r.bottom <= innerHeight - 7; })()', true)
        ->assertAttribute('#' . $id . '-content', 'data-resolved-placement', 'top')
        ->assertNoJavaScriptErrors();
})->with(['tooltip', 'popover']);

it('retains trigger actions and open panels through unrelated Livewire morphs', function (): void {
    $page = visit('/development/overlays')->click('#livewire-sharing-trigger');
    $page->assertSeeIn('#floating-count', 'Count: 1')->assertSeeIn('#floating-clicks', 'Clicks: 1')
        ->assertPresent('#livewire-sharing-content:popover-open')->fill('#floating-name', 'Alex')
        ->click('#floating-save')->assertSeeIn('#floating-panel-count', 'Count: 2')
        ->assertValue('#floating-name', 'Alex')->assertPresent('#livewire-sharing-content:popover-open');
    $page->script('Livewire.find(document.querySelector("#floating-livewire-fixture").getAttribute("wire:id")).rename()');
    $page->assertScript('document.querySelector("#livewire-hint-content").textContent.trim()', 'Access is limited to invited members.')
        ->assertPresent('#livewire-sharing-content:popover-open')->click('#floating-done')
        ->assertMissing('#livewire-sharing-content')->assertScript('document.activeElement.id', 'livewire-sharing-trigger')
        ->assertAttribute('#livewire-hint-trigger', 'aria-describedby', 'floating-count livewire-hint-content')->assertNoJavaScriptErrors();
});

it('synchronizes server open state and cleans removed instances and navigation', function (): void {
    $page = visit('/development/overlays');
    $page->click('#floating-server')
        ->assertPresent('#livewire-sharing-content:popover-open')->assertScript('document.activeElement.id', 'floating-name')
        ->click('#floating-server')->assertMissing('#livewire-sharing-content')
        ->click('#livewire-sharing-trigger')->click('#floating-visible')->assertNotPresent('#livewire-sharing')
        ->click('#floating-visible')->assertMissing('#livewire-sharing-content');
    $page->click('#livewire-sharing-trigger')->assertSeeIn('#floating-count', 'Count: 2');
    $page->script('Livewire.navigate("/blade-components/popover")');
    $page->click('#project-filter-trigger')->assertPresent('#project-filter-content:popover-open');
    $page->script('Livewire.navigate("/development/overlays")');
    $page->click('#livewire-sharing-trigger')->assertSeeIn('#floating-count', 'Count: 1')
        ->assertSeeIn('#floating-clicks', 'Clicks: 1')->assertNoJavaScriptErrors();
});

it('keeps nested floating panels above overlay scroll areas and dismisses them before the modal', function (string $overlay): void {
    $page = visit('/development/overlays')->click('#floating-' . $overlay . '-trigger')
        ->assertPresent('#floating-' . $overlay . ':modal')->click('#' . $overlay . '-sharing-trigger')
        ->assertPresent('#' . $overlay . '-sharing-content:popover-open')->assertScript('document.activeElement.id', $overlay . '-email')
        ->click('#' . $overlay . '-nested-trigger')->assertPresent('#' . $overlay . '-nested-content:popover-open')
        ->assertPresent('#' . $overlay . '-sharing-content:popover-open')
        ->keys('#' . $overlay . '-nested-done', 'Escape')->assertMissing('#' . $overlay . '-nested-content')
        ->assertPresent('#' . $overlay . '-sharing-content:popover-open')->assertScript('document.activeElement.id', $overlay . '-nested-trigger')
        ->keys('#' . $overlay . '-nested-trigger', 'Escape')->assertMissing('#' . $overlay . '-sharing-content')
        ->assertPresent('#floating-' . $overlay . ':modal')->assertScript('document.activeElement.id', $overlay . '-sharing-trigger')
        ->keys('#' . $overlay . '-sharing-trigger', 'Escape')->assertMissing('#floating-' . $overlay)->assertNoJavaScriptErrors();
})->with(['dialog', 'slideover']);

it('keeps overlay tooltip panels visible outside the body and updates their position while scrolling', function (string $overlay): void {
    $page = visit('/development/overlays')->click('#floating-' . $overlay . '-trigger');
    $page->script('document.querySelector("#' . $overlay . '-hint-trigger").focus()');
    $page->assertPresent('#' . $overlay . '-hint-content:popover-open')
        ->assertScript('(() => { const p = document.querySelector("#' . $overlay . '-hint-content"); const r = p.getBoundingClientRect(); return p.contains(document.elementFromPoint(r.left + r.width / 2, r.top + r.height / 2)); })()', true);
    $page->script('document.querySelector("#floating-' . $overlay . ' .sir-dialog-body").scrollTop = 20');
    $page->assertScript('(() => { const a = document.querySelector("#' . $overlay . '-hint-trigger").getBoundingClientRect(); const p = document.querySelector("#' . $overlay . '-hint-content").getBoundingClientRect(); return p.top >= 7 && p.bottom <= innerHeight - 7 && Math.abs((a.top + a.height / 2) - (p.top + p.height / 2)) < 2; })()', true)
        ->keys('#' . $overlay . '-hint-trigger', 'Escape')->assertMissing('#' . $overlay . '-hint-content')
        ->assertPresent('#floating-' . $overlay . ':modal')->click('#' . $overlay . '-close')
        ->assertMissing('#floating-' . $overlay)->assertNoJavaScriptErrors();
})->with(['dialog', 'slideover']);

it('renders every floating variant in both themes without mobile overflow', function (string $component): void {
    $page = visit('/blade-components/' . $component)->resize(390, 844);
    $prefix = $component === 'tooltip' ? 'project-help-' : 'project-sharing-';
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        foreach (['info', 'primary', 'secondary', 'warning', 'success', 'danger'] as $variant) {
            $page->click('#' . $prefix . $variant . '-trigger')->assertPresent('#' . $prefix . $variant . '-content:popover-open')
                ->assertScript('(() => { const r = document.querySelector("#' . $prefix . $variant . '-content").getBoundingClientRect(); return r.left >= 7 && r.right <= innerWidth - 7; })()', true);
            $page->keys('#' . $prefix . $variant . '-trigger', 'Escape');
        }
        $page->click('#' . $prefix . 'primary-trigger');
        $page->screenshot(fullPage: false, filename: $component . ($dark ? '-dark' : '-light'));
        $page->keys('#' . $prefix . 'primary-trigger', 'Escape');
    }
    $page->assertScript('document.documentElement.scrollWidth <= innerWidth', true)->assertNoJavaScriptErrors();
})->with(['tooltip', 'popover']);

it('updates an open tooltip through Livewire and stops activation for disabled triggers', function (): void {
    $page = visit('/development/overlays');
    $page->page()->locator('#livewire-hint-trigger')->hover();
    $page->assertPresent('#livewire-hint-content:popover-open');
    $page->script('Livewire.find(document.querySelector("#floating-livewire-fixture").getAttribute("wire:id")).rename()');
    $page->assertSeeIn('#livewire-hint-content', 'Access is limited to invited members.')
        ->assertAttribute('#livewire-hint-trigger', 'aria-describedby', 'floating-count livewire-hint-content');
    $page->script('document.querySelector("#livewire-hint-trigger").disabled = true');
    $page->assertMissing('#livewire-hint-content')->assertNoJavaScriptErrors();
});

it('opens by touch and releases a removed open panel without changing detached markup', function (): void {
    $page = visit('/development/overlays', ['hasTouch' => true]);
    $page->page()->locator('#livewire-sharing-trigger')->tap();
    $page->assertSeeIn('#floating-count', 'Count: 1')->assertPresent('#livewire-sharing-content:popover-open');
    $page->script('Livewire.find(document.querySelector("#floating-livewire-fixture").getAttribute("wire:id")).set("visible", false)');
    $page->assertNotPresent('#livewire-sharing')->assertNotPresent('#livewire-sharing-content:popover-open')
        ->click('#floating-visible')->assertMissing('#livewire-sharing-content')->assertNoJavaScriptErrors();
});

it('supports replacement link triggers and scrollable HTML content without a focus trap', function (): void {
    $page = visit('/blade-components/popover')->resize(390, 600);
    $page->script('(() => { const trigger = document.querySelector("#project-sharing-info-trigger"); const link = document.createElement("a"); link.id = trigger.id; link.href = "#project"; link.textContent = "Project details"; link.className = trigger.className; link.setAttribute("data-action", "details"); trigger.replaceWith(link); const content = document.querySelector("#project-sharing-info-content .sir-floating-content"); content.innerHTML = "<h3>Project details</h3>" + "<p>Only invited members can open project files.</p>".repeat(40); })()');
    $page->keys('#project-sharing-info-trigger', 'Space')->assertPresent('#project-sharing-info-content:popover-open')
        ->assertAttribute('#project-sharing-info-trigger', 'data-action', 'details')
        ->assertScript('document.activeElement.id', 'project-sharing-info-content')
        ->assertScript('(() => { const p = document.querySelector("#project-sharing-info-content"); const content = p.querySelector(".sir-floating-content"); const r = p.getBoundingClientRect(); return content.scrollHeight > content.clientHeight && r.top >= 7 && r.bottom <= innerHeight - 7; })()', true)
        ->keys('#project-sharing-info-content', 'Escape')->assertMissing('#project-sharing-info-content')
        ->assertScript('document.activeElement.id', 'project-sharing-info-trigger')->assertNoJavaScriptErrors();
});

it('points floating arrows toward the trigger on every side and after viewport clamping', function (string $component): void {
    $page = visit('/blade-components/' . $component, ['reducedMotion' => 'reduce']);
    $id = $component === 'tooltip' ? 'project-help-primary' : 'project-sharing-primary';
    $page->script('document.querySelector("#' . $id . '").style.cssText = "position:fixed;left:45%;top:45%;z-index:50"');
    $page->click('#' . $id . '-trigger')->assertPresent('#' . $id . '-content:popover-open');
    foreach (['top', 'right', 'bottom', 'left'] as $placement) {
        $page->script('document.querySelector("#' . $id . '").dataset.placement = "' . $placement . '"');
        $page->assertAttribute('#' . $id . '-content', 'data-resolved-placement', $placement)
            ->assertScript('(() => { const p = document.querySelector("#' . $id . '-content"); const a = document.querySelector("#' . $id . '-trigger").getBoundingClientRect(); const r = p.getBoundingClientRect(); const arrow = getComputedStyle(p, "::before"); const vertical = ["top", "bottom"].includes(p.dataset.resolvedPlacement); const center = vertical ? r.left + p.clientLeft + parseFloat(arrow.left) : r.top + p.clientTop + parseFloat(arrow.top); const target = vertical ? a.left + a.width / 2 : a.top + a.height / 2; const side = p.dataset.resolvedPlacement; return Math.abs(center - target) < 2 && arrow.getPropertyValue("border-" + side + "-color") === getComputedStyle(p).borderTopColor && getComputedStyle(p).overflow === "visible"; })()', true);
    }
    $page->resize(390, 600);
    $page->script('document.querySelector("#' . $id . '").style.cssText = "position:fixed;right:8px;bottom:8px;z-index:50"; document.querySelector("#' . $id . '").dataset.placement = "bottom"');
    $page->assertAttribute('#' . $id . '-content', 'data-resolved-placement', 'top')
        ->assertScript('(() => { const p = document.querySelector("#' . $id . '-content"); const arrow = getComputedStyle(p, "::before"); const offset = parseFloat(arrow.left); const a = document.querySelector("#' . $id . '-trigger").getBoundingClientRect(); const r = p.getBoundingClientRect(); return offset >= 14 && offset <= p.clientWidth - 14 && offset > p.clientWidth / 2 && Math.abs(r.left + p.clientLeft + offset - (a.left + a.width / 2)) < 16; })()', true)
        ->screenshot(fullPage: false, filename: $component . '-arrow-edge')
        ->assertNoJavaScriptErrors();
})->with(['tooltip', 'popover']);
