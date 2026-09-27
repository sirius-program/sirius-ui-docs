<?php

declare(strict_types=1);

use App\Livewire\Examples\RichtextExample;
use App\Support\RichtextSample;
use Livewire\Livewire;

it('validates and sanitizes both richtext submission paths', function (): void {
    $unsafe = '<p><strong>Safe</strong><script>alert(1)</script><img src=x onerror=alert(1)><a href="javascript:alert(1)" onclick="alert(1)">link</a></p>';
    $safe = RichtextSample::sanitize($unsafe);
    expect($safe)->toContain('<strong>Safe</strong>')->not->toContain('<script', '<img', 'javascript:', 'onclick');
    Livewire::test(RichtextExample::class)->set('body', $unsafe)->call('save')->assertHasNoErrors()->assertSet('preview', $safe);
    $this->post(route('blade-components.richtext.store'), ['body' => $unsafe])->assertRedirect()->assertSessionHas('richtext-preview', $safe);
    $this->get(route('blade-components.richtext'))->assertOk()->assertSee('<strong>Safe</strong>', false)->assertDontSee('<script>alert(1)', false);
});

it('rejects visually empty or oversized HTML and resets richtext validation', function (string $value): void {
    Livewire::test(RichtextExample::class)->set('body', $value)->call('save')->assertHasErrors('body')->call('loadExample')->assertHasNoErrors()->assertSet('body', RichtextSample::values()['body'])->call('resetExample')->assertSet('body', '')->assertSet('signature', '')->assertSet('preview', '');
    $this->post(route('blade-components.richtext.store'), ['body' => $value])->assertSessionHasErrorsIn('richtext', 'body');
})->with(['', '<p><br></p>', '<p>&nbsp;</p>', '<script>alert(1)</script>', str_repeat('a', 10001)]);

it('loads and resets isolated Blade sample values', function (): void {
    $this->post(route('blade-components.richtext.store'), ['sample_action' => 'load'])->assertSessionHas('sample-richtext', RichtextSample::values());
    $this->post(route('blade-components.richtext.store'), ['sample_action' => 'reset'])->assertSessionHas('sample-richtext', []);
    $this->post(route('blade-components.richtext.store'), ['sample_action' => 'invalid'])->assertStatus(422);
});

it('allows safe links while dropping unsafe schemes and foreign markup', function (): void {
    $html = RichtextSample::sanitize('<p><a href="https://example.com">Web</a><a href="mailto:hello@example.com">Email</a><a href="data:text/html,evil">Bad</a><svg onload="alert(1)"></svg></p>');
    expect(html_entity_decode($html))->toContain('https://example.com', 'mailto:hello@example.com');
    expect($html)->not->toContain('data:text', '<svg', 'onload');
});
