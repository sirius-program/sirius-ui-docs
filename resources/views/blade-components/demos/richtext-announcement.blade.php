<x-sirius::richtext
    id="blade-announcement"
    name="body"
    label="Team announcement"
    :toolbar="['bold', 'italic', 'underline', 'strike', 'heading', 'bulletList', 'orderedList', 'blockquote', 'codeBlock', 'link', 'image', 'undo', 'redo']"
    :upload-url="route('blade-components.richtext.images.store')"
    required
    :value="session('sample-richtext.body', '')"
    error-bag="richtext"
    placeholder="Share the latest project update…"
    helper="Format the update before sharing it with your team."
    maxlength="10000"
/>
