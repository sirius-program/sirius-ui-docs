<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\InvoiceSample;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class InvoiceCustomerOptionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate(['q' => ['nullable', 'string', 'max:100'], 'page' => ['sometimes', 'integer', 'min:1', 'max:1000'], 'values' => ['sometimes', 'array', 'max:50'], 'values.*' => ['string', 'max:100']]);
        $query = InvoiceSample::query()->select('customer')->distinct()->orderBy('customer');
        if (isset($data['values'])) {
            $query->whereIn('customer', $data['values']);
        } elseif (($data['q'] ?? '') !== '') {
            $query->where('customer', 'like', '%' . $data['q'] . '%');
        }
        $page = (int) ($data['page'] ?? 1);
        $customers = isset($data['values']) ? $query->pluck('customer') : $query->offset(($page - 1) * 2)->limit(3)->pluck('customer');

        return response()->json([
            'options' => (isset($data['values']) ? $customers : $customers->take(2))->map(static fn (string $name): array => ['value' => $name, 'label' => $name])->values()->all(),
            'hasMore' => !isset($data['values']) && $customers->count() > 2,
        ]);
    }
}
