<?php

declare(strict_types=1);

it('submits native GET search without sending tokens and loads or resets samples', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-search [name=query]', 'Website');
        // Native navigation must use one click; Pest's short click timeout can replay a submission.
        $page->page()->locator('#form-search button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertSeeIn('[data-form-search]', 'Search: Website');
        expect($page->script('new URL(location.href).searchParams.has("_token")'))->toBeFalse();
        $page->page()->locator('#form-search button[value="load"]')->click(['timeout' => 10000]);
        $page->assertValue('#form-search [name=query]', 'Website redesign');
        $page->page()->locator('#form-search button[value="reset"]')->click(['timeout' => 10000]);
        $page->assertValue('#form-search [name=query]', '')->assertNoJavaScriptErrors();
    });
});

it('submits canonical currency with POST and restores validation errors and old input', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-create [name="project[title]"]', 'Website');
        $page->page()->locator('#form-create button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertValue('#form-create [name="project[title]"]', 'Website')->assertPresent('#form-create [aria-invalid=true]');
        $page->assertNotPresent('#form-rename [aria-invalid=true]');
        $page->assertEnabled('#form-create [data-sir-currency-value]');
        $page->fill('#form-create [data-sir-currency-display]', '1250.50');
        expect($page->script('new FormData(document.querySelector("#form-create")).get("project[budget]")'))->toBe('1250.50');
        $page->page()->locator('#form-create button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertSeeIn('[data-form-result]', 'POST: Website')->assertSeeIn('[data-form-result]', '1250.50');
        $page->page()->locator('#form-create button[value="load"]')->click(['timeout' => 10000]);
        $page->assertValue('#form-create [name="project[title]"]', 'Website redesign');
        $page->page()->locator('#form-create button[value="reset"]')->click(['timeout' => 10000]);
        $page->assertValue('#form-create [name="project[title]"]', '')->assertNoJavaScriptErrors();
    });
});

it('routes native spoofed update and delete requests to CRUD actions', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-replace [name="replace[title]"]', 'Full update');
        $page->page()->locator('#form-replace button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertSeeIn('[data-form-result]', 'PUT: Full update');
        $page->fill('#form-rename [name="rename[title]"]', 'New name');
        $page->page()->locator('#form-rename button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertSeeIn('[data-form-result]', 'PATCH: New name');
        $page->check('#form-archive [name="archive[confirmed]"]');
        $page->page()->locator('#form-archive button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertSeeIn('[data-form-result]', 'DELETE: Demo draft archived.')->assertNoJavaScriptErrors();
    });
});

it('posts a real multipart file through the form component', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-upload [name="upload[title]"]', 'Project brief')->attach('#form-attachment-browse', dirname(__DIR__) . '/Fixtures/proof.txt')->assertSeeIn('#form-upload .filepond--file-info-main', 'proof.txt');
        expect($page->script('new FormData(document.querySelector("#form-upload")).get("attachment").name'))->toBe('proof.txt');
        expect($page->script('new FormData(document.querySelector("#form-upload")).get("attachment").size'))->toBe(filesize(dirname(__DIR__) . '/Fixtures/proof.txt'));
        $page->page()->locator('#form-upload button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertSeeIn('[data-form-result]', 'POST: proof.txt')->assertSeeIn('[data-form-result]', 'bytes) validated.')->assertNoJavaScriptErrors();
    });
});
