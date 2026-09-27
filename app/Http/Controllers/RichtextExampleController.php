<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\RichtextSample;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class RichtextExampleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        $destination = route('blade-components.richtext') . '#richtext-blade';
        if ($action === 'load' || $action === 'reset') {
            return redirect($destination)->with('sample-richtext', $action === 'load' ? RichtextSample::values() : []);
        }
        $values = $request->only(['body', 'signature']);
        $validator = Validator::make($values, RichtextSample::rules());
        if ($validator->fails()) {
            return redirect($destination)->withErrors($validator, 'richtext')->with('sample-richtext', array_filter($values, is_string(...)));
        }

        return redirect($destination)->with('sample-richtext', $validator->validated())->with('richtext-preview', RichtextSample::sanitize($values['body']));
    }
}
