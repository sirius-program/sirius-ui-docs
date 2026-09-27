<?php

declare(strict_types=1);

use App\Support\RichtextSample;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores validated richtext images and returns a usable preview URL', function (): void {
    Storage::fake();
    $response = $this->postJson(route('blade-components.richtext.images.store'), ['image' => UploadedFile::fake()->image('update.png')])->assertCreated()->assertJsonStructure(['url']);
    expect(Storage::allFiles('richtext-images'))->toHaveCount(1);
    $this->get($response->json('url'))->assertOk()->assertHeader('X-Content-Type-Options', 'nosniff');
});

it('rejects unsafe oversized and missing richtext uploads without storing files', function (): void {
    Storage::fake();
    foreach ([null, UploadedFile::fake()->create('notes.txt', 1, 'text/plain'), UploadedFile::fake()->image('large.png')->size(2049), UploadedFile::fake()->createWithContent('attack.svg', '<svg onload="alert(1)"></svg>')] as $image) {
        $this->postJson(route('blade-components.richtext.images.store'), ['image' => $image])->assertUnprocessable()->assertJsonValidationErrors('image');
    }
    expect(Storage::allFiles())->toBe([]);
    $this->get('/blade-components/richtext-images/not-a-file.png')->assertNotFound();
});

it('preserves safe uploaded image URLs and strips executable image attributes', function (): void {
    $safe = RichtextSample::sanitize('<p><img src="https://example.com/photo.png" alt="Photo" onerror="alert(1)"><img src="data:image/svg+xml,evil"></p>');
    expect($safe)->toContain('https://example.com/photo.png', 'alt="Photo"');
    expect($safe)->not->toContain('onerror', 'data:image');
});
