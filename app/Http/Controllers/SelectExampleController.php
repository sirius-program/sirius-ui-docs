<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\SelectCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class SelectExampleController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('action');
        if ($action === 'load') {
            return back()->with('select_sample', ['shipping' => '0', 'topics' => ['design', 'research'], 'venue' => 'bali']);
        }
        if ($action === 'reset') {
            return back()->with('select_sample', ['shipping' => null, 'topics' => [], 'venue' => null]);
        }
        $validator = Validator::make($request->only(['shipping', 'topics', 'venue']), SelectCatalog::rules());
        if ($validator->fails()) {
            return back()->withErrors($validator, 'select');
        }

        return back()->with('select_sample', $validator->validated())->with('select_saved', true);
    }
}
