<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class PresentationExample extends Component
{
    #[Locked]
    public string $kind;

    public bool $saved = false;

    public bool $disabled = false;

    public int $revision = 0;

    public function mount(string $kind): void
    {
        abort_unless(in_array($kind, ['icon', 'button', 'button-group', 'badge', 'message'], true), 404);
        $this->kind = $kind;
    }

    public function save(): void
    {
        $this->saved = true;
    }

    public function refreshExample(): void
    {
        $this->revision++;
        $this->saved = false;
    }

    public function render(): View
    {
        return view('livewire.examples.presentation-example');
    }
}
