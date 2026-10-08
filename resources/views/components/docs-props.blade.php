@props(['rows', 'note' => 'Accepts HTML5 attributes, Alpine events, data-*, ARIA, and supported Livewire bindings.'])
<div class="overflow-x-auto rounded-xl border border-slate-300 dark:border-slate-600">
    <table class="w-full text-left text-sm">
        <caption class="sr-only">Component keyword, types, requirements, defaults, and descriptions</caption>
        <thead class="bg-slate-50 text-xs text-slate-600 dark:bg-slate-900 dark:text-slate-400"><tr>
            @foreach (['Keyword', 'Type', 'Default', 'Description'] as $heading)<th scope="col" class="px-4 py-3 font-medium">{{ $heading }}</th>@endforeach
        </tr></thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
            @foreach ($rows as $row)<tr>
                <th scope="row" class="px-4 py-3 align-top font-mono text-xs font-medium">{{ $row[0] }}</th>
                <td class="px-4 py-3 align-top text-slate-500 dark:text-slate-400">{{ $row[1] }}</td>
                <td class="px-4 py-3 align-top font-mono text-xs">{{ $row[2] }}</td>
                <td class="min-w-64 px-4 py-3 align-top leading-6">{{ $row[3] }}</td>
            </tr>@endforeach
        </tbody>
    </table>
</div>
<p class="text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $note }}</p>