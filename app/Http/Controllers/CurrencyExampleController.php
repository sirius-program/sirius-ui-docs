<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class CurrencyExampleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        $destination = route('blade-components.currency') . '#currency-blade';
        if ($action === 'reset') {
            return redirect($destination)->with('sample-currency', []);
        }
        if ($action === 'load') {
            return redirect($destination)->with('sample-currency', ['budget' => '1234567.50', 'adjustment' => '-1250.125']);
        }
        $validator = Validator::make($request->only(['budget', 'adjustment']), [
            'budget'     => ['required', 'string', 'max:100', 'regex:/^[0-9]+(?:\.[0-9]{1,2})?$/D'],
            'adjustment' => ['required', 'string', 'max:100', 'regex:/^-?[0-9]+(?:\.[0-9]{1,3})?$/D'],
        ], [
            'budget.regex'     => 'Enter a non-negative budget with at most 2 decimal places.',
            'adjustment.regex' => 'Enter an adjustment with at most 3 decimal places.',
        ]);
        $values = array_filter($request->only(['budget', 'adjustment']), is_string(...));
        if ($validator->fails()) {
            return redirect($destination)->withErrors($validator, 'currency')->with('sample-currency', $values);
        }

        return redirect($destination)->with('sample-currency', $validator->validated())->with('currency-success', true);
    }
}
