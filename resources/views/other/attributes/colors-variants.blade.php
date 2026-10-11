<div tabindex="0" role="region" aria-label="Presentation color equivalents" class="docs-table-wrapper">
    <table class="docs-table min-w-[40rem]">
        <caption class="sr-only">Presentation variants and default Tailwind equivalents</caption>
        <thead><tr><th scope="col">Variant</th><th scope="col">Family</th><th scope="col">Light</th><th scope="col">Dark</th></tr></thead>
        <tbody>
            @foreach (['primary' => 'sky', 'secondary' => 'indigo', 'success' => 'emerald', 'danger' => 'red', 'warning' => 'amber'] as $variant => $family)
                <tr>
                    <th scope="row" class="whitespace-nowrap"><x-sirius::code>{{ $variant }}</x-sirius::code></th>
                    <td>{{ $family }}</td>
                    <td><x-sirius::code>bg-{{ $family }}-100 text-{{ $family }}-900 border-{{ $family }}-300</x-sirius::code></td>
                    <td><x-sirius::code>bg-{{ $family }}-950 text-{{ $family }}-200 border-{{ $family }}-700</x-sirius::code></td>
                </tr>
            @endforeach
            <tr><th scope="row" class="whitespace-nowrap"><x-sirius::code>info</x-sirius::code></th><td>Surface mix</td><td colspan="2">Uses surface, text, and border tokens in each theme.</td></tr>
        </tbody>
    </table>
</div>
