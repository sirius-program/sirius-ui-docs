<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    app()->instance('env', 'local');
    Request::enableHttpMethodParameterOverride();
    $this->withSession(['_token' => 'form-test-token']);
});

it('accepts GET search without a token and escapes its displayed value', function (): void {
    $this->get(route('blade-components.form', ['query' => '<script>alert(1)</script>']))
        ->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
});

it('validates real POST submissions with CSRF enabled and restores canonical values', function (): void {
    $data = ['_token' => 'form-test-token', 'project' => ['title' => 'Website', 'budget' => '1250.50']];
    $this->post(route('blade-components.form.store'), $data)->assertRedirect(route('blade-components.form'))->assertSessionHas('form-result', 'POST: Website — 1250.50')->assertSessionHasInput('project.budget', '1250.50');
});

it('routes POST method spoofing to the requested update or delete action', function (string $method, array $payload, string $result): void {
    $this->post(route('blade-components.form.store'), ['_token' => 'form-test-token', '_method' => $method, ...$payload])
        ->assertRedirect(route('blade-components.form'))->assertSessionHas('form-result', $result);
})->with([
    ['PUT', ['replace' => ['title' => 'Full update']], 'PUT: Full update'],
    ['PATCH', ['rename' => ['title' => 'New name']], 'PATCH: New name'],
    ['DELETE', ['archive' => ['confirmed' => 'on']], 'DELETE: Demo draft archived.'],
]);

it('rejects missing or mismatched CSRF tokens instead of using the test bypass', function (?string $token, string $method): void {
    $this->post(route('blade-components.form.store'), ['_method' => $method, '_token' => $token, 'project' => ['title' => 'Rejected', 'budget' => '100']])
        ->assertStatus(419)->assertSessionMissing('form-result');
})->with([null, 'invalid-token'])->with(['POST', 'PUT', 'PATCH', 'DELETE']);

it('redirects validation errors to the proper bag and keeps old input', function (): void {
    $this->from(route('blade-components.form'))->post(route('blade-components.form.store'), ['_token' => 'form-test-token', 'project' => ['title' => 'Keep this title', 'budget' => 'bad']])
        ->assertRedirect(route('blade-components.form'))->assertSessionHasErrorsIn('form-project', 'project.budget')->assertSessionHasInput('project.title', 'Keep this title');
    $this->withCookie(config('session.cookie'), session()->getId())->get(route('blade-components.form'))->assertOk()->assertSee('value="Keep this title"', false)->assertSee('aria-invalid="true"', false);
});

it('validates uploads using an isolated disk without persisting demo files', function (): void {
    Storage::fake('local');
    $file = UploadedFile::fake()->createWithContent('brief.txt', 'Sample brief');
    $this->post(route('blade-components.form.upload'), ['_token' => 'form-test-token', 'upload' => ['title' => 'Brief'], 'attachment' => $file])
        ->assertRedirect(route('blade-components.form'))->assertSessionHas('form-result', 'POST: brief.txt (12 bytes) validated.');
    expect(Storage::disk('local')->allFiles())->toBe([]);
});

it('rejects invalid uploads and missing CSRF on multipart requests', function (): void {
    $this->post(route('blade-components.form.upload'), ['upload' => ['title' => 'Brief'], 'attachment' => UploadedFile::fake()->createWithContent('brief.txt', 'Sample')])->assertStatus(419);
    $this->from(route('blade-components.form'))->post(route('blade-components.form.upload'), ['_token' => 'form-test-token', 'upload' => ['title' => 'Brief'], 'attachment' => UploadedFile::fake()->create('script.exe', 1, 'application/octet-stream')])
        ->assertSessionHasErrorsIn('form-upload', 'attachment')->assertSessionHasInput('upload.title', 'Brief');
});

it('loads and resets samples without running form validation', function (): void {
    $this->post(route('blade-components.form.store'), ['_token' => 'form-test-token', 'sample_action' => 'load'])->assertSessionHasInput('project.title', 'Website redesign');
    $this->post(route('blade-components.form.store'), ['_token' => 'form-test-token', 'sample_action' => 'reset'])->assertSessionMissing('_old_input.project');
    $this->post(route('blade-components.form.store'), ['_token' => 'form-test-token', 'sample_action' => 'unexpected'])->assertUnprocessable();
});
