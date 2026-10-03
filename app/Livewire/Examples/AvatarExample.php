<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class AvatarExample extends Component
{
    public ?string $source = null;

    public string $name = 'Nadia Putri';

    public bool $visible = true;

    public function loadImage(): void
    {
        $this->source = asset('sample/sample.jpg');
    }

    public function failImage(): void
    {
        $this->source = asset('sample/sample.pdf');
    }

    public function rename(): void
    {
        $this->name = 'Alex Morgan';
    }

    public function render(): View
    {
        return view('livewire.examples.avatar-example');
    }
}
