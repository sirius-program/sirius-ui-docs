<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class CurrencyBindingsExample extends Component
{
    public string $change = '';

    public string $lazy = '';

    public string $enter = '';

    public string $deferred = '';

    public function render(): View
    {
        return view('livewire.examples.currency-bindings-example');
    }
}
