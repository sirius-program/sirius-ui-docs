<x-sirius::badge :variant="match (data_get($record, 'status')) { 'paid' => 'success', 'overdue' => 'danger', default => 'warning' }">{{ ucfirst(data_get($record, 'status')) }}</x-sirius::badge>
