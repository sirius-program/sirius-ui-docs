<x-docs-code language="PHP">
@verbatim
// Inside an authorized application controller:
$request->validate([
    'brief' => ['required', 'file', 'mimes:pdf,txt', 'max:2048'],
    'attachments' => ['nullable', 'array', 'max:3'],
    'attachments.*' => ['file', 'mimes:pdf,txt', 'max:2048'],
]);
$path = $request->file('brief')->store('project-documents', 'local');

// Inside an authorized Livewire action using WithFileUploads:
$this->validate(['brief' => ['required', 'file', 'mimes:pdf,txt', 'max:2048']]);
$path = $this->brief->store('project-documents', 'local');
@endverbatim
</x-docs-code>
