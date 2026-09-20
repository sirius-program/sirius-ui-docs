<x-sirius::phone id="blade-phone-partner" name="partner" label="Supplier contact" :country="['ID', 'GB']" delimiter="-"
    required helper="Choose the supplier country before entering a local number." :value="session('sample-phone.partner')"
    draft-name="partner_draft" :draft="session('phone-drafts.partner')" error-bag="phone" />
