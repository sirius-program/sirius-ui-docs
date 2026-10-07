<?php

declare(strict_types=1);

use App\Livewire\ProjectCalendar;
use App\Livewire\ProjectForm;
use App\Livewire\ProjectTable;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

function loadSkillRecipes(): void
{
    $files = new Filesystem;
    $source = $files->get(base_path('vendor/sirius/ui/resources/boost/skills/sirius-ui-development/references/recipes.md'));
    $root = base_path('.phpunit.cache/skill-recipes');
    $files->ensureDirectoryExists($root . '/livewire');
    preg_match_all('/```php\n(.*?)```/s', $source, $blocks);
    foreach ($blocks[1] as $code) {
        if (preg_match('/class (Project\w+) /', $code, $match) === 1) {
            $path = $root . '/' . $match[1] . '.php';
            $files->put($path, $code);
            require_once $path;
        }
    }
    preg_match('/```blade\n(<div>.*?)```/s', $source, $form);
    $files->put($root . '/livewire/project-form.blade.php', $form[1]);
    app('view')->addLocation($root);
}

it('serves the skill guide under Getting Started with installation and activation examples', function (): void {
    $this->get(route('started.ai-agent-skill'))->assertSuccessful()->assertSee('AI Agent Skill')
        ->assertSee('sirius:skills:install')->assertSee('boost:install')->assertSee('boost:update')
        ->assertSee('$sirius-ui-development')->assertSee('/sirius-ui-development')
        ->assertSee('direct runtime evaluation is deferred');
    $this->get(route('started'))->assertSee(route('started.ai-agent-skill'));
});

it('runs the bundled form recipe with validation canonical currency values and reset', function (): void {
    loadSkillRecipes();
    Livewire::test(ProjectForm::class)->call('save')->assertHasErrors(['title' => 'required'])
        ->assertNotDispatched('toast:show')
        ->set('title', 'Website redesign')->set('budget', '-10')->call('save')->assertHasErrors(['budget' => 'min'])
        ->set('budget', '1250.50')->call('save')->assertHasNoErrors()
        ->assertDispatched('toast:show', id: 'project-saved')
        ->assertSee('data-sir-currency', false)
        ->call('clearForm')->assertSet('title', '')->assertSet('budget', null)->assertHasNoErrors();

    Route::post('/skill-projects', fn (): ResponseFactory|\Illuminate\Http\Response => response('Saved'))->name('projects.store');
    Route::getRoutes()->refreshNameLookups();
    $source = file_get_contents(base_path('vendor/sirius/ui/resources/boost/skills/sirius-ui-development/references/recipes.md'));
    preg_match('/```blade\n(<x-sirius::form.*?)```/s', $source, $native);
    expect(Blade::render($native[1]))->toContain('method="POST"', 'name="_token"', 'name="title"');
});

it('runs the bundled Collection Table recipe with owner scoping filtering and sorting', function (): void {
    loadSkillRecipes();
    $this->be(new GenericUser(['id' => 1]));
    session()->put('projects', [
        ['id' => 1, 'owner_id' => 1, 'title' => 'Redesign'],
        ['id' => 2, 'owner_id' => 1, 'title' => 'Archive'],
        ['id' => 3, 'owner_id' => 2, 'title' => 'Private competitor project'],
    ]);
    $table = Livewire::test(ProjectTable::class, ['id' => 'skill-projects']);
    $table->assertSee('REDESIGN')->assertSee('ARCHIVE')->assertDontSee('PRIVATE COMPETITOR PROJECT')
        ->assertSet('perPage', 10)
        ->set('filters.title', 'redesign')->assertSee('REDESIGN')->assertDontSee('ARCHIVE')
        ->call('resetFilters')->call('sortBy', 'title')->assertSet('sorts.title', 'asc')
        ->call('sortBy', 'title')->assertSet('sorts.title', 'desc')
        ->call('sortBy', 'title')->assertSet('sorts', []);
});

it('runs the bundled Calendar recipe and persists only acknowledged owner events', function (): void {
    loadSkillRecipes();
    $this->be(new GenericUser(['id' => 1]));
    session()->put('schedule', [
        ['id' => 'meeting', 'owner_id' => 1, 'title' => 'Planning', 'start' => '2028-10-16T09:00:00+07:00', 'end' => '2028-10-16T10:00:00+07:00', 'allDay' => false],
        ['id' => 'private', 'owner_id' => 2, 'title' => 'Private meeting', 'start' => '2028-10-16T09:00:00+07:00', 'end' => '2028-10-16T10:00:00+07:00', 'allDay' => false],
        ['id' => 'meeting', 'owner_id' => 2, 'title' => 'Other owner with the same local key', 'start' => '2028-10-16T09:00:00+07:00', 'end' => '2028-10-16T10:00:00+07:00', 'allDay' => false],
    ]);
    $calendar = Livewire::test(ProjectCalendar::class, ['id' => 'skill-schedule', 'timezone' => 'Asia/Jakarta', 'editable' => true]);
    $calendar->call('fetchEvents', '2028-10-01T00:00:00+07:00', '2028-11-01T00:00:00+07:00')->assertSuccessful();
    $calendar->call('interact', 'event-click', ['eventId' => 'meeting', 'occurrence' => ['start' => '2028-10-16T09:00:00+07:00', 'end' => '2028-10-16T10:00:00+07:00', 'allDay' => false]])
        ->assertDispatched('project:review', recordId: 'meeting')->assertDispatched('dialog:show', id: 'schedule-review');
    $calendar->call('interact', 'event-drop', ['eventId' => 'meeting',
        'old'                                            => ['start' => '2028-10-16T09:00:00+07:00', 'end' => '2028-10-16T10:00:00+07:00', 'allDay' => false],
        'new'                                            => ['start' => '2028-10-16T11:00:00+07:00', 'end' => '2028-10-16T12:00:00+07:00', 'allDay' => false],
    ])->assertReturned(true);
    expect(session('schedule.0.start'))->toBe('2028-10-16T11:00:00+07:00');
    expect(session('schedule.1.start'))->toBe('2028-10-16T09:00:00+07:00');
    expect(session('schedule.2.start'))->toBe('2028-10-16T09:00:00+07:00');
    $calendar->call('interact', 'event-click', ['eventId' => 'private'])->assertStatus(404);
});
