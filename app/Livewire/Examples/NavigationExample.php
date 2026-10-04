<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class NavigationExample extends Component
{
    public int $count = 0;

    public bool $locked = false;

    public bool $opened = false;

    public bool $visible = true;

    public string $name = 'Export';

    public function increment(): void
    {
        $this->count++;
    }

    public function rename(): void
    {
        $this->name = 'Download';
    }

    public function render(): View
    {
        return view('livewire.examples.navigation-example');
    }
}
