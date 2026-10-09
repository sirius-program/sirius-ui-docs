<x-sirius::breadcrumb label="Project location" separator="/" id="project-breadcrumb">
    <x-sirius::breadcrumb.item :link="route('dashboard')">Dashboard</x-sirius::breadcrumb.item>
    <x-sirius::breadcrumb.item :link="route('started.introduction')">Projects</x-sirius::breadcrumb.item>
    <x-sirius::breadcrumb.item current>Website redesign</x-sirius::breadcrumb.item>
</x-sirius::breadcrumb>
