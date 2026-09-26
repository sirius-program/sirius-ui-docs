<x-sirius::file-upload id="blade-upload-attachments" name="attachments" label="Supporting documents" multiple error-bag="upload"
    accept="application/pdf,text/plain,image/jpeg,image/png" :max-size="2048" :max-files="3" helper="Up to three PDF, text, JPEG, or PNG files, 2 MiB each." error-key="attachments.*"
    :value="session('upload-existing') ? [['name' => 'sample.pdf', 'size' => 18810], ['name' => 'sample.txt', 'size' => 4], ['name' => 'sample.csv', 'size' => 4]] : []"
    x-on:file-upload:remove-existing="$el.closest('form').querySelectorAll('[name=&quot;keep_attachments[]&quot;]').forEach(input => { if (input.value === $event.detail.name) input.disabled = true })" />
