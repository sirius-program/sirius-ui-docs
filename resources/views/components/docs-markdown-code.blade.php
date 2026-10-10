@if ($block)
    <pre tabindex="0" class="overflow-x-auto rounded-lg border border-slate-300 p-4 text-sm dark:border-slate-600"><x-sirius::code block :text="$source" :class="$language === null ? '' : 'language-'.$language" /></pre>
@else
    <x-sirius::code :text="$source" />
@endif
