<x-sirius::phone id="blade-phone-traveler" name="traveler" label="Travel emergency contact" country="*" delimiter="."
    required helper="An international contact from any supported country." :value="session('sample-phone.traveler')"
    draft-name="traveler_draft" :draft="session('phone-drafts.traveler')" error-bag="phone" />
