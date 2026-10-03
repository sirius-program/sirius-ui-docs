<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\DialogFormSample;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

final class DialogFormExample extends Component
{
    use WithFileUploads;

    public bool $reviewing = false;

    public bool $locked = false;

    public bool $saved = false;

    public int $resetKey = 0;

    public mixed $attachment = null;

    /** @var array<string, mixed> */
    public array $sample = [];

    public function mount(): void
    {
        $this->sample = DialogFormSample::values();
    }

    public function save(): void
    {
        $this->saved = false;
        $this->validate(DialogFormSample::rules());
        $this->sample['password'] = '';
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->resetExample();
        $this->sample['title'] = 'Website redesign';
        $this->sample['agreed'] = true;
    }

    public function resetExample(): void
    {
        $this->sample = DialogFormSample::values();
        $this->reset('attachment', 'saved', 'locked');
        $this->resetValidation();
        $this->resetKey++;
    }

    public function render(): View
    {
        return view('livewire.examples.dialog-form-example');
    }
}
