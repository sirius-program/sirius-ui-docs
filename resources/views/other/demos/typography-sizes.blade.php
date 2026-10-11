<div tabindex="0" role="region" aria-label="Font-size scale" class="docs-table-wrapper" data-typography-sizes>
    <table class="docs-table">
        <caption>Font-size scale</caption>
        <thead>
            <tr><th scope="col">Size</th><th scope="col">Default</th><th scope="col">Preview</th></tr>
        </thead>
        <tbody>
            @foreach (['xs' => '0.75rem', 'sm' => '0.875rem', 'base' => '1rem', 'lg' => '1.125rem', 'xl' => '1.25rem'] as $size => $default)
                <tr>
                    <th scope="row"><x-sirius::code>{{ $size }}</x-sirius::code></th>
                    <td><x-sirius::code>{{ $default }}</x-sirius::code></td>
                    <td><span class="typography-size-{{ $size }}" data-typography-size>Project update</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
