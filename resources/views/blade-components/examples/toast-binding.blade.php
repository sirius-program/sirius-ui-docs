<x-docs-code language="PHP">public bool $noticeOpen = false;

public function save(): void
{
    // Validate and save your data.
    $this-&gt;dispatch('toast:show', id: 'saved-notice');
}

public function hideNotice(): void
{
    $this-&gt;dispatch('toast:hide', id: 'saved-notice');
}</x-docs-code>
<x-docs-code>&lt;x-sirius::toast id="saved-notice" wire:key="saved-notice"
    title="Saved" text="Your changes have been saved." /&gt;

&lt;x-sirius::toast id="bound-notice" wire:key="bound-notice"
    text="Your changes have been saved." :open="$noticeOpen"
    x-on:toast:close="if ($event.target === $el) $wire.set('noticeOpen', false)" /&gt;</x-docs-code>
