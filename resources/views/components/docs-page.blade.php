@props(['navigation'])
<div id="docs-top" class="mx-auto max-w-7xl space-y-12" data-docs-page>
    <div class="grid min-w-0 gap-8 xl:grid-cols-[minmax(0,1fr)_12rem] xl:gap-10">
        <div class="min-w-0 [&_p_code]:wrap-anywhere">{{ $slot }}</div>
        <aside class="order-first min-w-0 xl:order-last">
            <nav aria-label="On this page" data-docs-toc class="rounded-xl border border-slate-300 p-4 text-sm xl:sticky xl:top-24 xl:max-h-[calc(100vh-8rem)] xl:overflow-y-auto xl:rounded-none xl:border-0 xl:border-l xl:pl-5 dark:border-slate-600">
                <p class="mb-4 font-semibold">On this page</p>
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-1">
                    @foreach ($navigation as $group => $links)
                        <div class="space-y-2">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $group }}</p>
                            <ul class="space-y-2">
                                @foreach ($links as $id => $label)
                                    <li><a href="#{{ $id }}" class="block rounded-sm text-slate-600 hover:text-slate-950 focus-visible:outline-2 focus-visible:outline-offset-4 dark:text-slate-400 dark:hover:text-white">{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </nav>
        </aside>
    </div>
    <footer class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-300 py-6 text-sm text-slate-500 dark:border-slate-600 dark:text-slate-400">
        <p>Sirius UI &middot; Reusable components for Laravel Blade and Livewire. Created with ❤️ by <a href="https://fathulhusnan.com/">Fathul Husnan</a>.</p>
        <a href="#docs-top" class="underline underline-offset-4">Back to top</a>
    </footer>
</div>
