<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class BasicFormController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('basic', [
            'title'    => ['required', 'string', 'max:80'],
            'quantity' => ['required', 'numeric', 'min:0', 'max:100'],
            'notes'    => ['nullable', 'string', 'max:500'],
            'roles'    => ['sometimes', 'array'],
            'roles.*'  => ['in:0,editor'],
            'plan'     => ['required', 'in:0,pro'],
            'enabled'  => ['sometimes', 'accepted'],
        ]);

        $validated['enabled'] = $request->boolean('enabled');

        return to_route('blade-components.control', ['control' => 'input'])
            ->with('basic-result', $validated)->withInput($validated);
    }
}
