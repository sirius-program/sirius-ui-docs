<?php

declare(strict_types=1);

use App\Livewire\Examples\PhoneExample;
use Livewire\Livewire;

it('documents all phone country selection modes with exact native sources', function (): void {
    $response = $this->get(route('blade-components.phone'))->assertOk();
    foreach (['delivery', 'partner', 'traveler'] as $field) {
        $response->assertSee(e(trim(file_get_contents(resource_path('views/blade-components/demos/phone-' . $field . '.blade.php')))), false);
    }
    $this->get(route('development.phone'))->assertOk();
    $this->get(route('development.phone-bindings'))->assertOk();
});

it('validates canonical native phone values and restores only bounded allowed drafts', function (): void {
    $this->post(route('blade-components.phone.store'), [
        'delivery'       => null, 'partner' => '+12025550123', 'traveler' => '202 555 0123',
        'delivery_draft' => json_encode(['text' => '0812', 'country' => 'ID']),
        'partner_draft'  => json_encode(['text' => 'hello', 'country' => 'US']),
        'private'        => 'secret',
    ])->assertSessionHasErrorsIn('phone', ['delivery', 'partner', 'traveler'])
        ->assertSessionHas('phone-drafts.delivery.text', '0812')->assertSessionMissing('phone-drafts.partner')->assertSessionMissing('sample-phone.private');
});

it('loads submits and resets native contacts without persisting draft data', function (): void {
    $values = ['delivery' => '+6281234567890', 'partner' => '+442079460018', 'traveler' => '+12025550123'];
    $this->post(route('blade-components.phone.store'), ['sample_action' => 'load'])->assertSessionHas('sample-phone', $values);
    $this->post(route('blade-components.phone.store'), $values)->assertSessionHasNoErrors()->assertSessionHas('phone-success', true);
    $this->post(route('blade-components.phone.store'), ['sample_action' => 'reset'])->assertSessionHas('sample-phone', []);
    $this->post(route('blade-components.phone.store'), ['sample_action' => 'delete'])->assertUnprocessable();
});

it('validates nullable livewire contacts and signals an explicit draft reset', function (): void {
    Livewire::test(PhoneExample::class)->call('save')->assertHasErrors(['delivery', 'partner', 'traveler'])
        ->call('loadExample')->assertSet('partner', '+442079460018')->call('save')->assertHasNoErrors()->assertSet('saved', true)
        ->set('delivery', null)->call('resetExample')->assertSet('delivery', null)->assertSet('resetKey', 2)->assertSet('saved', false);
});
