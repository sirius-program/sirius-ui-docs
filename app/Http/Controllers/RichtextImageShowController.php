<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class RichtextImageShowController extends Controller
{
    public function __invoke(string $file): StreamedResponse
    {
        $path = 'richtext-images/' . $file;
        abort_unless(Storage::exists($path), 404);

        return Storage::response($path, null, ['X-Content-Type-Options' => 'nosniff']);
    }
}
