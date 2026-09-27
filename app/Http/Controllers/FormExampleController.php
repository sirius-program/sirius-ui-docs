<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class FormExampleController extends Controller
{
    public function index(Request $request): View
    {
        $data = $request->validate(['query' => ['nullable', 'string', 'max:80'], 'sample_action' => ['nullable', 'in:validate,load,reset']]);
        $query = match ($data['sample_action'] ?? 'validate') {
            'load'  => 'Website redesign',
            'reset' => '',
            default => $data['query'] ?? '',
        };

        return view('blade-components.form-docs', ['query' => $query]);
    }

    public function store(Request $request): RedirectResponse
    {
        $sample = $this->sample($request, ['project' => ['title' => 'Website redesign', 'budget' => '1250.50']]);
        if ($sample instanceof RedirectResponse) {
            return $sample;
        }
        $data = $request->validateWithBag('form-project', [
            'project.title'  => ['required', 'string', 'max:80'],
            'project.budget' => ['required', 'string', 'regex:/^[0-9]+(?:\.[0-9]{1,2})?$/D'],
        ]);

        return redirect()->route('blade-components.form')->withInput($data)->with('form-result', 'POST: ' . $data['project']['title'] . ' — ' . $data['project']['budget']);
    }

    public function update(Request $request): RedirectResponse
    {
        $group = $request->isMethod('PUT') ? 'replace' : 'rename';
        $sample = $this->sample($request, [$group => ['title' => 'Summer campaign']]);
        if ($sample instanceof RedirectResponse) {
            return $sample;
        }
        $data = $request->validateWithBag('form-' . $group, [$group . '.title' => ['required', 'string', 'max:80']]);

        return redirect()->route('blade-components.form')->withInput($data)->with('form-result', $request->method() . ': ' . $data[$group]['title']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $sample = $this->sample($request, ['archive' => ['confirmed' => true]]);
        if ($sample instanceof RedirectResponse) {
            return $sample;
        }
        $request->validateWithBag('form-archive', ['archive.confirmed' => ['accepted']]);

        return redirect()->route('blade-components.form')->with('form-result', 'DELETE: Demo draft archived.');
    }

    /** @param array<string, array<string, string|bool>> $values */
    private function sample(Request $request, array $values): ?RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);

        return $action === 'validate' ? null : redirect()->route('blade-components.form')->withInput($action === 'load' ? $values : []);
    }
}
