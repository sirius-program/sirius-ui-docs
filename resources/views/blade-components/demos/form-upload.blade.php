<x-sirius::form :action="route('blade-components.form.upload')" method="POST" sending-file id="form-upload" class="space-y-4" novalidate>
    <x-sirius::input name="upload[title]" label="Document title" :value="is_string(old('upload.title')) ? old('upload.title') : null" required error-bag="form-upload" />
    <x-sirius::file-upload id="form-attachment" name="attachment" label="Project document" accept="application/pdf,text/plain" :max-size="2048" required error-bag="form-upload" helper="Choose a PDF or text file up to 2 MiB." />
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
</x-sirius::form>