<p>Textarea is plain text by default. It supports <code>rows</code>, <code>cols</code>, <code>maxlength</code>, <code>wrap</code>, and <code>resize="none|vertical|horizontal|both"</code> (default vertical). Horizontal resizing stays within the field width.</p>
<pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::textarea id="notes" name="notes" label="Notes"
    rows="5" maxlength="500" resize="vertical" :value="old('notes')" /&gt;

&lt;x-sirius::textarea id="live-notes" label="Notes" wire:model="notes" /&gt;@endverbatim</code></pre>
<p>For plain Blade, pass an escaped <code>value</code> or default slot content; a non-null value takes precedence. Bound Livewire state owns content. <code>richtext=true</code> is reserved for Phase 7 and currently reports an unsupported configuration.</p>
