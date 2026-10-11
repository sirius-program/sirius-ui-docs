@props(['rows', 'note' => 'Accepts HTML5 attributes, Alpine events, data-*, ARIA, and supported Livewire bindings.'])
<div tabindex="0" role="region" aria-label="Component attributes" class="docs-table-wrapper">
    <table class="docs-table">
        <caption class="sr-only">Component keyword, types, requirements, defaults, and descriptions</caption>
        <thead><tr>
            @foreach (['Keyword', 'Type', 'Default', 'Description'] as $heading)<th scope="col">{{ $heading }}</th>@endforeach
        </tr></thead>
        <tbody>
            @foreach ($rows as $row)<tr>
                <th scope="row" class="font-mono">{{ $row[0] }}</th>
                <td>{{ $row[1] }}</td>
                <td class="font-mono">{{ $row[2] }}</td>
                <td class="min-w-64">{{ $row[3] }}</td>
            </tr>@endforeach
        </tbody>
    </table>
</div>
<p class="text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $note }}</p>