<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\View\View;
use Livewire\Component;

final class TabsExample extends Component
{
    public string $tab = 'overview';

    public string $title = 'Website redesign';

    public string $notes = 'Share the draft on Friday.';

    public int $revision = 0;

    public bool $notesDisabled = false;

    public bool $notesVisible = true;

    public bool $visible = true;

    public function refreshExample(): void
    {
        $this->revision++;
    }

    public function save(): void
    {
        $this->validate(['title' => ['required', 'string'], 'notes' => ['nullable', 'string']]);
        $this->revision++;
    }

    public function render(): View
    {
        return view('livewire.examples.tabs-example');
    }
}
