<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class DialogExample extends Component
{
    public bool $reviewing = false;

    public bool $visible = true;

    public string $address = '';

    public string $shipping = 'standard';

    public string $deliveryDate = '2028-10-15';

    public int $revision = 0;

    public function save(): void
    {
        $this->validate(['address' => ['required', 'string', 'max:120']]);
        $this->reviewing = false;
    }

    public function render(): View
    {
        return view('livewire.examples.dialog-example');
    }
}
