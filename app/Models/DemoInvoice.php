<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\DemoInvoiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $number
 * @property string $customer
 * @property string $status
 * @property int $amount
 */
final class DemoInvoice extends Model
{
    /** @use HasFactory<DemoInvoiceFactory> */
    use HasFactory;

    protected $connection = 'invoice-demo';

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = ['internal_note', 'workspace'];
}
