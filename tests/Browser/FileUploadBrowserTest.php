<?php

declare(strict_types=1);
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

it('submits actual files through an ordinary Blade multipart form and removes selected files', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit($url);
        $page->attach('#blade-upload-brief-browse', dirname(__DIR__) . '/Fixtures/proof.txt')
            ->assertSeeIn('[data-blade-upload] .filepond--file-info-main', 'proof.txt');
        expect($page->script('new FormData(document.querySelector("[data-blade-upload]")).get("brief").name'))->toBe('proof.txt');
        $page->page()->locator('[data-blade-upload] button[value="validate"]')->click(['timeout' => 10000]);
        $page->assertSee('Project documents validated. Nothing was stored.');
        $page->attach('#blade-upload-brief-browse', dirname(__DIR__) . '/Fixtures/proof.txt')
            ->assertSeeIn('[data-blade-upload] .filepond--file-info-main', 'proof.txt')
            ->click('[data-sir-file-upload]:has(#blade-upload-brief) .filepond--action-remove-item');
        $page->assertMissing('[data-sir-file-upload]:has(#blade-upload-brief) .filepond--item');
        expect($page->script('document.querySelector("#blade-upload-brief").files.length'))->toBe(0);
        $page->assertNoJavaScriptErrors();
    });
});

it('uploads once survives livewire validation and respects readonly and reset', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit($url);
        $page->script('window.uploadStarts = 0; document.addEventListener("file-upload:start", () => window.uploadStarts++);');
        $page->attach('[data-upload-example] [data-sir-file-upload]:has([name=brief]) .filepond--browser', dirname(__DIR__) . '/Fixtures/proof.txt')
            ->assertSeeIn('[data-upload-example] .filepond--file-status-main', 'Upload complete');
        expect($page->script('window.uploadStarts'))->toBe(1);
        $page->assertScript('getComputedStyle(document.querySelector("[data-upload-example] [data-upload-source]")).display', 'none');
        $page->click('[data-upload-example] button:has-text("Submit / Validate")')->assertSee('Project documents validated. Nothing was stored.')
            ->click('[data-upload-example] button:has-text("Toggle Readonly")');
        $page->assertDisabled('[data-upload-example] [data-sir-file-upload]:has([name=brief]) .filepond--browser');
        $page->click('[data-upload-example] button:has-text("Reset Sample")')->assertMissing('[data-upload-example] .filepond--item');
        $page->assertNoJavaScriptErrors();
    });
});

it('rejects type size and count limits without posting disallowed files', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit($url);
        $page->script('const input = document.querySelector("#blade-upload-brief-browse"); const files = new DataTransfer(); files.items.add(new File(["bad"], "script.html", {type:"text/html"})); input.files = files.files; input.dispatchEvent(new Event("change", {bubbles:true}));');
        $page->assertSeeIn('[data-blade-upload] .filepond--file-status-main', 'File type is not allowed');
        $page->click('[data-sir-file-upload]:has(#blade-upload-brief) .filepond--action-remove-item');
        $page->script('const input = document.querySelector("#blade-upload-brief-browse"); const files = new DataTransfer(); files.items.add(new File([new Uint8Array(2097153)], "large.txt", {type:"text/plain"})); input.files = files.files; input.dispatchEvent(new Event("change", {bubbles:true}));');
        $page->assertSeeIn('[data-blade-upload] .filepond--file-status-main', 'File is too large');
        $page->script('const input = document.querySelector("#blade-upload-attachments-browse"); const files = new DataTransfer(); for(let i=0;i<4;i++) files.items.add(new File(["notes"], `notes-${i}.txt`, {type:"text/plain"})); input.files = files.files; input.dispatchEvent(new Event("change", {bubbles:true}));');
        expect($page->script('document.querySelectorAll("[data-sir-file-upload]:has(#blade-upload-attachments) .filepond--item").length'))->toBeLessThanOrEqual(3);
        $page->assertNoJavaScriptErrors();
    });
});

