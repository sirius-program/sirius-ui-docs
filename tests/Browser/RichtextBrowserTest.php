<?php

declare(strict_types=1);

it('edits formats and synchronizes independent richtexts through Livewire updates and remounts', function (): void {
    $page = visit('/blade-components/richtext')->assertPresent('#announcement-richtext');
    $form = '[data-richtext-example]';
    $page->click($form . ' button:has-text("Submit / Validate")')->assertAttribute('#announcement-richtext', 'aria-invalid', 'true');
    $page->type('#announcement-richtext', 'Release notes')->type('#signature-richtext', 'Alex');
    $page->click($form . ' button:has-text("Toggle Readonly")')->assertAttribute('#announcement-richtext', 'contenteditable', 'false')->assertSeeIn('#announcement-richtext', 'Release notes')->assertSeeIn('#signature-richtext', 'Alex');
    $page->assertMissing($form . ' [data-richtext-command]');
    $page->click($form . ' button:has-text("Toggle Readonly")')->assertAttribute('#announcement-richtext', 'contenteditable', 'true');
    $page->assertPresent($form . ' [data-richtext-command="image"]')->assertPresent($form . ' [data-richtext-command="link"]');
    $page->click($form . ' button:has-text("Submit / Validate")')->assertSeeIn('[data-richtext-preview]', 'Release notes');
    $page->click($form . ' button:has-text("Load Value")')->assertSeeIn('#announcement-richtext strong', 'Friday')->assertSeeIn('#signature-richtext', 'Alex — Design team');
    $page->click('label[for="announcement"]')->screenshot(filename: 'richtext-ui-desktop');
    expect($page->script('document.querySelectorAll(".tiptap").length'))->toBe(4);
    $page->script('Livewire.find(document.querySelector("[data-richtext-example]").getAttribute("wire:id")).$set("visible", false)');
    $page->assertMissing('#announcement-richtext');
    $page->script('Livewire.find(document.querySelector("[data-richtext-example]").getAttribute("wire:id")).$set("visible", true)');
    $page->assertSeeIn('#announcement-richtext', 'Design review');
    expect($page->script('document.querySelectorAll(".tiptap").length'))->toBe(4);
    $page->click($form . ' button:has-text("Reset Sample")')->assertValue('#announcement', '')->assertValue('#signature', '')->assertNoJavaScriptErrors();
});

it('submits Blade HTML with formatting and handles safe link editing and native reset', function (): void {
    $page = visit('/blade-components/richtext')->assertPresent('#blade-announcement-richtext');
    $shell = '[data-richtext-blade] [data-sir-richtext]:has(#blade-announcement)';
    $page->click($shell . ' [data-richtext-command="bold"]')->type('#blade-announcement-richtext', 'Weekly update');
    $page->assertPresent('#blade-announcement-richtext strong');
    $page->script('document.querySelector("#blade-announcement-richtext").focus(); document.execCommand("selectAll", false, null)');
    $page->click($shell . ' [data-richtext-command="link"]')->type($shell . ' input[type="url"]', 'javascript:alert(1)')->click($shell . ' button[aria-label="Apply"]')->assertSeeIn($shell . ' .tiptap-popover [role="status"]', 'Use an https');
    $page->type($shell . ' input[type="url"]', 'https://example.com')->click($shell . ' button[aria-label="Apply"]')->assertAttribute('#blade-announcement-richtext a', 'href', 'https://example.com');
    expect($page->script('new FormData(document.querySelector("[data-richtext-blade]")).get("body")'))->toContain('<strong>', 'https://example.com');
    $page->click('[data-richtext-blade] button:has-text("Submit / Validate")')->assertSeeIn('[data-richtext-blade-preview]', 'Weekly update')->assertAttribute('#blade-announcement', 'hidden', '');
    $page->script('document.querySelector("[data-richtext-blade]").reset()');
    $page->assertSeeIn('#blade-announcement-richtext', 'Weekly update')->assertNoJavaScriptErrors();
});

it('supports native form validity reset disabled fields and external form association without Livewire', function (): void {
    $page = visit('/development/richtext')->assertPresent('#native-richtext-richtext');
    expect($page->script('typeof window.Livewire'))->toBe('undefined');
    expect($page->script('Object.fromEntries(new FormData(document.querySelector("form")))'))->toBe(['body' => '<p>Initial note</p>', 'readonly' => '<p>Locked</p>', 'external' => '<p>External</p>']);
    $page->type('#native-richtext-richtext', 'Changed')->type('#external-richtext-richtext', 'Changed external')->click('Native reset')->assertSeeIn('#native-richtext-richtext', 'Initial note')->assertSeeIn('#external-richtext-richtext', 'External');
    $page->type('#native-richtext-richtext', '')->assertValue('#native-richtext', '');
    expect($page->script('document.querySelector("form").checkValidity()'))->toBeFalse();
    expect($page->script('document.activeElement.id'))->toBe('native-richtext-richtext');
    $page->type('#native-richtext-richtext', 'Text exceeding twenty characters');
    expect($page->script('document.querySelector("form").checkValidity()'))->toBeFalse();
    $page->script('const source = document.querySelector("#native-richtext"); source.value = "<p>Server value</p>"; source.dispatchEvent(new Event("change", {bubbles:true}))');
    $page->assertSeeIn('#native-richtext-richtext', 'Server value');
    expect($page->script('document.querySelector("form").checkValidity()'))->toBeTrue();
    $page->assertAttribute('#disabled-richtext-richtext', 'contenteditable', 'false')->assertAttribute('#readonly-richtext-richtext', 'contenteditable', 'false')->assertNoJavaScriptErrors();
});

