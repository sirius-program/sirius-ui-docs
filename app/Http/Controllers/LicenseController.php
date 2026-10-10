<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DocumentationSources;
use Illuminate\View\View;

final class LicenseController
{
    public function __invoke(DocumentationSources $sources): View
    {
        return view('license', [
            'packageLicense'       => $sources->packageLicense(),
            'packageNotices'       => $sources->packageNotices(),
            'documentationNotices' => $sources->documentationNotices(),
        ]);
    }
}
