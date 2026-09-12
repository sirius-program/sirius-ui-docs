<p>Use <code>input type="password"</code>. The eye button uses Blade Heroicons, never submits its form, preserves the value and selection, and returns focus to the input. Its accessible name changes between Show password and Hide password.</p>
<pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>@verbatim&lt;x-sirius::input id="password" type="password" name="password"
    label="Password" required minlength="8" autocomplete="new-password"
    show-label="Show password" hide-label="Hide password"
    wire:model="password" /&gt;@endverbatim</code></pre>
<p><code>show-label</code> and <code>hide-label</code> can be translated by your application. Initial display is masked; native form reset masks it again. Livewire updates preserve visibility on the existing input; remounting starts masked. Avoid repopulating real passwords from session old input or placing them in logs and status output.</p>