/** @param callable(string): void $run */
function withUploadBrowser(callable $run): void
{
    $socket = stream_socket_server('tcp://127.0.0.1:0');
    if ($socket === false) {
        throw new RuntimeException('Cannot reserve upload test port.');
    }
    $address = stream_socket_get_name($socket, false);
    fclose($socket);
    if ($address === false) {
        throw new RuntimeException('Cannot resolve upload test port.');
    }
    $uploadRoot = storage_path('framework/testing/uploads/' . str_replace(':', '-', $address));
    $server = new Process([
        PHP_BINARY, '-S', $address, base_path('vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php'),
    ], public_path(), [
        'APP_ENV'         => 'local', 'APP_KEY' => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',
        'APP_URL'         => 'http://' . $address, 'SESSION_DRIVER' => 'file', 'CACHE_STORE' => 'array',
        'FILESYSTEM_DISK' => 'browser-uploads', 'SIRIUS_TEST_UPLOAD_ROOT' => $uploadRoot,
    ]);
    try {
        $server->start();
        $deadline = microtime(true) + 15;
        while (!str_contains($server->getErrorOutput(), 'Development Server')) {
            if (!$server->isRunning() || microtime(true) >= $deadline) {
                throw new RuntimeException('Upload test server did not become ready: ' . $server->getErrorOutput());
            }
            usleep(10000);
        }
        $run('http://' . $address . '/blade-components/file-upload');
    } finally {
        $server->stop();
        File::deleteDirectory($uploadRoot);
    }
}

it('retries a failed temporary upload and cancels an in-flight upload', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit($url)->assertPresent('[data-upload-example] .filepond--browser');
        $page->script('(() => { if (window.uploadInterceptInstalled) return true; window.uploadInterceptInstalled = true; window.uploadMode = "fail"; const open = XMLHttpRequest.prototype.open; const send = XMLHttpRequest.prototype.send; XMLHttpRequest.prototype.open = function(method, url, ...args) { this.isUpload = String(url).includes("upload-file"); return open.call(this, method, url, ...args); }; XMLHttpRequest.prototype.send = function(body) { if(this.isUpload && window.uploadMode === "fail") { window.uploadMode = "normal"; setTimeout(() => this.dispatchEvent(new Event("error"))); return; } if(this.isUpload && window.uploadMode === "hold") return; return send.call(this, body); }; return true; })()');
        $page->attach('[data-upload-example] [data-sir-file-upload]:has([name=brief]) .filepond--browser', dirname(__DIR__) . '/Fixtures/proof.txt')
            ->assertSeeIn('[data-upload-example] .filepond--file-status-main', 'Upload failed')
            ->click('[data-upload-example] .filepond--action-retry-item-processing')
            ->assertSeeIn('[data-upload-example] .filepond--file-status-main', 'Upload complete');
        $page->click('[data-upload-example] button:has-text("Reset Sample")')->assertMissing('[data-upload-example] .filepond--item');
        $page->script('window.uploadMode = "hold";');
        $page->attach('[data-upload-example] [data-sir-file-upload]:has([name=brief]) .filepond--browser', dirname(__DIR__) . '/Fixtures/proof.txt')
            ->assertSeeIn('[data-upload-example] .filepond--file-status-main', 'Uploading')
            ->click('[data-upload-example] .filepond--action-abort-item-processing')
            ->assertSeeIn('[data-upload-example] .filepond--file-status-main', 'Upload cancelled');
        $page->assertNoJavaScriptErrors();
    });
});

it('uploads multiple files removes only a temporary selection and resets native fields', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit($url)->assertPresent('[data-upload-example] .filepond--browser');
        $page->script('window.progressSeen = false; document.addEventListener("file-upload:progress", e => { if(e.detail.progress >= 0) window.progressSeen = true; }); const input = document.querySelector("[data-upload-example] [data-sir-file-upload]:has([name=\\"attachments[]\\"]) .filepond--browser"); const files = new DataTransfer(); for(let i=0;i<2;i++) files.items.add(new File(["Project notes"], `notes-${i}.txt`, {type:"text/plain"})); input.files = files.files; input.dispatchEvent(new Event("change", {bubbles:true}));');
        $page->assertPresent('[data-upload-example] .filepond--item:nth-child(2)[data-filepond-item-state="processing-complete"]');
        $wire = 'Livewire.find(document.querySelector("[data-upload-example]").getAttribute("wire:id"))';
        expect($page->script($wire . '.$get("attachments").length'))->toBe(2);
        expect($page->script('window.progressSeen'))->toBeTrue();
        $page->click('[data-upload-example] .filepond--item:first-child .filepond--action-revert-item-processing')->assertMissing('[data-upload-example] .filepond--item:nth-child(2)');
        $page->assertScript($wire . '.$get("attachments").length', 1);
        $page->attach('#blade-upload-brief-browse', dirname(__DIR__) . '/Fixtures/proof.txt');
        $page->script('document.querySelector("[data-blade-upload]").reset();');
        $page->assertMissing('[data-blade-upload] .filepond--item')->assertNoJavaScriptErrors();
    });
});

