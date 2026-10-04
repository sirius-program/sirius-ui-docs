<div class="space-y-4" x-data="{ action: 'No action selected' }">
    <x-sirius::dropdown id="invoice-actions" trigger="Invoice actions">
        <x-sirius::dropdown.item id="invoice-copy" name="Copy invoice number" icon="heroicon-o-clipboard-document" trailing="⌘ C" x-on:click="action = 'Invoice #1042 copied'" />
        <x-sirius::dropdown.item id="invoice-export" name="Export" icon="heroicon-o-arrow-down-tray">
            <x-slot:submenu>
                <x-sirius::dropdown.item id="invoice-pdf" name="PDF" x-on:click="action = 'PDF export requested'" />
                <x-sirius::dropdown.item id="invoice-spreadsheet" name="Spreadsheet">
                    <x-slot:submenu>
                        <x-sirius::dropdown.item id="invoice-csv" name="CSV" x-on:click="action = 'CSV export requested'" />
                        <x-sirius::dropdown.item name="Excel" disabled />
                    </x-slot:submenu>
                </x-sirius::dropdown.item>
            </x-slot:submenu>
        </x-sirius::dropdown.item>
        <x-sirius::dropdown.item id="invoice-delete" name="Delete paid invoice" icon="heroicon-o-trash" disabled x-on:click="action = 'Deleted'" />
    </x-sirius::dropdown>
    <p id="invoice-action-status" role="status" x-text="action"></p>
</div>
