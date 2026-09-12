<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class FieldExample extends Component
{
    public string $email = '';

    public bool $saved = false;

    public bool $locked = false;

    public function save(): void
    {
        $this->saved = false;
        $this->validate(['email' => ['required', 'email', 'max:255']]);
        $this->saved = true;
    }

    public function resetForm(): void
    {
        $this->reset('email', 'saved', 'locked');
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.field-example');
    }
}
