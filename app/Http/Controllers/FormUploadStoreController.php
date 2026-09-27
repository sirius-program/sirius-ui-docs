<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

final class FormUploadStoreController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $action = $request->input('sample_action', 'validate');
        abort_unless(in_array($action, ['validate', 'load', 'reset'], true), 422);
        if ($action !== 'validate') {
            return redirect()->route('blade-components.form')->withInput($action === 'load' ? ['upload' => ['title' => 'Project brief']] : []);
        }
        $data = $request->validateWithBag('form-upload', [
            'upload.title' => ['required', 'string', 'max:80'],
            'attachment'   => ['required', 'file', 'mimes:pdf,txt', 'max:2048'],
        ]);
        $file = $request->file('attachment');
        abort_unless($file instanceof UploadedFile, 422);

        return redirect()->route('blade-components.form')->withInput(['upload' => $data['upload']])
            ->with('form-result', 'POST: ' . $file->getClientOriginalName() . ' (' . $file->getSize() . ' bytes) validated.');
    }
}
