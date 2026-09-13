@props(['view', 'title'])
<div class="min-w-0 space-y-3" data-usage-example>
    <h4 class="font-medium">{{ $title }}</h4>
    <x-docs-code :source="trim(file_get_contents(app('view')->getFinder()->find($view)))" />
</div>
