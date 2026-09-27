<?php

declare(strict_types=1);

namespace App\Support;

final class SliderSample
{
    /** @return array<string, list<string>> */
    public static function rules(): array
    {
        return [
            'discount' => ['required', 'numeric', 'between:0,50', 'multiple_of:5'],
            'budget'   => ['required', 'array', 'size:2', 'list'],
            'budget.0' => ['required', 'numeric', 'between:0,200', 'multiple_of:5', 'lte:budget.1'],
            'budget.1' => ['required', 'numeric', 'between:20,300', 'multiple_of:20'],
        ];
    }
}
