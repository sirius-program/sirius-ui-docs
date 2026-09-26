<form method="POST" action="{{ route('blade-components.file-upload.store') }}" enctype="multipart/form-data" novalidate class="space-y-5" data-blade-upload>
    @csrf
    <input type="hidden" name="keep_brief" value="{{ session('upload-existing') ? '1' : '0' }}">
    @if (session('upload-existing'))
        @foreach (['sample.pdf', 'sample.txt', 'sample.csv'] as $filename)
            <input type="hidden" name="keep_attachments[]" value="{{ $filename }}">
        @endforeach
    @endif
    @include('blade-components.demos.file-upload-brief')
    @include('blade-components.demos.file-upload-attachments')
    @include('blade-components.demos.file-upload-artwork')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('upload-saved'))<p role="status">{{ session('upload-saved') }}</p>@endif
</form>
