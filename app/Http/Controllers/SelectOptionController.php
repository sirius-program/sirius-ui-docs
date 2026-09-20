<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\SelectCatalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SelectOptionController
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate(['q' => ['nullable', 'string', 'max:100'], 'page' => ['sometimes', 'integer', 'min:1', 'max:1000'], 'values' => ['sometimes', 'array', 'max:50'], 'values.*' => ['string', 'max:100']]);
        // Only this deliberately public catalog is searchable; no client-defined models or queries.
        $options = collect(SelectCatalog::venues());
        if (isset($data['values'])) {
            return response()->json(['options' => $options->whereIn('value', $data['values'])->values()->all(), 'hasMore' => false]);
        }
        $query = strtolower($data['q'] ?? '');
        $options = $options->filter(fn (array $option): bool => str_contains(strtolower($option['label']), $query))->values();
        $page = (int) ($data['page'] ?? 1);

        return response()->json(['options' => $options->slice(($page - 1) * 2, 2)->values()->all(), 'hasMore' => $options->count() > $page * 2]);
    }
}
