<?php

declare(strict_types=1);

it('submits native GET search without sending tokens and loads or resets samples', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-search [name=query]', 'Website')->click('#form-search button[value=validate]')->assertSeeIn('[data-form-search]', 'Search: Website');
        expect($page->script('new URL(location.href).searchParams.has("_token")'))->toBeFalse();
        $page->click('#form-search button[value=load]')->assertValue('#form-search [name=query]', 'Website redesign');
        $page->click('#form-search button[value=reset]')->assertValue('#form-search [name=query]', '')->assertNoJavaScriptErrors();
    });
});

it('submits canonical currency with POST and restores validation errors and old input', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-create [name="project[title]"]', 'Website')->click('#form-create button[value=validate]');
        $page->assertValue('#form-create [name="project[title]"]', 'Website')->assertPresent('#form-create [aria-invalid=true]');
        $page->assertNotPresent('#form-rename [aria-invalid=true]');
        $page->assertEnabled('#form-create [data-sir-currency-value]');
        $page->fill('#form-create [data-sir-currency-display]', '1250.50');
        expect($page->script('new FormData(document.querySelector("#form-create")).get("project[budget]")'))->toBe('1250.50');
        $page->click('#form-create button[value=validate]')->assertSeeIn('[data-form-result]', 'POST: Website')->assertSeeIn('[data-form-result]', '1250.50');
        $page->click('#form-create button[value=load]')->assertValue('#form-create [name="project[title]"]', 'Website redesign');
        $page->click('#form-create button[value=reset]')->assertValue('#form-create [name="project[title]"]', '')->assertNoJavaScriptErrors();
    });
});

it('routes native spoofed update and delete requests to CRUD actions', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-replace [name="replace[title]"]', 'Full update')->click('#form-replace button[value=validate]')->assertSeeIn('[data-form-result]', 'PUT: Full update');
        $page->fill('#form-rename [name="rename[title]"]', 'New name')->click('#form-rename button[value=validate]')->assertSeeIn('[data-form-result]', 'PATCH: New name');
        $page->check('#form-archive [name="archive[confirmed]"]')->click('#form-archive button[value=validate]')->assertSeeIn('[data-form-result]', 'DELETE: Demo draft archived.')->assertNoJavaScriptErrors();
    });
});

it('posts a real multipart file through the form component', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit(str_replace('/file-upload', '/form', $url));
        $page->fill('#form-upload [name="upload[title]"]', 'Project brief')->attach('#form-attachment-browse', dirname(__DIR__) . '/Fixtures/proof.txt')->assertSeeIn('#form-upload .filepond--file-info-main', 'proof.txt');
        expect($page->script('new FormData(document.querySelector("#form-upload")).get("attachment").name'))->toBe('proof.txt');
        $page->click('#form-upload button[value=validate]')->assertSeeIn('[data-form-result]', 'POST: proof.txt')->assertSeeIn('[data-form-result]', 'bytes) validated.')->assertNoJavaScriptErrors();
    });
});
