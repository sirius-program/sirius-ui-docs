<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\SliderSample;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class SliderExampleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        $destination = route('blade-components.slider') . '#slider-blade';
        if ($action === 'reset') {
            return redirect($destination)->with('sample-slider', []);
        }
        if ($action === 'load') {
            return redirect($destination)->with('sample-slider', ['discount' => 25, 'budget' => [80, 220]]);
        }
        $validator = Validator::make($request->only(['discount', 'budget']), SliderSample::rules());
        if ($validator->fails()) {
            return redirect($destination)->withErrors($validator, 'slider');
        }

        return redirect($destination)->with('sample-slider', $validator->validated())->with('slider-success', true);
    }
}
