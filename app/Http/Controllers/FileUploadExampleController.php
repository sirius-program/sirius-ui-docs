<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class FileUploadExampleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->validate(['action' => ['required', 'in:validate,load,reset']])['action'];
        if ($action === 'load') {
            return back()->with('upload-existing', true);
        }
        if ($action === 'reset') {
            return back();
        }
        $retained = $request->session()->get('upload-existing')
            ? count(array_intersect(['sample.pdf', 'sample.txt', 'sample.csv'], array_filter($request->array('keep_attachments'), is_string(...))))
            : 0;
        $request->validateWithBag('upload', [
            'brief'         => [$request->session()->get('upload-existing') && $request->boolean('keep_brief') ? 'nullable' : 'required', 'file', 'mimes:pdf,txt', 'max:2048'],
            'artwork'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'attachments'   => ['nullable', 'array', 'max:' . (3 - $retained)],
            'attachments.*' => ['file', 'mimes:pdf,txt,jpg,jpeg,png', 'max:2048'],
        ]);

        return back()->with('upload-saved', 'Project documents validated. Nothing was stored.');
    }
}
