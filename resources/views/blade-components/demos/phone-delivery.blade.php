<x-sirius::phone id="blade-phone-delivery" name="delivery" label="Delivery contact" country="ID"
    required helper="Courier contact in Indonesia." :value="session('sample-phone.delivery')"
    draft-name="delivery_draft" :draft="session('phone-drafts.delivery')" error-bag="phone" />
