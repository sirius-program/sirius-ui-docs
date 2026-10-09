@props(['sidebar' => false])
<x-sirius::link :attributes="$attributes->class(['docs-brand'])">
    <span class="docs-brand-icon"><x-app-logo-icon class="size-5 fill-current" /></span>
    <span>{{ config('app.name', 'Sirius UI') }}</span>
</x-sirius::link>
