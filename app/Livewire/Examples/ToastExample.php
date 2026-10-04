<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class ToastExample extends Component
{
    public bool $open = false;

    public bool $visible = true;

    public int $revision = 0;

    public int $actions = 0;

    public function notify(): void
    {
        $this->revision++;
        $this->dispatch('toast:show', id: 'event-toast');
    }

    public function hideNotification(): void
    {
        $this->dispatch('toast:hide', id: 'event-toast');
    }

    public function acknowledge(): void
    {
        $this->actions++;
    }

    public function render(): View
    {
        return view('livewire.examples.toast-example');
    }
}