it('binds Alpine HTML and restores richtexts after navigation without duplicate instances', function (): void {
    $page = visit('/development/richtext-bindings')->assertSeeIn('#alpine-richtext-richtext', 'Initial note');
    $page->type('#alpine-richtext-richtext', 'Alpine update')->assertSeeIn('[data-alpine-richtext]', '<p>Alpine update</p>')->click('Load Alpine value')->assertSeeIn('#alpine-richtext-richtext', 'Updated from Alpine');
    $page->click('Toggle Alpine readonly')->assertAttribute('#alpine-richtext-richtext', 'contenteditable', 'false')->click('Toggle Alpine readonly')->assertAttribute('#alpine-richtext-richtext', 'contenteditable', 'true');
    $page->click('Form Control')->click('Richtext')->assertPresent('#announcement-richtext')->click('Input')->assertMissing('#announcement-richtext')->click('Richtext')->assertPresent('#announcement-richtext');
    expect($page->script('document.querySelectorAll(".tiptap").length'))->toBe(4);
    $page->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        $page->screenshot(fullPage: true, filename: $dark ? 'richtext-mobile-dark' : 'richtext-mobile-light');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
    }
    $page->assertNoJavaScriptErrors();
});

it('uploads real images from Blade and Livewire richtexts and includes safe image HTML in submissions', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/richtext', $url));
        foreach (['announcement', 'blade-announcement'] as $id) {
            $root = '[data-sir-richtext]:has(#' . $id . ')';
            $page->attach($root . ' input[type="file"]', public_path('sample/sample.jpg'))->assertSeeIn($root . ' .sir-richtext-upload-status', 'Image uploaded.')->assertPresent('#' . $id . '-richtext img');
            expect($page->script('document.querySelector("#' . $id . '-richtext img").src'))->toContain('/blade-components/richtext-images/');
        }
        $page->type('#signature-richtext', 'Image author');
        $page->click('[data-richtext-example] button:has-text("Submit / Validate")')->assertPresent('[data-richtext-preview] img');
        $page->click('[data-richtext-blade] button:has-text("Submit / Validate")')->assertPresent('[data-richtext-blade-preview] img')->assertNoJavaScriptErrors();
    });
});

it('rejects disallowed images retries failures and cancels pending requests on reset', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/richtext', $url));
        $root = '[data-sir-richtext]:has(#blade-announcement)';
        $page->attach($root . ' input[type="file"]', dirname(__DIR__) . '/Fixtures/proof.txt')->assertSeeIn($root . ' .sir-richtext-upload-status', 'Choose an allowed image');
        $page->script('(() => { if (window.richtextUploadIntercept) return true; window.richtextUploadIntercept = true; window.richtextUploadMode="fail"; const original=XMLHttpRequest.prototype.send; const open=XMLHttpRequest.prototype.open; XMLHttpRequest.prototype.open=function(method,url,...rest){this.richtextUpload=String(url).includes("richtext-images");return open.call(this,method,url,...rest)}; XMLHttpRequest.prototype.send=function(body){if(this.richtextUpload && window.richtextUploadMode==="fail"){setTimeout(()=>this.dispatchEvent(new Event("error")));return;} if(this.richtextUpload && window.richtextUploadMode==="hold") return;return original.call(this,body)}; return true; })()');
        $page->attach($root . ' input[type="file"]', public_path('sample/sample.jpg'))->assertSeeIn($root . ' .sir-richtext-upload-status', 'Image upload failed');
        $page->script('window.richtextUploadMode="normal"');
        $page->attach($root . ' input[type="file"]', public_path('sample/sample.jpg'))->assertSeeIn($root . ' .sir-richtext-upload-status', 'Image uploaded.');
        $page->script('window.richtextUploadMode="hold"');
        $page->attach($root . ' input[type="file"]', public_path('sample/sample.jpg'))->click('[data-richtext-blade] button:has-text("Submit / Validate")')->assertSeeIn($root . ' .sir-richtext-upload-status', 'Wait for the image upload');
        $page->script('document.querySelector("[data-richtext-blade]").reset()');
        $page->assertValue('#blade-announcement', '')->assertEnabled($root . ' [data-richtext-command="image"]')->assertNoJavaScriptErrors();
        $liveRoot = '[data-richtext-example] [data-sir-richtext]:has(#announcement)';
        $page->attach($liveRoot . ' input[type="file"]', public_path('sample/sample.jpg'))->assertSeeIn($liveRoot . ' .sir-richtext-upload-status', 'Uploading image');
        $page->click('[data-richtext-example] button:has-text("Reset Sample")')->assertEnabled($liveRoot . ' [data-richtext-command="image"]')->assertMissing('#announcement-richtext img')->assertNoJavaScriptErrors();
    });
});
