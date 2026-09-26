<?php

declare(strict_types=1);

use App\Livewire\Examples\FileUploadExample;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('renders upload docs with Blade and Livewire controls', function (): void {
    $this->get(route('blade-components.file-upload'))->assertOk()->assertSee('data-upload-example', false)->assertSee('multipart/form-data');
});

it('validates native files and rejects invalid content and oversized files', function (): void {
    Storage::fake('local');
    $this->from(route('blade-components.file-upload'))->post(route('blade-components.file-upload.store'), [
        'action'      => 'validate', 'brief' => UploadedFile::fake()->createWithContent('brief.txt', 'Project requirements'),
        'attachments' => [UploadedFile::fake()->createWithContent('notes.txt', 'Supporting notes')],
    ])->assertSessionHas('upload-saved');
    $this->post(route('blade-components.file-upload.store'), ['action' => 'validate', 'brief' => UploadedFile::fake()->image('image.png')])->assertSessionHasErrors(['brief'], errorBag: 'upload');
    $this->post(route('blade-components.file-upload.store'), ['action' => 'validate', 'brief' => UploadedFile::fake()->create('brief.txt', 2049, 'text/plain')])->assertSessionHasErrors(['brief'], errorBag: 'upload');
    expect(Storage::disk('local')->allFiles())->toBe([]);
});

it('handles temporary files multiple validation metadata loads and explicit resets', function (): void {
    Storage::fake('local');
    Livewire::test(FileUploadExample::class)->call('save')->assertHasErrors('brief')
        ->set('brief', UploadedFile::fake()->createWithContent('brief.txt', 'Project brief'))
        ->set('attachments', [UploadedFile::fake()->createWithContent('notes.txt', 'Notes')])
        ->call('save')->assertHasNoErrors()->assertSet('saved', true)
        ->set('attachments', array_fill(0, 4, UploadedFile::fake()->createWithContent('notes.txt', 'Notes')))
        ->call('save')->assertHasErrors('attachments')
        ->call('loadExample')->assertSet('existing', true)->assertSet('brief', null)->assertSet('attachments', [])
        ->assertCount('existingAttachments', 3)
        ->set('attachments', array_fill(0, 3, UploadedFile::fake()->createWithContent('notes.txt', 'Notes')))
        ->call('save')->assertHasErrors('attachments')
        ->call('removeExistingAttachment', 'sample.txt')->assertCount('existingAttachments', 2)
        ->set('existingAttachments', [])->call('save')->assertHasNoErrors()
        ->call('resetExample')->assertSet('existing', false)->assertSet('existingAttachments', []);
});

it('counts retained native supporting documents toward the file limit', function (): void {
    $files = array_fill(0, 3, UploadedFile::fake()->createWithContent('notes.txt', 'Notes'));
    $this->withSession(['upload-existing' => true])->post(route('blade-components.file-upload.store'), [
        'action' => 'validate', 'keep_brief' => '1', 'keep_attachments' => ['sample.pdf'], 'attachments' => $files,
    ])->assertSessionHasErrors(['attachments'], errorBag: 'upload');
    $this->withSession(['upload-existing' => true])->post(route('blade-components.file-upload.store'), [
        'action' => 'validate', 'keep_brief' => '1', 'keep_attachments' => [], 'attachments' => $files,
    ])->assertSessionHas('upload-saved');
});
