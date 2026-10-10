<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DocumentationMarkdown;
use App\Support\DocumentationSources;
use Illuminate\View\View;

final class ChangelogController
{
    public function __invoke(DocumentationSources $sources, DocumentationMarkdown $markdown): View
    {
        $package = $sources->packageChangelog();
        $documentation = $sources->documentationChangelog();

        return view('changelog', [
            'packageChangelog'       => $package === null ? null : $markdown->render($package),
            'documentationChangelog' => $documentation === null ? null : $markdown->render($documentation),
        ]);
    }
}
