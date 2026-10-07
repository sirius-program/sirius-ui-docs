<x-layouts::app.sidebar :title="$title ?? null">
    <main id="docs-main" class="docs-main" tabindex="-1">{{ $slot }}</main>
</x-layouts::app.sidebar>
