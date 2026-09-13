@props(['language' => 'Blade', 'source' => null])
<div class="docs-code min-w-0 overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700" data-docs-code>
    <div class="flex items-center justify-between gap-4 border-b border-zinc-200 bg-zinc-50 px-4 py-2 text-xs dark:border-zinc-700 dark:bg-zinc-900">
        <span class="font-medium text-zinc-500 dark:text-zinc-400">{{ $language }}</span>
        <button type="button" data-copy-code class="rounded-md px-3 py-1.5 font-medium hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 dark:hover:bg-zinc-800" aria-label="Copy code">Copy</button>
        <span class="sr-only" role="status" data-copy-status></span>
    </div>
    <pre class="overflow-x-auto bg-white p-5 text-sm leading-7 dark:bg-zinc-950" tabindex="0" aria-label="{{ $language }} code example"><code>{{ $source ?? $slot }}</code></pre>
</div>
