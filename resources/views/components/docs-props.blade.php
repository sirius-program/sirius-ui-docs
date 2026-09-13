@props(['rows', 'note' => 'Applicable HTML5, Alpine, data-* and ARIA attributes, and supported Livewire directives (such as wire:model and its modifiers) are forwarded to the native control. Use wrapper-class for the field wrapper.'])
<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-left text-sm">
            <caption class="sr-only">Component attributes, types, requirements, defaults, and descriptions</caption>
            <thead class="bg-zinc-50 text-xs text-zinc-600 dark:bg-zinc-900 dark:text-zinc-400"><tr>
                @foreach (['Attributes', 'Type', 'Mandatory', 'Default', 'Description'] as $heading)<th scope="col" class="px-4 py-3 font-medium">{{ $heading }}</th>@endforeach
            </tr></thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @foreach ($rows as $row)<tr>
                    <th scope="row" class="px-4 py-3 align-top font-mono text-xs font-medium">{{ $row[0] }}</th>
                    <td class="px-4 py-3 align-top text-zinc-500 dark:text-zinc-400">{{ $row[1] }}</td>
                    <td class="px-4 py-3 align-top text-xs"><span class="inline-block rounded-md bg-zinc-100 px-2 py-1 dark:bg-zinc-800">{{ $row[4] }}</span></td>
                    <td class="px-4 py-3 align-top font-mono text-xs">{{ $row[2] }}</td>
                    <td class="min-w-64 px-4 py-3 align-top leading-6">{{ $row[3] }}</td>
                </tr>@endforeach
            </tbody>
        </table>
    </div>
    <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-400">{{ $note }}</p>
</section>
