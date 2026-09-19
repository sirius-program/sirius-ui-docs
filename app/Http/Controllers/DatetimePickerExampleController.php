<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class DatetimePickerExampleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        $destination = route('blade-components.datetime-picker') . '#datetime-picker-blade';
        if ($action === 'reset') {
            return redirect($destination)->with('sample-datetime-picker', []);
        }
        if ($action === 'load') {
            return redirect($destination)->with('sample-datetime-picker', ['departure' => '2028-02-29', 'reminder' => '09:30', 'appointment' => '2028-12-31 14:30:45']);
        }
        $validator = Validator::make($request->only(['departure', 'reminder', 'appointment']), [
            'departure'   => ['required', 'date_format:Y-m-d', 'after_or_equal:2028-01-01', 'before_or_equal:2028-12-31', 'not_in:2028-03-01'],
            'reminder'    => ['required', 'date_format:H:i', 'after_or_equal:08:00', 'before_or_equal:20:00'],
            'appointment' => ['required', 'date_format:Y-m-d H:i:s', 'after_or_equal:2028-01-01 00:00:00', 'before_or_equal:2028-12-31 23:59:59'],
        ]);
        $values = array_filter($request->only(['departure', 'reminder', 'appointment']), is_string(...));
        if ($validator->fails()) {
            return redirect($destination)->withErrors($validator, 'datetime-picker')->with('sample-datetime-picker', $values);
        }

        return redirect($destination)->with('sample-datetime-picker', $validator->validated())->with('datetime-picker-success', true);
    }
}
