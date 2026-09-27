<x-sirius::richtext
    id="blade-signature"
    name="signature"
    label="Signature"
    :toolbar="['bold', 'italic', 'link']"
    :height="100"
    :value="session('sample-richtext.signature', '')"
    error-bag="richtext"
    maxlength="2000"
/>
