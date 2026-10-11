<div tabindex="0" role="region" aria-label="Font size CSS tokens" class="overflow-x-auto rounded-xl border border-slate-300 focus-visible:outline-2 focus-visible:outline-offset-2 dark:border-slate-600">
    <table class="w-full min-w-[40rem] text-left text-sm">
        <caption class="sr-only">Font size tokens and defaults</caption>
        <thead class="bg-slate-100 dark:bg-slate-900"><tr><th scope="col" class="px-4 py-3">Token</th><th scope="col" class="px-4 py-3">Default</th><th scope="col" class="px-4 py-3">Used for</th></tr></thead>
        <tbody class="divide-y divide-slate-300 dark:divide-slate-600">
            @foreach ([
                ['--sir-font-size-xs', '0.75rem', 'Small badges, menu headings, and label status'],
                ['--sir-font-size-sm', '0.875rem', 'Small controls, helper text, navigation, and tables'],
                ['--sir-font-size-base', '1rem', 'Default fields, buttons, and alert text'],
                ['--sir-font-size-lg', '1.125rem', 'Large fields and buttons'],
                ['--sir-font-size-xl', '1.25rem', 'Alert titles'],
                ['--sir-richtext-heading-font-size', '1.3em', 'Richtext headings, relative to the editor text'],
                ['--sir-richtext-badge-font-size', '0.625rem', 'Richtext UI badges'],
                ['--sir-richtext-large-button-font-size', '0.9375rem', 'Large Richtext UI buttons'],
                ['--sir-avatar-font-scale', '0.35', 'Avatar text size as a fraction of the avatar size'],
            ] as [$token, $default, $usage])
                <tr><th scope="row" class="whitespace-nowrap px-4 py-3"><x-sirius::code>{{ $token }}</x-sirius::code></th><td class="px-4 py-3"><x-sirius::code>{{ $default }}</x-sirius::code></td><td class="px-4 py-3">{{ $usage }}</td></tr>
            @endforeach
        </tbody>
    </table>
</div>
