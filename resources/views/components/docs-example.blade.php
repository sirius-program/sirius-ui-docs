@props(['view'])
<div class="min-w-0 space-y-3" data-usage-example>
    <x-docs-code :source="trim(file_get_contents(app('view')->getFinder()->find($view)))" />
</div>
