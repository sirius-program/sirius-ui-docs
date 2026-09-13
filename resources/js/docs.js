const highlighted = new WeakSet();

function highlightCode() {
    document.querySelectorAll('[data-docs-code] code').forEach((code) => {
        if (highlighted.has(code)) return;
        highlighted.add(code);
        const source = code.textContent;
        const fragment = document.createDocumentFragment();
        // A small display tokenizer for our Blade/HTML and import examples; never execute sample markup.
        const tokens = /(\{\{[\s\S]*?\}\}|{{--[\s\S]*?--}}|<!--[\s\S]*?-->)|("(?:\\.|[^"\\])*"|'(?:\\.|[^'\\])*')|(<\/?[\w:-]+|\/?>)|(@[a-zA-Z]\w*|\$[a-zA-Z_]\w*)|([\w:.-]+)(?=\s*=)/g;
        let offset = 0;
        for (const match of source.matchAll(tokens)) {
            fragment.append(document.createTextNode(source.slice(offset, match.index)));
            const span = document.createElement('span');
            span.className = match[1] ? 'docs-token-expression' : match[2] ? 'docs-token-string'
                : match[3] ? 'docs-token-tag' : match[4] ? 'docs-token-expression' : 'docs-token-attribute';
            span.textContent = match[0];
            fragment.append(span);
            offset = match.index + match[0].length;
        }
        fragment.append(document.createTextNode(source.slice(offset)));
        code.replaceChildren(fragment);
    });
}

document.addEventListener('click', async (event) => {
    const button = event.target.closest?.('[data-copy-code]');
    if (!button) return;
    const block = button.closest('[data-docs-code]');
    const source = block.querySelector('code').textContent;
    const status = block.querySelector('[data-copy-status]');
    try {
        if (!navigator.clipboard?.writeText) throw new Error('Clipboard unavailable');
        await navigator.clipboard.writeText(source);
        button.textContent = 'Copied';
        status.textContent = 'Code copied to clipboard.';
    } catch {
        // Leave a selectable sample available when clipboard permissions are denied.
        const range = document.createRange();
        range.selectNodeContents(block.querySelector('code'));
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        button.textContent = 'Select & copy';
        status.textContent = 'Clipboard unavailable. Code selected; press Ctrl+C or Command+C to copy.';
    }
});

highlightCode();
document.addEventListener('livewire:navigated', highlightCode);