it('previews new images and PDFs and loads existing metadata without reuploading', function (): void {
    withUploadBrowser(function (string $url): void {
        $page = visit($url)->assertPresent('#blade-upload-brief-browse');
        $page->attach('#blade-upload-brief-browse', public_path('sample/sample.pdf'))
            ->assertPresent('[data-blade-upload] .filepond--sirius-pdf-preview object');
        $page->attach('#blade-upload-artwork-browse', public_path('sample/sample.jpg'))
            ->assertPresent('[data-blade-upload] .filepond--image-preview canvas');
        $page->script('window.defaultUploads = 0; window.removedExisting = null; document.addEventListener("file-upload:start", () => window.defaultUploads++); document.addEventListener("file-upload:remove-existing", e => window.removedExisting = e.detail);');
        $page->click('[data-upload-example] button:has-text("Load Value")')
            ->assertPresent('[data-upload-example] .filepond--sirius-pdf-preview object')
            ->assertPresent('[data-upload-example] .filepond--file-poster img');
        $page->assertScript('window.defaultUploads', 0);
        $attachments = '[data-upload-example] [data-sir-file-upload]:has([name="attachments[]"])';
        $page->assertSeeIn($attachments . ' .filepond--file-info-main:text-is("sample.pdf")', 'sample.pdf')
            ->assertMissing($attachments . ' .filepond--sirius-pdf-preview')
            ->assertMissing($attachments . ' .filepond--file-poster');
        $page->assertScript('document.querySelector("[data-upload-example] [name=brief]").files.length', 0);
        $page->assertScript('document.querySelector("[data-upload-example] [name=brief]").required', false);
        $page->click('[data-upload-example] button:has-text("Submit / Validate")')->assertSeeIn('[data-upload-example] [role=status]', 'Project documents validated. Nothing was stored.');
        $page->click($attachments . ' .filepond--item:has(.filepond--file-info-main:text-is("sample.txt")) .filepond--action-remove-item')
            ->assertMissing($attachments . ' .filepond--file-info-main:text-is("sample.txt")')
            ->assertSeeIn($attachments . ' .filepond--file-info-main:text-is("sample.csv")', 'sample.csv')
            ->assertSeeIn($attachments . ' .filepond--file-info-main:text-is("sample.pdf")', 'sample.pdf');
        $page->assertScript('Livewire.find(document.querySelector("[data-upload-example]").getAttribute("wire:id")).$get("existingAttachments").length', 2);
        $page->click('[data-upload-example] [data-sir-file-upload]:has([name=brief]) .filepond--action-remove-item')
            ->assertMissing('[data-upload-example] .filepond--sirius-pdf-preview object');
        $page->assertScript('window.removedExisting.name', 'sample.pdf');
        $page->assertScript('document.querySelector("[data-upload-example] [name=brief]").required', true);
        $page->click('[data-blade-upload] button[value=load]')->assertPresent('[data-blade-upload] .filepond--sirius-pdf-preview object');
        $page->assertScript('document.querySelector("#blade-upload-brief").files.length', 0);
        $page->assertSeeIn('[data-sir-file-upload]:has(#blade-upload-attachments) .filepond--file-info-main:text-is("sample.pdf")', 'sample.pdf')
            ->assertMissing('[data-sir-file-upload]:has(#blade-upload-attachments) .filepond--sirius-pdf-preview');
        $page->assertScript('document.querySelector("#blade-upload-attachments").files.length', 0);
        $page->assertScript('document.querySelector("[data-blade-upload] .filepond--file-poster img").naturalWidth > 0');
        $page->resize(390, 844)->script('document.documentElement.classList.add("dark")');
        $page->assertScript('document.documentElement.scrollWidth <= innerWidth');
        $page->script('document.querySelector("[data-blade-upload]").scrollIntoView()');
        $page->assertScript('Number(getComputedStyle(document.querySelector("[data-blade-upload] .filepond--file-poster")).opacity) > 0.99');
        $page->assertScript('(() => { const item = document.querySelector("[data-blade-upload] .filepond--sirius-pdf-preview"); return item.getBoundingClientRect().bottom <= item.closest(".filepond--root").getBoundingClientRect().bottom + 1; })()');
        $page->screenshot(fullPage: false, filename: 'file-upload-preview-mobile-dark')->assertNoJavaScriptErrors();
    });
});
