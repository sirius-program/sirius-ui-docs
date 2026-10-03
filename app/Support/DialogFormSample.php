<?php

declare(strict_types=1);

namespace App\Support;

use Sirius\Ui\Rules\PhoneNumber;

final class DialogFormSample
{
    /** @return array<string, mixed> */
    public static function values(): array
    {
        return [
            'title'       => '', 'seats' => 5, 'password' => '', 'budget' => '1250.50',
            'phone'       => '+6281234567890', 'date' => '2028-10-15', 'time' => '09:00',
            'appointment' => '2028-10-15 09:00:00', 'notes' => 'Please send the draft before the meeting.',
            'brief'       => '<p>Prepare a <strong>website redesign</strong> proposal.</p>',
            'delivery'    => 'standard', 'services' => ['design'], 'agreed' => false,
            'access'      => ['reader'], 'plan' => 'free', 'notifications' => true,
            'discount'    => 10, 'range' => [40, 160],
        ];
    }

    /** @return array<string, list<string|PhoneNumber>> */
    public static function rules(): array
    {
        return [
            'sample.title'         => ['required', 'string', 'max:80'],
            'sample.seats'         => ['required', 'integer', 'between:1,100'],
            'sample.password'      => ['nullable', 'string', 'min:8', 'max:100'],
            'sample.budget'        => ['required', 'string', 'regex:/^[0-9]+(?:\.[0-9]{1,2})?$/D'],
            'sample.phone'         => ['required', new PhoneNumber(['62', '44'])],
            'sample.date'          => ['required', 'date_format:Y-m-d'],
            'sample.time'          => ['required', 'date_format:H:i'],
            'sample.appointment'   => ['required', 'date_format:Y-m-d H:i:s'],
            'sample.notes'         => ['nullable', 'string', 'max:2000'],
            'sample.brief'         => ['nullable', 'string', 'max:10000'],
            'sample.delivery'      => ['required', 'in:standard,express'],
            'sample.services'      => ['required', 'array', 'min:1'],
            'sample.services.*'    => ['in:design,development'],
            'sample.agreed'        => ['accepted'],
            'sample.access'        => ['required', 'array', 'min:1'],
            'sample.access.*'      => ['in:reader,editor'],
            'sample.plan'          => ['required', 'in:free,pro'],
            'sample.notifications' => ['boolean'],
            'sample.discount'      => ['required', 'numeric', 'between:0,50', 'multiple_of:5'],
            'sample.range'         => ['required', 'array', 'size:2', 'list'],
            'sample.range.0'       => ['required', 'numeric', 'between:0,200', 'multiple_of:5', 'lte:sample.range.1'],
            'sample.range.1'       => ['required', 'numeric', 'between:20,300', 'multiple_of:20'],
            'attachment'           => ['nullable', 'file', 'mimes:pdf,txt,jpg,jpeg,png', 'max:2048'],
        ];
    }
}
