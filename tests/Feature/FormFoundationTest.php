<?php

declare(strict_types=1);

use App\Livewire\Examples\FieldExample;
use Livewire\Livewire;

it('renders label and field documentation from the installed package', function (): void {
    $this->get(route('components.label'))->assertSee('Required and optional')->assertSee('sir-required');
    $this->get(route('components.forms'))->assertSee('Livewire validation')->assertSee('id="plain-email-helper"', false);
});

it('displays named-bag validation errors for an ordinary nested Blade field', function (): void {
    $this->from(route('components.forms'))->post(route('components.forms.validate'), ['contact' => ['email' => 'invalid']])
        ->assertRedirect(route('components.forms'))
        ->assertSessionHasErrorsIn('profile', ['contact.email']);

    $this->withCookie(config('session.cookie'), session()->getId())->get(route('components.forms'))
        ->assertSee('id="plain-email-error"', false)
        ->assertSee('aria-describedby="plain-email-helper plain-email-error"', false)
        ->assertSee('value="invalid"', false);
});

it('accepts valid ordinary form data without persisting it', function (): void {
    $this->post(route('components.forms.validate'), ['contact' => ['email' => 'reader@example.com']])
        ->assertRedirect(route('components.forms'))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('form-success', 'Validation passed. Nothing was stored.');
});

it('updates the field error associations during Livewire validation and reset', function (): void {
    Livewire::test(FieldExample::class)
        ->call('save')
        ->assertHasErrors(['email' => 'required'])
        ->assertSee('The email field is required.')
        ->assertSee('aria-invalid="true"', false)
        ->assertSee('Your address stays in this example only.')
        ->set('email', 'reader@example.com')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSee('Validation passed. Nothing was stored.')
        ->call('resetForm')
        ->assertSet('email', '')
        ->assertSet('saved', false)
        ->assertSee('aria-invalid="false"', false);
});
