@props(['navigation'])
<div id="docs-top" class="mx-auto max-w-7xl space-y-12" data-docs-page>
    <div class="grid min-w-0 gap-8 xl:grid-cols-[minmax(0,1fr)_12rem] xl:gap-10">
        <div class="min-w-0">{{ $slot }}</div>
        <aside class="order-first min-w-0 xl:order-last">
            <nav aria-label="On this page" data-docs-toc class="rounded-xl border border-zinc-200 p-4 text-sm xl:sticky xl:top-24 xl:max-h-[calc(100vh-8rem)] xl:overflow-y-auto xl:rounded-none xl:border-0 xl:border-l xl:pl-5 dark:border-zinc-700">
                <p class="mb-4 font-semibold">On this page</p>
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-1">
                    @foreach ($navigation as $group => $links)
                        <div class="space-y-2">
                            <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">{{ $group }}</p>
                            <ul class="space-y-2">
                                @foreach ($links as $id => $label)
                                    <li><a href="#{{ $id }}" class="block rounded-sm text-zinc-600 hover:text-zinc-950 focus-visible:outline-2 focus-visible:outline-offset-4 dark:text-zinc-400 dark:hover:text-white">{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </nav>
        </aside>
    </div>
    <footer class="flex flex-wrap items-center justify-between gap-3 border-t border-zinc-200 py-6 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
        <p>Sirius UI &middot; Reusable components for Laravel.</p>
        <a href="#docs-top" class="underline underline-offset-4">Back to top</a>
    </footer>
</div>
