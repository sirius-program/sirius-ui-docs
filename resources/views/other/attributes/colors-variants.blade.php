<div tabindex="0" role="region" aria-label="Presentation color equivalents" class="overflow-x-auto rounded-xl border border-slate-300 focus-visible:outline-2 focus-visible:outline-offset-2 dark:border-slate-600">
    <table class="w-full min-w-[40rem] text-left text-sm">
        <caption class="sr-only">Presentation variants and default Tailwind equivalents</caption>
        <thead class="bg-slate-100 dark:bg-slate-900"><tr><th scope="col" class="px-4 py-3">Variant</th><th scope="col" class="px-4 py-3">Family</th><th scope="col" class="px-4 py-3">Light</th><th scope="col" class="px-4 py-3">Dark</th></tr></thead>
        <tbody class="divide-y divide-slate-300 dark:divide-slate-600">
            @foreach (['primary' => 'sky', 'secondary' => 'indigo', 'success' => 'emerald', 'danger' => 'red', 'warning' => 'amber'] as $variant => $family)
                <tr>
                    <th scope="row" class="whitespace-nowrap px-4 py-3"><x-sirius::code>{{ $variant }}</x-sirius::code></th>
                    <td class="px-4 py-3">{{ $family }}</td>
                    <td class="px-4 py-3"><x-sirius::code>bg-{{ $family }}-100 text-{{ $family }}-900 border-{{ $family }}-300</x-sirius::code></td>
                    <td class="px-4 py-3"><x-sirius::code>bg-{{ $family }}-950 text-{{ $family }}-200 border-{{ $family }}-700</x-sirius::code></td>
                </tr>
            @endforeach
            <tr><th scope="row" class="whitespace-nowrap px-4 py-3"><x-sirius::code>info</x-sirius::code></th><td class="px-4 py-3">Surface mix</td><td colspan="2" class="px-4 py-3">Uses surface, text, and border tokens in each theme.</td></tr>
        </tbody>
    </table>
</div>
