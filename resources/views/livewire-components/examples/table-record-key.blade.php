@php
    $recordKeySource = <<<'PHP'
protected function recordKey(array|object $record): int|string
{
    return parent::recordKey(['id' => data_get($record, 'uuid')]);
}
PHP;
@endphp
<x-docs-code language="PHP" :source="$recordKeySource" />
