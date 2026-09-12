<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class FormValidationController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('profile', ['contact.email' => ['required', 'email', 'max:255']]);

        return to_route('components.forms')->with('form-success', 'Validation passed. Nothing was stored.')->withInput($validated);
    }
}
