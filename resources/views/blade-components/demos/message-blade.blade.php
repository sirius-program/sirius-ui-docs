<div class="space-y-3">
    <x-sirius::message id="blade-invoice-message" variant="success" icon="heroicon-o-check-circle" dismissible>
        Invoice #1042 was sent to the customer.
    </x-sirius::message>
    <x-sirius::message variant="warning" icon="heroicon-o-exclamation-triangle">
        Add a billing address before sending the next invoice.
    </x-sirius::message>
    <x-sirius::message variant="primary" icon="heroicon-o-information-circle">A new invoice is ready to send.</x-sirius::message>
    <x-sirius::message variant="info">The customer viewed invoice #1042.</x-sirius::message>
    <x-sirius::message variant="danger">Payment failed. Ask the customer to try again.</x-sirius::message>
    <x-sirius::message variant="secondary">This invoice is saved as a draft.</x-sirius::message>
    <x-sirius::message variant="ghost">No changes since the last save.</x-sirius::message>
    <x-sirius::message variant="outline">Invoice #1042 is ready for review.</x-sirius::message>
</div>
