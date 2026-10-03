<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DialogFormSample;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class SlideoverFormExampleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        $destination = route('blade-components.slideover') . '#slideover-demo';
        $sample = DialogFormSample::values();
        if ($action === 'load') {
            $sample['title'] = 'Website redesign';
            $sample['agreed'] = true;
        }
        if ($action !== 'validate') {
            return redirect($destination)->with('slideover-sample', $sample)->with('slideover-form-open', true);
        }
        $validator = Validator::make($request->only(['sample', 'attachment']), DialogFormSample::rules());
        $submitted = array_intersect_key($request->array('sample'), $sample);
        unset($submitted['password']);
        foreach ($submitted as $key => $value) {
            if ($validator->errors()->has('sample.' . $key) || $validator->errors()->has('sample.' . $key . '.*')) {
                $submitted[$key] = $sample[$key];
            }
        }
        $response = redirect($destination)->with('slideover-sample', $submitted)->with('slideover-form-open', true);
        if ($validator->fails()) {
            return $response->withErrors($validator, 'slideover-form');
        }

        return $response->with('slideover-form-saved', true);
    }
}
