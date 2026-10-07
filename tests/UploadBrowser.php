<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Pest\Browser\Playwright\Playwright;
use Symfony\Component\Process\Process;

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
        Playwright::usingTimeout(10000, fn () => $run('http://' . $address . '/blade-components/file-upload'));
    } finally {
        $server->stop();
        File::deleteDirectory($uploadRoot);
    }
}
