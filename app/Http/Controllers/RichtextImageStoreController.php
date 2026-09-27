<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

final class RichtextImageStoreController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['image' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']]);
        $image = $request->file('image');
        abort_unless($image instanceof UploadedFile, 422);
        $path = $image->store('richtext-images');
        abort_if($path === false, 500);

        return response()->json(['url' => route('blade-components.richtext.images.show', ['file' => basename($path)])], 201);
    }
}
