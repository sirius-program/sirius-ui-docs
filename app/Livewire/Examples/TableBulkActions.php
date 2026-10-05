<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

final class TableBulkActions extends Component
{
    #[Locked]
    public string $tableId = 'bulk-invoices';

    /** @var list<int> */
    #[Locked]
    public array $ids = [];

    /** @var list<string> */
    #[Locked]
    public array $numbers = [];

    /** @var list<string> */
    #[Locked]
    public array $linkedNumbers = [];

    #[Locked]
    public bool $loading = false;

    public string $note = '';

    public string $feedback = '';

    public function mount(string $id = 'bulk-invoices'): void
    {
        abort_unless((bool) preg_match('/^[a-zA-Z0-9_-]+$/D', $id), 422);
        $this->tableId = $id;
        if (request()->routeIs('livewire-components.table.bulk-actions') && request()->has('ids')) {
            $linked = request()->query('ids');
            if (!is_array($linked)) {
                throw ValidationException::withMessages(['ids' => 'Choose an array of invoice IDs.']);
            }
            $this->linkedNumbers = array_values($this->scopedInvoices($linked)->map(static fn (DemoInvoice $invoice): string => $invoice->number)->all());
        }
    }

    /** @param array<array-key, mixed> $ids */
    #[On('invoice:bulk-review.{tableId}')]
    public function review(array $ids): void
    {
        $this->selectInvoices($ids);
        $this->dispatch('dialog:show', id: $this->tableId . '-review');
    }

    /** @param array<array-key, mixed> $ids */
    #[On('invoice:bulk-reminder.{tableId}')]
    public function prompt(array $ids): void
    {
        $this->selectInvoices($ids);
        $this->dispatch('dialog:show', id: $this->tableId . '-confirm');
    }

    /** @param array<array-key, mixed> $ids */
    #[On('invoice:bulk-details.{tableId}')]
    public function details(array $ids): void
    {
        $this->selectInvoices($ids);
        $this->dispatch('dialog:show', id: $this->tableId . '-details');
    }

    public function beginReview(): void
    {
        $this->scopedInvoices($this->ids);
        $this->validate(['note' => ['required', 'string', 'max:200']]);
        $this->loading = true;
    }

    public function completeReview(bool $fail = false): void
    {
        if (!$this->loading) {
            return;
        }
        try {
            $records = $this->scopedInvoices($this->ids);
            $this->validate(['note' => ['required', 'string', 'max:200']]);
            if ($fail) {
                $this->feedback = 'Review failed. Retry or cancel; selection was kept.';

                return;
            }
            $this->feedback = 'Reviewed ' . $records->count() . ' invoices: ' . $this->note;
            $this->dispatch('table:remove-selection.' . $this->tableId, ids: $this->ids);
            $this->dispatch('table:refresh.' . $this->tableId);
            $this->dispatch('dialog:hide', id: $this->tableId . '-review');
        } finally {
            $this->loading = false;
        }
    }

    public function cancelReview(): void
    {
        $this->loading = false;
    }

    public function prepareReminders(): void
    {
        $records = $this->scopedInvoices($this->ids);
        $this->feedback = 'Prepared reminders for ' . $records->count() . ' invoices. Nothing was sent.';
        $this->dispatch('table:clear-selection.' . $this->tableId);
        $this->dispatch('table:refresh.' . $this->tableId);
        $this->dispatch('dialog:hide', id: $this->tableId . '-confirm');
    }

    /** @param array<array-key, mixed> $ids */
    private function selectInvoices(array $ids): void
    {
        $records = $this->scopedInvoices($ids);
        $this->ids = array_values($records->map(static fn (DemoInvoice $invoice): int => (int) $invoice->getKey())->all());
        $this->numbers = array_values($records->map(static fn (DemoInvoice $invoice): string => $invoice->number)->all());
        $this->note = '';
        $this->resetValidation();
    }

    /**
     * @param  array<array-key, mixed>  $ids
     * @return Collection<int, DemoInvoice>
     */
    private function scopedInvoices(array $ids): Collection
    {
        validator(['ids' => $ids], ['ids' => ['required', 'array', 'min:1', 'max:200'], 'ids.*' => ['required', 'integer', 'min:1', 'distinct']])->validate();
        $records = InvoiceSample::query()->whereKey($ids)->get();
        if ($records->count() !== count($ids)) {
            throw ValidationException::withMessages(['ids' => 'One or more invoices are unavailable. Choose them again.']);
        }

        return $records;
    }

    public function render(): View
    {
        return view('livewire.examples.table-bulk-actions');
    }
}
