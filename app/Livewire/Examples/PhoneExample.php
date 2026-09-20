<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;
use Sirius\Ui\Rules\PhoneNumber;

final class PhoneExample extends Component
{
    public ?string $delivery = null;

    public ?string $partner = null;

    public ?string $traveler = null;

    public bool $locked = false;

    public bool $disabled = false;

    public bool $showControls = true;

    public bool $saved = false;

    public int $resetKey = 0;

    public function save(): void
    {
        $this->saved = false;
        $this->validate([
            'delivery' => ['required', new PhoneNumber(['62'])],
            'partner'  => ['required', new PhoneNumber(['62', '44'])],
            'traveler' => ['required', new PhoneNumber],
        ]);
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->delivery = '+6281234567890';
        $this->partner = '+442079460018';
        $this->traveler = '+12025550123';
        $this->resetKey++;
        $this->saved = false;
        $this->resetValidation();
    }

    public function resetExample(): void
    {
        $this->reset('delivery', 'partner', 'traveler', 'locked', 'disabled', 'saved');
        $this->resetKey++;
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.phone-example');
    }
}
