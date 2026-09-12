<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class BasicControlsExample extends Component
{
    #[Locked]
    public string $kind = 'all';

    public string $title = '';

    public int|string|null $quantity = 0;

    public string $password = '';

    public string $notes = '';

    public bool $agreed = false;

    /** @var list<string> */
    public array $roles = [];

    public ?string $plan = null;

    public bool $enabled = false;

    public bool $locked = false;

    public bool $mixed = true;

    public bool $saved = false;

    public bool $showControls = true;

    public function save(): void
    {
        $this->saved = false;
        $rules = match ($this->kind) {
            'input'    => ['title' => ['required', 'max:80'], 'quantity' => ['required', 'numeric', 'min:0', 'max:100']],
            'password' => ['password' => ['required', 'min:8']],
            'textarea' => ['notes' => ['required', 'max:500']],
            'checkbox' => ['agreed' => ['accepted'], 'roles' => ['required', 'array', 'min:1'], 'roles.*' => ['in:0,editor']],
            'radio'    => ['plan' => ['required', 'in:0,pro']],
            'switch'   => ['enabled' => ['accepted']],
            default    => ['title' => ['required'], 'password' => ['required', 'min:8'], 'agreed' => ['accepted'], 'plan' => ['required', 'in:0,pro']],
        };
        $this->validate($rules);
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->title = 'Server title';
        $this->quantity = 12;
        $this->password = 'server-secret';
        $this->notes = 'Server notes';
        $this->agreed = true;
        $this->roles = ['0'];
        $this->plan = '0';
        $this->enabled = true;
        $this->mixed = false;
        $this->saved = false;
        $this->resetValidation();
    }

    public function resetExample(): void
    {
        $this->reset('title', 'quantity', 'password', 'notes', 'agreed', 'roles', 'plan', 'enabled', 'locked', 'mixed', 'saved');
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.basic-controls-example');
    }
}
