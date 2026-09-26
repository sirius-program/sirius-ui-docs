<x-sirius::file-upload id="blade-upload-brief" name="brief" label="Project brief" required error-bag="upload"
    accept="application/pdf,text/plain" :max-size="2048" helper="Upload a PDF or text document up to 2 MiB."
    :value="session('upload-existing') ? [['name' => 'sample.pdf', 'size' => 18810, 'url' => asset('sample/sample.pdf')]] : []"
    x-on:file-upload:remove-existing="$el.form.querySelector('[name=keep_brief]').value = '0'" />
