<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\DemoInvoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class InvoiceSample
{
    public static function initialize(bool $seed = true): void
    {
        // Each request uses an isolated in-memory database; no application database is modified.
        if (config('database.connections.invoice-demo') === null) {
            config(['database.connections.invoice-demo' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']]);
            DB::purge('invoice-demo');
        }
        $schema = Schema::connection('invoice-demo');
        if ($schema->hasTable('demo_invoices')) {
            return;
        }
        $schema->create('demo_invoices', function (Blueprint $table): void {
            $table->id();
            $table->string('number');
            $table->string('customer');
            $table->string('status');
            $table->integer('amount');
            $table->string('issued_on')->default('2028-10-15');
            $table->string('reminder_at')->default('09:00');
            $table->string('sent_at')->default('2028-10-15 09:00:00');
            $table->string('workspace');
            $table->string('internal_note');
        });
        if ($seed) {
            $customers = ['Northstar Studio', 'Orbit Coffee', 'Bright Books', 'Cedar Workshop'];
            $statuses = ['pending', 'paid', 'overdue'];
            for ($index = 0; $index < 34; $index++) {
                DemoInvoice::query()->create([
                    'number'      => 'INV-' . (1042 + $index), 'customer' => $customers[$index % 4],
                    'status'      => $statuses[$index % 3], 'amount' => 12000 + $index * 750,
                    'issued_on'   => '2028-10-' . (15 + $index % 3),
                    'reminder_at' => $index % 2 === 0 ? '09:00' : '14:30',
                    'sent_at'     => '2028-10-' . (15 + $index % 3) . ' ' . ($index % 2 === 0 ? '09:00:00' : '14:30:00'),
                    'workspace'   => 'design', 'internal_note' => 'Private billing note',
                ]);
            }
        }
    }

    /** @return Builder<DemoInvoice> */
    public static function query(): Builder
    {
        self::initialize();

        return DemoInvoice::query()->where('workspace', 'design');
    }
}
