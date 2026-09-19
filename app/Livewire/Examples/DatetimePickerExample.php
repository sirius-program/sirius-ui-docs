<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class DatetimePickerExample extends Component
{
    public string $departure = '';

    public string $reminder = '';

    public string $appointment = '';

    public bool $locked = false;

    public bool $disabled = false;

    public bool $showControls = true;

    public bool $saved = false;

    public function save(): void
    {
        $this->saved = false;
        $this->validate([
            'departure'   => ['required', 'date_format:Y-m-d', 'after_or_equal:2028-01-01', 'before_or_equal:2028-12-31', 'not_in:2028-03-01'],
            'reminder'    => ['required', 'date_format:H:i', 'after_or_equal:08:00', 'before_or_equal:20:00'],
            'appointment' => ['required', 'date_format:Y-m-d H:i:s', 'after_or_equal:2028-01-01 00:00:00', 'before_or_equal:2028-12-31 23:59:59'],
        ]);
        $this->saved = true;
    }

    public function loadExample(): void
    {
        $this->departure = '2028-02-29';
        $this->reminder = '09:30';
        $this->appointment = '2028-12-31 14:30:45';
        $this->saved = false;
        $this->resetValidation();
    }

    public function resetExample(): void
    {
        $this->reset('departure', 'reminder', 'appointment', 'locked', 'disabled', 'saved');
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.datetime-picker-example');
    }
}
