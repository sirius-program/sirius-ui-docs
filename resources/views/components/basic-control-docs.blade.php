<x-layouts::app :title="$title">
    <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
        <header class="space-y-2">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">BASIC FORM CONTROLS</p>
            <h1 class="text-3xl font-semibold">{{ $title }}</h1>
            <p>Native form behavior, shared labels and validation, and Livewire bindings.</p>
        </header>
        @foreach ($examples as $example)
            <section id="{{ $example }}" data-control-demo="{{ $example }}" class="space-y-5">
                <h2 class="text-2xl font-semibold">{{ ucfirst($example) }}</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                    <h3 class="text-xl font-medium">Interactive {{ $example }} example</h3>
                    <livewire:examples.basic-controls-example :kind="$example" :key="'docs-'.$example" />
                </div>
                <div class="space-y-4">
                    <h3 class="text-xl font-medium">Usage and options</h3>
                    @include('components.examples.'.$example)
                </div>
            </section>
        @endforeach
        <section class="space-y-3">
            <h2 class="text-xl font-medium">Shared field contract</h2>
            <p>All controls accept a stable unique <code>id</code>, optional <code>label</code>, <code>helper</code>, <code>name</code>, <code>required</code>, <code>disabled</code>, and <code>readonly</code>. Repeated controls require distinct IDs. Use <code>:required="false"</code> to pass a false boolean.</p>
            <p>Use <code>size="sm|md|lg"</code> for visual sizing, <code>class</code> for control classes, and <code>wrapper-class</code> for field layout. Native input size is available through <code>control-size</code>. Native HTML attributes, Alpine attributes, data/ARIA attributes, and <code>wire:model</code> modifiers reach the actual input or textarea.</p>
            <p>Errors resolve from <code>error-key</code>, then the bound model path, then the normalized HTML name. Use <code>error-bag</code> for named Laravel bags and <code>:errors</code> for an explicit ViewErrorBag. Helper text remains visible with errors. <a class="underline" href="{{ route('components.forms') }}" wire:navigate>Read form conventions.</a></p>
            <p>Wrap related checkboxes or radios in <code>&lt;x-sirius::field group&gt;</code> and set the group's <code>label</code>, <code>required</code>, and <code>error-key</code>. The required marker and validation messages appear once on the group. Options share its error state and accessible descriptions. Required radio groups also apply native required validation to their options; checkbox groups require server validation for a minimum selection count, without requiring every checkbox.</p>
            <p>Supply initial ordinary Blade values using <code>:value="old('field', $default)"</code> or <code>:checked</code>. A bound Livewire property owns reactive values; do not also maintain separate checked/value state. Disabled controls are omitted from native submission; readonly controls retain their values.</p>
        </section>
        <section class="space-y-3">
            <h2 class="text-xl font-medium">Assets and interaction</h2>
            @if ($control === 'choices')
                <p>Checkboxes and radios gently pop when selected; switches slide smoothly between states. Motion respects the system's reduced-motion preference. Customize <code>--sir-choice-duration</code> (default <code>180ms</code>); set it to <code>0ms</code> to disable these animations. No additional library is required.</p>
            @endif
            <p>Import the package stylesheet and JavaScript once in your application build, or publish the <code>sirius-ui-assets</code> tag and load the published CSS and JavaScript. Docs imports both from the locally installed package.</p>
            <pre class="overflow-x-auto rounded-xl bg-zinc-100 p-5 text-sm dark:bg-zinc-900"><code>import '../../vendor/sirius/ui/dist/sirius.js';</code></pre>
            <p>The small package script handles password visibility, mixed checkbox state, and readonly choices. It requires no additional Alpine instance or external CDN and supports Livewire navigation and remounts. Load it before enabling user interaction with readonly choices; server validation and authorization remain necessary.</p>
            <p>Tab moves focus. Space toggles checkboxes and switches; arrow keys navigate native radio groups. For radio readonly, set the same readonly state on every option: one readonly Sirius radio locks user changes throughout its same-name/form group while allowing focus and server updates. Readonly is a UI constraint, not authorization.</p>
        </section>
        @if ($control === 'input')
            <section class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                <h2 class="text-xl font-medium">Ordinary Blade submission</h2>
                @include('components.examples.plain-form')
            </section>
        @endif
    </article>
</x-layouts::app>
