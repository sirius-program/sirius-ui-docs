<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class FormValidationController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        if ($action === 'load') {
            return to_route('development.fields')->with('field-loaded', true);
        }
        if ($action === 'reset') {
            return to_route('development.fields')->withInput([]);
        }
        $validated = $request->validateWithBag('profile', ['contact.email' => ['required', 'email', 'max:255']]);

        return to_route('development.fields')->with('form-success', 'Validation passed. Nothing was stored.')->withInput($validated);
    }
}
