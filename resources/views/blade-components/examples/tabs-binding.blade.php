<x-docs-code language="Blade">&lt;x-sirius::tabs id="project" wire:key="project" :items="['overview' =&gt; 'Overview', 'notes' =&gt; 'Notes']" :active="$tab"
    x-on:tabs:change="if ($event.target === $el) $wire.set('tab', $event.detail.value)"&gt;
    &lt;x-slot:panel-overview&gt;Project overview&lt;/x-slot:panel-overview&gt;
    &lt;x-slot:panel-notes&gt;Project notes&lt;/x-slot:panel-notes&gt;
&lt;/x-sirius::tabs&gt;</x-docs-code>
