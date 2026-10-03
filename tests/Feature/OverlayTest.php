<?php

declare(strict_types=1);

use App\Livewire\Examples\DialogExample;
use App\Livewire\Examples\OverlayExample;
use App\Livewire\Examples\SlideoverFormExample;
use App\Support\DialogFormSample;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

it('combines Dialog Alert and Slideover integration on one development page', function (): void {
    $this->get(route('development.overlays'))->assertOk()
        ->assertSee('id="livewire-dialog"', false)->assertSee('id="alpine-dialog"', false)
        ->assertSee('id="server-alert"', false)->assertSee('id="server-slideover"', false)
        ->assertSee('id="blade-dialog"', false);
});

it('renders separate overlay pages with Blade demos and copyable examples', function (string $component): void {
    $this->get(route('blade-components.' . $component))->assertOk()
        ->assertSee('data-demo-mode="blade"', false)
        ->assertSee('id="' . $component . '-usage"', false)->assertSee('data-usage-example', false);
})->with(['alert', 'slideover']);

it('keeps the server slideover open after validation and closes after a valid note', function (): void {
    Livewire::test(OverlayExample::class)->set('active', 'slideover')->call('save')
        ->assertHasErrors(['note' => 'required'])->assertSet('active', 'slideover')
        ->set('note', 'Leave at reception')->call('save')->assertHasNoErrors()->assertSet('active', '')
        ->set('active', 'alert')->set('revision', 2)->assertSee('Delivery revision 2')
        ->set('visible', false)->assertDontSee('id="server-alert"', false)->assertDontSee('id="server-slideover"', false);
});

it('renders the complete right side form in matching Blade and Livewire demos', function (): void {
    $this->get(route('blade-components.slideover'))->assertOk()
        ->assertSee('data-slideover-form="blade"', false)->assertSee('data-slideover-form="livewire"', false);
    $this->get(route('blade-components.alert'))->assertOk()->assertDontSee('data-demo-mode="livewire"', false);
});

it('validates and resets the Livewire slideover form without losing its open state', function (): void {
    Livewire::test(SlideoverFormExample::class)->set('reviewing', true)->call('save')
        ->assertHasErrors(['sample.title' => 'required', 'sample.agreed' => 'accepted'])->assertSet('reviewing', true)
        ->call('loadExample')->set('attachment', UploadedFile::fake()->create('brief.pdf', 20, 'application/pdf'))
        ->set('sample.password', 'demo-password')->call('save')->assertHasNoErrors()
        ->assertSet('sample.password', '')->assertSet('saved', true)->assertSet('reviewing', true)
        ->call('resetExample')->assertSet('sample.title', '')->assertSet('attachment', null)->assertSet('saved', false);
});

it('reopens the Blade slideover after validation without flashing passwords or uploaded files', function (): void {
    $sample = DialogFormSample::values();
    $sample['password'] = 'demo-password';
    $this->post(route('blade-components.slideover.store'), ['sample' => $sample])
        ->assertRedirect(route('blade-components.slideover') . '#slideover-demo')
        ->assertSessionHasErrors(['sample.title', 'sample.agreed'], null, 'slideover-form')
        ->assertSessionHas('slideover-form-open', true);
    expect(session('slideover-sample'))->not->toHaveKey('password');
    $sample['title'] = 'Website redesign';
    $sample['agreed'] = true;
    $this->post(route('blade-components.slideover.store'), ['sample' => $sample, 'attachment' => UploadedFile::fake()->create('brief.pdf', 20, 'application/pdf')])
        ->assertSessionHasNoErrors()->assertSessionHas('slideover-form-saved', true);
    expect(session('slideover-sample'))->not->toHaveKey('password')->not->toHaveKey('attachment');
    $this->post(route('blade-components.slideover.store'), ['sample_action' => 'load'])
        ->assertSessionHas('slideover-sample.title', 'Website redesign')->assertSessionHas('slideover-form-open', true);
    $this->post(route('blade-components.slideover.store'), ['sample_action' => 'reset'])
        ->assertSessionHas('slideover-sample.title', '')->assertSessionHas('slideover-sample.agreed', false);
    $this->post(route('blade-components.slideover.store'), ['sample_action' => 'unknown'])->assertUnprocessable();
});

it('keeps the delivery dialog open during validation and closes it after successful validation', function (): void {
    Livewire::test(DialogExample::class)->set('reviewing', true)
        ->call('save')->assertHasErrors(['address' => 'required'])->assertSet('reviewing', true)
        ->set('revision', 1)->assertSee('Delivery revision 1')
        ->set('address', 'Bandung studio')->call('save')->assertHasNoErrors()->assertSet('reviewing', false)
        ->set('visible', false)->assertDontSee('id="livewire-dialog"', false);
});
