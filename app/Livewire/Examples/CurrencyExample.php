<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class CurrencyExample extends Component
{
    public string $budget = '';

    public string $adjustment = '';

    public bool $locked = false;

    public bool $disabled = false;

    public bool $showControls = true;

    public bool $saved = false;

    public function save(): void
    {
        $this->saved = false;
        $this->validate([
            'budget'     => ['required', 'string', 'max:100', 'regex:/^[0-9]+(?:\.[0-9]{1,2})?$/D'],
            'adjustment' => ['required', 'string', 'max:100', 'regex:/^-?[0-9]+(?:\.[0-9]{1,3})?$/D'],
        ], [
            'budget.regex'     => 'Enter a non-negative budget with at most 2 decimal places.',
            'adjustment.regex' => 'Enter an adjustment with at most 3 decimal places.',
        ]);
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->budget = '1234567.50';
        $this->adjustment = '-1250.125';
        $this->saved = false;
        $this->resetValidation();
    }

    public function resetExample(): void
    {
        $this->reset('budget', 'adjustment', 'locked', 'disabled', 'saved');
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.currency-example');
    }
}
