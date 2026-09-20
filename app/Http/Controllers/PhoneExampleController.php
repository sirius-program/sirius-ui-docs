<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Sirius\Ui\Rules\PhoneNumber;
use Sirius\Ui\Support\PhoneCountry;

final class PhoneExampleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        $destination = route('blade-components.phone') . '#phone-blade';
        if ($action === 'reset') {
            return redirect($destination)->with('sample-phone', []);
        }
        if ($action === 'load') {
            return redirect($destination)->with('sample-phone', ['delivery' => '+6281234567890', 'partner' => '+442079460018', 'traveler' => '+12025550123']);
        }
        $validator = Validator::make($request->only(['delivery', 'partner', 'traveler']), [
            'delivery' => ['required', new PhoneNumber(['62'])],
            'partner'  => ['required', new PhoneNumber(['62', '44'])],
            'traveler' => ['required', new PhoneNumber],
        ]);
        if ($validator->fails()) {
            $drafts = [];
            foreach (['delivery' => ['ID'], 'partner' => ['ID', 'GB'], 'traveler' => array_keys(PhoneCountry::countries())] as $field => $countries) {
                $raw = $request->input($field . '_draft');
                $draft = is_string($raw) && strlen($raw) <= 1000 ? json_decode($raw, true) : null;
                if (is_array($draft) && isset($draft['text'], $draft['country']) && is_string($draft['text']) && is_string($draft['country']) && in_array($draft['country'], $countries, true)) {
                    $drafts[$field] = ['text' => $draft['text'], 'country' => $draft['country']];
                }
            }

            return redirect($destination)->withErrors($validator, 'phone')->with('sample-phone', [])->with('phone-drafts', $drafts);
        }

        return redirect($destination)->with('sample-phone', $validator->validated())->with('phone-success', true);
    }
}
