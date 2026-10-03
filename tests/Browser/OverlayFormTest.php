<?php

declare(strict_types=1);

it('edits and submits all kinds of package controls inside a project overlay', function (string $component, string $mode): void {
    withUploadBrowser(function (string $url) use ($component, $mode): void {
        $prefix = ($mode === 'Livewire' ? '' : 'blade-') . $component . '-form';
        $root = '#' . $prefix;
        $trigger = $mode === 'Blade' ? '[data-sir-dialog-open="' . $prefix . '"]' : '[data-' . $component . '-form="livewire"] > button';
        $scrollRoot = $root . ' .sir-dialog-body';
        $page = visit(str_replace('/file-upload', '/' . $component, $url));
        $page->click($trigger)->assertPresent($root . ':modal');
        $page->script('const source = document.querySelector("' . $root . ' [data-richtext-source]"); source.removeAttribute("hidden"); source.removeAttribute("data-richtext-enhanced")');
        $page->assertMissing($root . '-brief')->assertPresent($root . '-brief-richtext');
        $page->script('const d = document.querySelector("' . $root . '"); const spacer = document.createElement("div"); spacer.dataset.dialogLayerSpacer = ""; spacer.style.height = "1000px"; d.querySelector(".sir-dialog-body").append(spacer); const leading = spacer.cloneNode(); leading.style.height = "400px"; d.querySelector("[data-sir-richtext]").before(leading)');
        foreach ([false, true] as $dark) {
            $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
            foreach (['.sir-dialog-heading', '.sir-dialog-footer'] as $section) {
                $page->script('const d = document.querySelector("' . $root . '"); const t = d.querySelector(".tiptap-toolbar").getBoundingClientRect(); const s = d.querySelector("' . $section . '").getBoundingClientRect(); document.querySelector("' . $scrollRoot . '").scrollTop += t.top + t.height / 2 - s.top - 10');
                $page->assertScript('(() => { const d = document.querySelector("' . $root . '"); const s = d.querySelector("' . $section . '"); const t = d.querySelector(".tiptap-toolbar").getBoundingClientRect(); const r = s.getBoundingClientRect(); const y = r.top + 10; return t.top <= y && t.bottom >= y && s.contains(document.elementFromPoint(t.left + 20, y)); })()', true);
            }
        }
        $page->script('document.querySelectorAll("' . $root . ' [data-dialog-layer-spacer]").forEach(el => el.remove()); document.querySelector("' . $scrollRoot . '").scrollTop = 0; document.documentElement.classList.remove("dark")');
        $page->screenshot(fullPage: false, filename: $component . '-fields-' . strtolower($mode));
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
        $page->script('document.querySelector("' . $scrollRoot . '").scrollTop = 0; document.documentElement.classList.add("dark")');
        $page->screenshot(fullPage: false, filename: $component . '-form-' . strtolower($mode) . '-mobile');
        if ($mode === 'Livewire') {
            $page->click($root . ' button:has-text("Toggle Readonly")')->assertAttribute($root . '-brief-richtext', 'contenteditable', 'false')
                ->assertAttribute($root . '-discount-handle', 'aria-readonly', 'true')->assertScript('document.querySelector("' . $root . '-title").readOnly', true);
        }
        $page->click($root . ' button:has-text("Reset Sample")')->assertValue($root . '-title', '')
            ->click($root . ' .sir-dialog-footer [data-sir-dialog-close]')->assertMissing($root)->assertNoJavaScriptErrors();
    });
})->with([['dialog', 'Livewire'], ['dialog', 'Blade'], ['slideover', 'Livewire'], ['slideover', 'Blade']]);

it('anchors datetime pickers to their fields while scrolling and resizing an overlay', function (string $component, string $mode): void {
    withUploadBrowser(function (string $url) use ($component, $mode): void {
        $prefix = ($mode === 'Livewire' ? '' : 'blade-') . $component . '-form';
        $root = '#' . $prefix;
        $trigger = $mode === 'Blade' ? '[data-sir-dialog-open="' . $prefix . '"]' : '[data-' . $component . '-form="livewire"] > button';
        $scrollRoot = $root . ' .sir-dialog-body';
        $page = visit(str_replace('/file-upload', '/' . $component, $url))->resize(1280, 900)
            ->click($trigger);
        foreach (['date', 'time', 'appointment'] as $field) {
            $page->click($root . '-' . $field)->assertPresent($root . ' .flatpickr-calendar.open');
            $page->assertScript('getComputedStyle(document.querySelector("' . $root . ' .flatpickr-calendar.open")).position', 'fixed');
            foreach ([0, 30] as $offset) {
                $page->script('document.querySelector("' . $scrollRoot . '").scrollTop += ' . $offset);
                $page->assertScript('(() => { const i = document.querySelector("' . $root . '-' . $field . '").getBoundingClientRect(); const c = document.querySelector("' . $root . ' .flatpickr-calendar.open").getBoundingClientRect(); return Math.abs(c.left - i.left) < 1 && (Math.abs(c.top - i.bottom - 2) < 1 || Math.abs(c.bottom - i.top + 2) < 1); })()', true);
            }
            $page->keys($root . '-' . $field, 'Escape');
        }
        $page->resize(1100, 760)->click($root . '-date');
        $page->assertScript('(() => { const i = document.querySelector("' . $root . '-date").getBoundingClientRect(); const c = document.querySelector("' . $root . ' .flatpickr-calendar.open").getBoundingClientRect(); return Math.abs(c.left - i.left) < 1 && (Math.abs(c.top - i.bottom - 2) < 1 || Math.abs(c.bottom - i.top + 2) < 1); })()', true)->assertNoJavaScriptErrors();
    });
})->with([['dialog', 'Livewire'], ['dialog', 'Blade'], ['slideover', 'Livewire'], ['slideover', 'Blade']]);
