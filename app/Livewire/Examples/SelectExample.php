<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\SelectCatalog;
use Illuminate\View\View;
use Livewire\Component;

final class SelectExample extends Component
{
    public ?string $shipping = null;

    /** @var list<string> */
    public array $topics = [];

    public ?string $venue = null;

    public bool $locked = false;

    public bool $disabled = false;

    public bool $showControls = true;

    public bool $saved = false;

    public function save(): void
    {
        $this->saved = false;
        $this->validate(SelectCatalog::rules());
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->shipping = '0';
        $this->topics = ['design', 'research'];
        $this->venue = 'bali';
        $this->resetValidation();
        $this->saved = false;
    }

    public function resetExample(): void
    {
        $this->reset('shipping', 'topics', 'venue', 'locked', 'disabled', 'saved');
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.select-example');
    }
}
