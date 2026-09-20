<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Validation\Rule;

final class SelectCatalog
{
    /** @return list<array{value: string, label: string, disabled?: bool, group?: string}> */
    public static function shipping(): array
    {
        return [
            ['value' => '0', 'label' => 'Collect from store', 'group' => 'Local'],
            ['value' => 'standard', 'label' => 'Standard delivery', 'group' => 'Delivery'],
            ['value' => 'express', 'label' => 'Express delivery', 'group' => 'Delivery'],
            ['value' => 'drone', 'label' => 'Drone delivery (unavailable)', 'disabled' => true, 'group' => 'Delivery'],
        ];
    }

    /** @return list<array{value: string, label: string}> */
    public static function topics(): array
    {
        return [['value' => 'design', 'label' => 'Design'], ['value' => 'engineering', 'label' => 'Engineering'], ['value' => 'research', 'label' => 'Research']];
    }

    /** @return list<array{value: string, label: string}> */
    public static function venues(): array
    {
        return [
            ['value' => 'jakarta', 'label' => 'Jakarta conference hall'],
            ['value' => 'bandung', 'label' => 'Bandung creative studio'],
            ['value' => 'bali', 'label' => 'Bali garden pavilion'],
            ['value' => 'surabaya', 'label' => 'Surabaya meeting hub'],
            ['value' => 'yogyakarta', 'label' => 'Yogyakarta cultural center'],
        ];
    }

    /** @return array<string, list<mixed>> */
    public static function rules(): array
    {
        return [
            'shipping' => ['required', Rule::in(['0', 'standard', 'express'])],
            'topics'   => ['required', 'array', 'min:1'],
            'topics.*' => ['string', 'distinct', Rule::in(array_column(self::topics(), 'value'))],
            'venue'    => ['required', Rule::in(array_column(self::venues(), 'value'))],
        ];
    }
}
