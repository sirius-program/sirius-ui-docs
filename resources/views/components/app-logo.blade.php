@props(['sidebar' => false])
<a {{ $attributes->class(['docs-brand']) }}>
    <span class="docs-brand-icon"><x-app-logo-icon class="size-5 fill-current" /></span>
    <span>{{ config('app.name', 'Sirius UI') }}</span>
</a>
