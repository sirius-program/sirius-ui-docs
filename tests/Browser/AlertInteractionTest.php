<?php

declare(strict_types=1);

it('fades and bounces the alert while keeping focus and scroll locked until exit completes', function (): void {
    $page = visit('/blade-components/alert');
    $page->script('document.querySelector("[data-sir-dialog-open=alert-variant-success]").focus(); document.dispatchEvent(new CustomEvent("dialog:show", { detail: { id: "alert-variant-success" } })); document.querySelector("#alert-variant-success").getAnimations().forEach(a => { a.pause(); a.currentTime = 70; })');
    $page->assertScript('(() => { const s = getComputedStyle(document.querySelector("#alert-variant-success")); return s.animationName === "sir-alert-in" && s.transform !== "none" && Number(s.opacity) > 0 && Number(s.opacity) < 1; })()', true);
    $page->script('document.querySelector("#alert-variant-success").getAnimations().forEach(a => a.currentTime = 168)');
    $page->assertScript('new DOMMatrixReadOnly(getComputedStyle(document.querySelector("#alert-variant-success")).transform).a > 1', true);
    $page->script('document.querySelector("#alert-variant-success").getAnimations().forEach(a => a.finish()); document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "alert-variant-success" } })); document.querySelector("#alert-variant-success").getAnimations().forEach(a => { a.pause(); a.currentTime = 120; })');
    $page->assertPresent('#alert-variant-success:modal')->assertScript('getComputedStyle(document.documentElement).overflow', 'hidden');
    $page->assertScript('(() => { const s = getComputedStyle(document.querySelector("#alert-variant-success")); return s.animationName === "sir-alert-out" && s.transform !== "none" && Number(s.opacity) > 0 && Number(s.opacity) < 1; })()', true);
    $page->script('document.querySelector("#alert-variant-success").getAnimations().forEach(a => a.finish())');
    $page->assertMissing('#alert-variant-success')->assertScript('document.documentElement.style.overflow', '')
        ->assertScript('document.activeElement.getAttribute("data-sir-dialog-open")', 'alert-variant-success')->assertNoJavaScriptErrors();
});

it('opens every alert variant in both themes and preserves its footer actions', function (): void {
    $page = visit('/blade-components/alert');
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        foreach (['primary', 'info', 'success', 'danger', 'warning', 'secondary', 'ghost', 'outline'] as $variant) {
            $root = '#alert-variant-' . $variant;
            $page->click('[data-sir-dialog-open="alert-variant-' . $variant . '"]')
                ->assertPresent($root . ':modal')->assertSeeIn($root . ' .sir-alert-title', 'Settings updated')
                ->assertSeeIn($root . ' .sir-alert-text', 'Your project settings have been updated.');
            $page->assertScript('document.querySelector("' . $root . '").classList.contains("sir-tone--' . $variant . '")', true);
            $page->click($root . ' [data-sir-dialog-close]')->assertMissing($root);
        }
    }
    $page->assertNoJavaScriptErrors();
});

it('disables alert motion and closes synchronously for reduced motion', function (): void {
    $page = visit('/blade-components/alert', ['reducedMotion' => 'reduce'])->click('[data-sir-dialog-open="alert-variant-success"]');
    $page->assertScript('getComputedStyle(document.querySelector("#alert-variant-success")).animationName', 'none');
    $page->script('document.dispatchEvent(new CustomEvent("dialog:hide", { detail: { id: "alert-variant-success" } })); window.alertClosedImmediately = !document.querySelector("#alert-variant-success").open');
    $page->assertScript('window.alertClosedImmediately', true)->assertScript('document.documentElement.style.overflow', '')->assertNoJavaScriptErrors();
});
