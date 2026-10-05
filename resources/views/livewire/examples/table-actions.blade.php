<div>
    @include('livewire-components.demos.table')
</div>
@script
<script>
    let requests = 0;
    $wire.$interceptMessage(({ onFinish }) => {
        requests++;
        document.dispatchEvent(new CustomEvent('table:loading', { detail: { id: 'invoice-table', loading: true } }));
        onFinish(() => {
            requests--;
            document.dispatchEvent(new CustomEvent('table:loading', { detail: { id: 'invoice-table', loading: requests > 0 } }));
        });
    });
</script>
@endscript
