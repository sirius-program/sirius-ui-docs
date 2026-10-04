<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class FloatingExample extends Component
{
    public int $count = 0;

    public bool $opened = false;

    public bool $visible = true;

    public string $hint = 'Only project members can open this file.';

    public string $name = '';

    public function increment(): void
    {
        $this->count++;
    }

    public function rename(): void
    {
        $this->hint = 'Access is limited to invited members.';
    }

    public function render(): View
    {
        return view('livewire.examples.floating-example');
    }
}
