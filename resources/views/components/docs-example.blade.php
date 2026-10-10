@props(['view'])
<div class="min-w-0 space-y-3" data-usage-example>
    @include('examples.demo-source', ['exampleSource' => trim(file_get_contents(app('view')->getFinder()->find($view)))])
</div>
