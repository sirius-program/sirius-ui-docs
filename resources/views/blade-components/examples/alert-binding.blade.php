<x-docs-code language="PHP">public bool $noticeOpen = false;

public function save(): void
{
    // Validate and save your data.
    $this-&gt;dispatch('dialog:show', id: 'saved-alert');
}

public function hideNotice(): void
{
    $this-&gt;dispatch('dialog:hide', id: 'saved-alert');
}</x-docs-code>
<x-docs-code>&lt;x-sirius::button wire:click="save"&gt;Save settings&lt;/x-sirius::button&gt;
&lt;x-sirius::alert id="saved-alert" wire:key="saved-alert"
    title="Settings saved" text="Your project settings have been updated."
    variant="success" :closable="true" /&gt;

&lt;x-sirius::button wire:click="$set('noticeOpen', true)"&gt;Show notice&lt;/x-sirius::button&gt;
&lt;x-sirius::alert id="bound-alert" wire:key="bound-alert"
    title="Settings saved" text="Your project settings have been updated."
    variant="success" :closable="true" :open="$noticeOpen"
    x-on:dialog:close="if ($event.target === $el &amp;&amp; $wire.noticeOpen) $wire.set('noticeOpen', false)" /&gt;</x-docs-code>
