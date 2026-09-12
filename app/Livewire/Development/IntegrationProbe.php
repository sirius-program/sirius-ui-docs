<?php

declare(strict_types=1);

namespace App\Livewire\Development;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

final class IntegrationProbe extends Component
{
    use WithFileUploads;

    public string $date = '2026-09-12';

    public string $choice = 'alpha';

    public string $html = '<p>Initial content</p>';

    public ?TemporaryUploadedFile $upload = null;

    public bool $visible = true;

    #[Locked]
    public string $sanitized = '';

    public function resetValues(): void
    {
        $this->date = '2026-10-01';
        $this->choice = 'beta';
        $this->html = '<p>Server reset</p>';
        $this->upload = null;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate([
            'date'   => ['required', 'date_format:Y-m-d'],
            'choice' => ['required', 'in:alpha,beta'],
            'html'   => ['required', 'string', 'max:10000'],
            'upload' => ['nullable', 'file', 'mimes:txt', 'max:64'],
        ]);

        $this->sanitized = new HtmlSanitizer(
            new HtmlSanitizerConfig()->allowSafeElements(),
        )->sanitize($this->html);
    }

    public function render(): View
    {
        return view('livewire.development.integration-probe');
    }
}
