<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class FieldExample extends Component
{
    #[Locked]
    public bool $labelOnly = false;

    public string $reference = '';

    public string $email = '';

    public bool $saved = false;

    public bool $locked = false;

    public function save(): void
    {
        $this->saved = false;
        $this->validate(['email' => ['required', 'email', 'max:255'], 'reference' => ['nullable', 'string', 'max:80']]);
        $this->saved = true;
    }

    public function resetForm(): void
    {
        $this->reset('email', 'reference', 'saved', 'locked');
        $this->resetValidation();
    }

    public function loadExample(): void
    {
        $this->email = 'reader@example.com';
        $this->reference = 'PROJECT-2026-014';
        $this->saved = false;
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.field-example');
    }
}
