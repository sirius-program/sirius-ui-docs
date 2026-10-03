<?php

declare(strict_types=1);

use App\Livewire\Examples\DialogExample;
use App\Livewire\Examples\DialogFormExample;
use App\Support\DialogFormSample;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

it('renders dialog documentation with Blade demos and copyable examples', function (): void {
    $this->get(route('blade-components.dialog'))->assertOk()
        ->assertSee('data-demo-mode="blade"', false)->assertSee('data-demo-mode="livewire"', false)
        ->assertSee('id="dialog-usage"', false)->assertSee('data-sir-dialog-open="invoice-review"', false);
});

it('validates the complete Livewire project form without closing and resets its controls', function (): void {
    Livewire::test(DialogFormExample::class)->set('reviewing', true)->call('save')
        ->assertHasErrors(['sample.title' => 'required', 'sample.agreed' => 'accepted'])->assertSet('reviewing', true)
        ->call('loadExample')->set('attachment', UploadedFile::fake()->create('brief.pdf', 20, 'application/pdf'))
        ->call('save')->assertHasNoErrors()->assertSet('saved', true)->assertSet('reviewing', true)
        ->call('resetExample')->assertSet('sample.title', '')->assertSet('attachment', null)->assertSet('saved', false);
});

it('reopens the Blade project form after validation and never flashes its password or file', function (): void {
    $sample = DialogFormSample::values();
    $sample['password'] = 'example-secret';
    $this->post(route('blade-components.dialog.store'), ['sample' => $sample])
        ->assertSessionHasErrors(['sample.title', 'sample.agreed'], null, 'dialog-form')->assertSessionHas('dialog-form-open', true);
    expect(session('dialog-sample'))->not->toHaveKey('password');
    $sample['title'] = 'Website redesign';
    $sample['agreed'] = true;
    $this->post(route('blade-components.dialog.store'), ['sample' => $sample, 'attachment' => UploadedFile::fake()->create('brief.pdf', 20, 'application/pdf')])
        ->assertSessionHasNoErrors()->assertSessionHas('dialog-form-saved', true)->assertSessionHas('dialog-form-open', true);
    expect(session('dialog-sample'))->not->toHaveKey('password')->not->toHaveKey('attachment');
});

it('loads and resets the Blade project sample and rejects unsupported actions', function (): void {
    $this->post(route('blade-components.dialog.store'), ['sample_action' => 'load'])
        ->assertSessionHas('dialog-sample.title', 'Website redesign')->assertSessionHas('dialog-form-open', true);
    $this->post(route('blade-components.dialog.store'), ['sample_action' => 'reset'])
        ->assertSessionHas('dialog-sample.title', '')->assertSessionHas('dialog-sample.agreed', false);
    $this->post(route('blade-components.dialog.store'), ['sample_action' => 'unknown'])->assertUnprocessable();
});

it('keeps the delivery dialog open during validation and closes it after successful validation', function (): void {
    Livewire::test(DialogExample::class)->set('reviewing', true)
        ->call('save')->assertHasErrors(['address' => 'required'])->assertSet('reviewing', true)
        ->set('revision', 1)->assertSee('Delivery revision 1')
        ->set('address', 'Bandung studio')->call('save')->assertHasNoErrors()->assertSet('reviewing', false)
        ->set('visible', false)->assertDontSee('id="livewire-dialog"', false);
});
