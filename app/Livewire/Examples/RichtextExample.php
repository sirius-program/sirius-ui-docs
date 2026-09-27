<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\RichtextSample;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class RichtextExample extends Component
{
    public string $body = '';

    public string $signature = '';

    public bool $locked = false;

    public bool $visible = true;

    public int $richtextRevision = 0;

    #[Locked]
    public string $preview = '';

    public function save(): void
    {
        $this->preview = '';
        $this->validate(RichtextSample::rules());
        $this->preview = RichtextSample::sanitize($this->body);
    }

    public function loadExample(): void
    {
        $this->fill(RichtextSample::values());
        $this->preview = '';
        $this->resetValidation();
    }

    public function resetExample(): void
    {
        $this->richtextRevision++;
        $this->reset('body', 'signature', 'locked', 'preview');
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.richtext-example');
    }
}
