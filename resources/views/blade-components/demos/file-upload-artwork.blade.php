<x-sirius::file-upload id="blade-upload-artwork" name="artwork" label="Project image" error-bag="upload"
    accept="image/jpeg,image/png" :max-size="2048" helper="Upload a JPEG or PNG image up to 2 MiB."
    :value="session('upload-existing') ? [['name' => 'sample.jpg', 'size' => 17547, 'url' => asset('sample/sample.jpg')]] : []" />
