<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class OverlayExample extends Component
{
    public string $active = '';

    public string $note = '';

    public int $revision = 0;

    public bool $visible = true;

    public function save(): void
    {
        $this->validate(['note' => ['required', 'string', 'max:120']]);
        $this->active = '';
    }

    public function render(): View
    {
        return view('livewire.examples.overlay-example');
    }
}
