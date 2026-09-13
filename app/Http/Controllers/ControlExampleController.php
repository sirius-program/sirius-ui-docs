<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class ControlExampleController extends Controller
{
    public function __invoke(Request $request, string $kind): RedirectResponse
    {
        $destination = $kind === 'label' ? route('blade-components.label') : route('blade-components.control', ['control' => match ($kind) {
            'password'                    => 'input',
            'checkbox', 'radio', 'switch' => 'choices',
            default                       => $kind,
        }]);
        $destination .= '#' . $kind . '-blade';
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);

        if ($action === 'reset') {
            return redirect($destination)->with('sample-' . $kind, []);
        }
        if ($action === 'load') {
            return redirect($destination)->with('sample-' . $kind, [
                'title'  => 'Website redesign', 'quantity' => 12, 'notes' => 'Prepare the homepage draft for the design review on Friday.',
                'agreed' => true, 'roles' => ['0'], 'plan' => '0', 'enabled' => true,
                'mixed'  => false, 'email' => 'reader@example.com', 'reference' => 'PROJECT-2026-014',
                'loaded' => true,
            ]);
        }

        $rules = match ($kind) {
            'input'    => ['title' => ['required', 'string', 'max:80'], 'quantity' => ['required', 'numeric', 'min:0', 'max:100']],
            'password' => ['password' => ['required', 'string', 'min:8']],
            'textarea' => ['notes' => ['required', 'string', 'max:500']],
            'checkbox' => ['agreed' => ['accepted'], 'roles' => ['required', 'array', 'min:1'], 'roles.*' => ['in:0,editor']],
            'radio'    => ['plan' => ['required', 'in:0,pro']],
            'switch'   => ['enabled' => ['accepted']],
            'label'    => ['email' => ['required', 'email', 'max:255'], 'reference' => ['nullable', 'string', 'max:80']],
            default    => [],
        };
        $validator = Validator::make($request->all(), $rules);
        $values = array_filter($request->only(['title', 'quantity', 'notes', 'agreed', 'plan', 'enabled', 'email', 'reference']), is_scalar(...));
        $roles = $request->input('roles');
        if (is_array($roles)) {
            $values['roles'] = array_values(array_filter($roles, is_string(...)));
        }

        if ($validator->fails()) {
            return redirect($destination)->withErrors($validator, 'sample-' . $kind)->with('sample-' . $kind, $values);
        }

        return redirect($destination)->with('sample-' . $kind, $values)->with('sample-success-' . $kind, true);
    }
}
