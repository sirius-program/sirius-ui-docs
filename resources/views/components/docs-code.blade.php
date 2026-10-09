@props(['language' => 'Blade', 'source' => null])
<div class="docs-code min-w-0 overflow-hidden rounded-xl border border-slate-300 dark:border-slate-600" data-docs-code>
    <div class="flex items-center justify-between gap-4 border-b border-slate-300 bg-slate-50 px-4 py-2 text-xs dark:border-slate-600 dark:bg-slate-900">
        <span class="font-medium text-slate-500 dark:text-slate-400">{{ $language }}</span>
        <button type="button" data-copy-code class="rounded-md px-3 py-1.5 font-medium hover:bg-slate-200 focus-visible:outline-2 focus-visible:outline-offset-2 dark:hover:bg-slate-800" aria-label="Copy code">Copy</button>
        <span class="sr-only" role="status" data-copy-status></span>
    </div>
    <pre class="overflow-x-auto bg-white p-5 text-sm leading-7 dark:bg-slate-950" tabindex="0" aria-label="{{ $language }} code example"><x-sirius::code block :text="$source">{{ $slot }}</x-sirius::code></pre>
</div>
