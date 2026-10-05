<x-sirius::button size="sm" icon="heroicon-o-pencil-square" aria-label="Review {{ data_get($record, 'number') }}" wire:click="$dispatch('invoice:dialog', { id: {{ data_get($record, 'id') }} })" />
<x-sirius::button size="sm" icon="heroicon-o-envelope" aria-label="Remind {{ data_get($record, 'number') }}" wire:click="$dispatch('invoice:alert', { id: {{ data_get($record, 'id') }} })" />
<x-sirius::button size="sm" icon="heroicon-o-eye" aria-label="Details {{ data_get($record, 'number') }}" wire:click="$dispatch('invoice:slideover', { id: {{ data_get($record, 'id') }} })" />
<x-sirius::button size="sm" as="a" icon="heroicon-o-arrow-top-right-on-square" aria-label="Open {{ data_get($record, 'number') }}" href="#" />
