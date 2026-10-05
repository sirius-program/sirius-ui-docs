<div>
    @include('livewire-components.demos.table-bulk')
</div>
@script
<script>
    const tableId = @js($tableId);
    let requests = 0;
    $wire.$interceptMessage(({ onFinish }) => {
        requests++;
        document.dispatchEvent(new CustomEvent('table:loading', { detail: { id: tableId, loading: true } }));
        onFinish(() => {
            requests--;
            document.dispatchEvent(new CustomEvent('table:loading', { detail: { id: tableId, loading: requests > 0 } }));
        });
    });
</script>
@endscript
