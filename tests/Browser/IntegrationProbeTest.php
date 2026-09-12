<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

it('synchronizes widgets with Livewire through reset and remount', function (): void {
    $page = visit('/development/integrations')
        ->assertAttribute('div:has(> #probe-date)', 'data-ready', 'true')
        ->assertPresent('.tiptap')
        ->assertPresent('.ts-control');

    $page->script('document.querySelector("#probe-date")._flatpickr.setDate("2026-09-20", true)');
    $page->assertSeeIn('#server-date', '2026-09-20');

    $page->script('document.querySelector("#probe-choice").tomselect.setValue("beta")');
    $page->assertSeeIn('#server-choice', 'beta')
        ->type('.tiptap', 'Browser content')
        ->assertSeeIn('#server-html', 'Browser content')
        ->click('Reset from server')
        ->assertValue('#probe-date', '2026-10-01')
        ->assertSeeIn('.tiptap', 'Server reset')
        ->click('Toggle widgets')
        ->assertMissing('#probe-date')
        ->click('Toggle widgets')
        ->assertValue('#probe-date', '2026-10-01')
        ->assertSeeIn('.tiptap', 'Server reset')
        ->assertNoJavaScriptErrors();
});

it('submits ordinary Blade values and survives Livewire navigation', function (): void {
    visit('/development/plain-blade')
        ->assertAttribute('div:has(> #date-first)', 'data-ready', 'true')
        ->assertPresent('.tiptap')
        ->click('Inspect form values')
        ->assertSeeIn('#form-values', '2026-09-12')
        ->assertSeeIn('#form-values', 'alpha')
        ->assertSeeIn('#form-values', 'Initial content')
        ->click('Integration proofs')
        ->assertPresent('#probe-date')
        ->assertPresent('.tiptap')
        ->click('Plain Blade proof')
        ->assertPresent('#date-second')
        ->assertPresent('.tiptap')
        ->assertNoJavaScriptErrors();
});

it('uploads through the FilePond bridge and clears the selection on server reset', function (): void {
    $socket = stream_socket_server('tcp://127.0.0.1:0');
    expect($socket)->not->toBeFalse();
    $address = stream_socket_get_name($socket, false);
    fclose($socket);
    $uploadRoot = storage_path('framework/testing/uploads/' . str_replace(':', '-', $address));
    $server = new Process([
        PHP_BINARY, '-S', $address,
        base_path('vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php'),
    ], public_path(), [
        'APP_ENV'                 => 'local',
        'APP_KEY'                 => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',
        'APP_URL'                 => 'http://' . $address,
        'SESSION_DRIVER'          => 'file',
        'CACHE_STORE'             => 'array',
        'FILESYSTEM_DISK'         => 'browser-uploads',
        'SIRIUS_TEST_UPLOAD_ROOT' => $uploadRoot,
    ]);

    try {
        $server->start();
        $server->waitUntil(fn (string $type, string $output): bool => str_contains($output, 'Development Server'));

        visit('http://' . $address . '/development/integrations')
            ->assertAttribute('[x-data^="integrationUpload"]', 'data-ready', 'true')
            ->attach('.filepond--browser', __DIR__ . '/../Fixtures/proof.txt')
            ->assertSeeIn('#server-upload', 'proof.txt')
            ->click('Validate and sanitize')
            ->assertSeeIn('#sanitized-output', 'Initial content')
            ->click('Reset from server')
            ->assertSeeIn('#server-upload', 'No upload')
            ->assertMissing('.filepond--item')
            ->assertNoJavaScriptErrors();
    } finally {
        $server->stop();
        File::deleteDirectory($uploadRoot);
    }
});
