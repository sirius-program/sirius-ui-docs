<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class LayoutExample extends Component
{
    public bool $expanded = false;

    public bool $visible = true;

    public int $revision = 0;

    public function refreshExample(): void
    {
        $this->revision++;
    }

    public function render(): View
    {
        return view('livewire.examples.layout-example');
    }
}
