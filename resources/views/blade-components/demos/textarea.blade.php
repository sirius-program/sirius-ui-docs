<x-sirius::textarea id="blade-textarea-notes" name="notes" label="Project brief"
    placeholder="Describe the next project milestone." :value="session('sample-textarea.notes', '')"
    error-bag="sample-textarea" helper="Plain text, up to 500 characters."
    required rows="4" cols="40" maxlength="500" />
