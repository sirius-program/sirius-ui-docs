<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class BasicControlController extends Controller
{
    public function __invoke(string $control): View|RedirectResponse
    {
        $destination = match ($control) {
            'password'                    => 'input',
            'checkbox', 'radio', 'switch' => 'choices',
            default                       => null,
        };

        if ($destination !== null) {
            return to_route('components.control', ['control' => $destination]);
        }

        return view('components.basic-control-docs', [
            'control'  => $control,
            'title'    => $control === 'choices' ? 'Checkbox, Radio & Switch' : ucfirst($control),
            'examples' => match ($control) {
                'input'   => ['input', 'password'],
                'choices' => ['checkbox', 'radio', 'switch'],
                default   => ['textarea'],
            },
        ]);
    }
}
