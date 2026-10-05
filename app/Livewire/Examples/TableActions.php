<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\InvoiceSample;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

final class TableActions extends Component
{
    #[Locked]
    public ?int $invoiceId = null;

    #[Locked]
    public string $number = '';

    public string $note = '';

    public string $feedback = '';

    public bool $loading = false;

    #[On('invoice:dialog')]
    public function review(int $id): void
    {
        $this->selectInvoice($id);
        $this->dispatch('dialog:show', id: 'invoice-review');
    }

    #[On('invoice:alert')]
    public function prompt(int $id): void
    {
        $this->selectInvoice($id);
        $this->dispatch('dialog:show', id: 'invoice-confirm');
    }

    #[On('invoice:slideover')]
    public function details(int $id): void
    {
        $this->selectInvoice($id);
        $this->dispatch('dialog:show', id: 'invoice-details');
    }

    public function saveReview(): void
    {
        abort_if($this->invoiceId === null, 422);
        $record = InvoiceSample::query()->findOrFail($this->invoiceId);
        $this->validate(['note' => ['required', 'string', 'max:200']]);
        $this->feedback = $record->number . ': ' . $this->note;
        $this->dispatch('dialog:hide', id: 'invoice-review');
        $this->dispatch('table:refresh.invoice-table');
    }

    private function selectInvoice(int $id): void
    {
        $record = InvoiceSample::query()->find($id);
        abort_if($record === null, 404);
        $this->invoiceId = (int) $record->getKey();
        $this->number = (string) $record->number;
        $this->note = '';
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.examples.table-actions');
    }
}
