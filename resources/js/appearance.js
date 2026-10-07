function syncAppearance() {
    window.SiriusDocsAppearance?.apply();
}
document.addEventListener('change', event => {
    if (event.target.matches?.('[data-docs-appearance]')) window.SiriusDocsAppearance?.set(event.target.value);
});
document.addEventListener('DOMContentLoaded', syncAppearance);
document.addEventListener('livewire:navigated', syncAppearance);
syncAppearance();
window.matchMedia('(min-width: 64rem)').addEventListener('change', event => {
    if (event.matches) document.dispatchEvent(new CustomEvent('dialog:hide', { detail: { id: 'docs-navigation' } }));
});
