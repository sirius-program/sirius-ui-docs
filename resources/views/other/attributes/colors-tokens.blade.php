<div tabindex="0" role="region" aria-label="Widget and layout color tokens" class="docs-table-wrapper">
    <table class="docs-table min-w-[48rem]">
        <caption class="sr-only">Shared widget and layout color defaults</caption>
        <thead><tr><th scope="col">Token</th><th scope="col">Light</th><th scope="col">Dark</th></tr></thead>
        <tbody>
            @foreach ([
                ['--sir-color-primary', 'oklch(0.55 0.2 260)', 'oklch(0.7 0.16 250)'],
                ['--sir-color-primary-hover', 'oklch(0.49 0.2 260)', 'oklch(0.76 0.14 250)'],
                ['--sir-color-on-primary', 'oklch(0.98 0.01 260)', 'oklch(0.18 0.02 260)'],
                ['--sir-color-surface', 'oklch(0.99 0.005 260)', 'oklch(0.2 0.02 260)'],
                ['--sir-color-text', 'oklch(0.24 0.02 260)', 'oklch(0.96 0.01 260)'],
                ['--sir-color-muted', 'var(--color-slate-600)', 'var(--color-slate-300)'],
                ['--sir-color-border', 'var(--color-slate-300)', 'var(--color-slate-600)'],
                ['--sir-color-danger', 'var(--color-red-700)', 'var(--color-red-400)'],
                ['--sir-focus-ring', 'oklch(0.7 0.16 250)', 'oklch(0.78 0.13 245)'],
            ] as [$token, $light, $dark])
                <tr><th scope="row" class="whitespace-nowrap"><x-sirius::code>{{ $token }}</x-sirius::code></th><td><x-sirius::code>{{ $light }}</x-sirius::code></td><td><x-sirius::code>{{ $dark }}</x-sirius::code></td></tr>
            @endforeach
        </tbody>
    </table>
</div>
