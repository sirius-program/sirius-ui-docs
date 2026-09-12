<x-layouts::app :title="__('Components')">
    <div class="mx-auto flex max-w-3xl flex-col gap-6">
        <h1 class="text-2xl font-semibold">Sirius UI components</h1>
        <p>Reusable Blade and Livewire components. The local package is connected; public components will be added as their implementation phases are completed.</p>
        <section class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
            <h2 class="text-lg font-medium">Getting started</h2>
            <p class="mt-2">Use the documentation README for local installation, assets, architecture rules, and the implementation checklist.</p>
        </section>
        <section class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
            <h2 class="text-lg font-medium">Component index</h2>
            <ul class="mt-3 space-y-3">
                <li><a class="underline" href="{{ route('components.label') }}" wire:navigate>Label</a> — accessible labels and required markers.</li>
                <li><a class="underline" href="{{ route('components.forms') }}" wire:navigate>Form conventions</a> — shared field layout, helper text, validation errors, and native attributes.</li>
                @foreach (['input' => 'Input (text, number, password)', 'textarea' => 'Textarea', 'choices' => 'Checkbox, Radio & Switch'] as $control => $controlLabel)
                    <li><a class="underline" href="{{ route('components.control', ['control' => $control]) }}" wire:navigate>{{ $controlLabel }}</a></li>
                @endforeach
            </ul>
            <p class="mt-4">Basic controls are available. Currency and enhanced widgets follow in later phases.</p>
        </section>
    </div>
</x-layouts::app>
