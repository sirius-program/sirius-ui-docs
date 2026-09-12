<p><code>input</code> accepts <code>type="text|number|password"</code>; text is the default. Use native min/max/step, pattern, maxlength, autocomplete, and inputmode as applicable. Server-side validation must enforce your rules.</p>
<pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::input id="weight" name="weight" label="Weight"
    type="number" min="0" max="100" step="0.5"
    prefix="Net" suffix="kg" wire:model.number="weight" /&gt;

&lt;x-sirius::input id="username" name="username" label="Username"&gt;
    &lt;x-slot:prefix&gt;@&lt;/x-slot:prefix&gt;
&lt;/x-sirius::input&gt;@endverbatim</code></pre>
<p><code>prefix</code> and <code>suffix</code> accept escaped strings or named slots; slots take precedence. They are visual adornments and never become part of the submitted value. For essential units, also describe them in the label or helper. Long adornments wrap within the field.</p>
