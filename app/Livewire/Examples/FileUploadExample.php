<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

final class FileUploadExample extends Component
{
    use WithFileUploads;

    public mixed $brief = null;

    public mixed $artwork = null;

    /** @var array<int, mixed> */
    public array $attachments = [];

    public bool $locked = false;

    public bool $existing = false;

    public bool $existingBrief = false;

    /** @var list<array{name: string, size: int}> */
    public array $existingAttachments = [];

    public bool $saved = false;

    public int $resetKey = 0;

    public function save(): void
    {
        $this->saved = false;
        $this->validate([
            'brief'         => [$this->existingBrief ? 'nullable' : 'required', 'file', 'mimes:pdf,txt', 'max:2048'],
            'artwork'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'attachments'   => ['array', 'max:' . (3 - count($this->existingAttachments))],
            'attachments.*' => ['file', 'mimes:pdf,txt,jpg,jpeg,png', 'max:2048'],
        ]);
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->resetExample();
        $this->existing = true;
        $this->existingBrief = true;
        $this->existingAttachments = [
            ['name' => 'sample.pdf', 'size' => 18810],
            ['name' => 'sample.txt', 'size' => 4],
            ['name' => 'sample.csv', 'size' => 4],
        ];
    }

    public function removeExistingAttachment(string $name): void
    {
        $this->existingAttachments = array_values(array_filter($this->existingAttachments, fn (array $file): bool => $file['name'] !== $name));
    }

    public function resetExample(): void
    {
        $this->reset('brief', 'artwork', 'attachments', 'locked', 'existing', 'existingBrief', 'existingAttachments', 'saved');
        $this->resetValidation();
        $this->resetKey++;
    }

    public function render(): View
    {
        return view('livewire.examples.file-upload-example');
    }
}
