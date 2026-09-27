<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\SliderSample;
use Illuminate\View\View;
use Livewire\Component;

final class SliderExample extends Component
{
    public int|float|string $discount = 10;

    /** @var list<int|float|string> */
    public array $budget = [40, 160];

    public bool $locked = false;

    public bool $disabled = false;

    public bool $visible = true;

    public bool $saved = false;

    public function save(): void
    {
        $this->saved = false;
        $this->validate(SliderSample::rules());
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->discount = 25;
        $this->budget = [80, 220];
        $this->saved = false;
        $this->resetValidation();
    }

    public function resetExample(): void
    {
        $this->reset('discount', 'budget', 'locked', 'disabled', 'saved');
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.slider-example');
    }
}
