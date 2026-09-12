<?php

declare(strict_types=1);

use App\Livewire\Development\IntegrationProbe;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('sanitizes editor HTML on the server and preserves safe formatting', function (): void {
    Livewire::test(IntegrationProbe::class)
        ->set('html', '<p><strong>Safe</strong><script>alert(1)</script><a href="javascript:alert(1)">link</a></p>')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('sanitized', fn (string $html): bool => str_contains($html, '<strong>Safe</strong>')
            && !str_contains($html, '<script') && !str_contains($html, 'javascript:'));
});

it('preserves validation errors and accepts only configured choice values', function (): void {
    Livewire::test(IntegrationProbe::class)
        ->set('choice', 'tampered')
        ->call('save')
        ->assertHasErrors(['choice' => 'in'])
        ->call('resetValues')
        ->assertHasNoErrors()
        ->assertSet('date', '2026-10-01')
        ->assertSet('choice', 'beta')
        ->assertSet('html', '<p>Server reset</p>');
});

it('validates temporary files without permanently storing them', function (): void {
    Storage::fake('local');

    Livewire::test(IntegrationProbe::class)
        ->set('upload', UploadedFile::fake()->createWithContent('proof.txt', 'Phase zero proof'))
        ->call('save')
        ->assertHasNoErrors()
        ->call('resetValues')
        ->assertSet('upload', null);
});
