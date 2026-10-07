<?php

declare(strict_types=1);

it('renders the actual FullCalendar views events and localized independent instances', function (): void {
    $page = visit('/development/calendar')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->assertScript('window.SiriusCalendar.get("team-calendar").getEvents().filter(e=>e.id==="standup").length > 10', true)->assertSeeIn('#second-calendar', 'Website kickoff')
        ->assertScript('window.SiriusCalendar.get("team-calendar").view.type', 'dayGridMonth');
    $page->click('#team-calendar button:has-text("Week")')->assertScript('window.SiriusCalendar.get("team-calendar").view.type', 'timeGridWeek')
        ->click('#team-calendar button[aria-label="Day"]')->assertScript('window.SiriusCalendar.get("team-calendar").view.type', 'timeGridDay')
        ->click('#team-calendar button:has-text("Agenda")')->assertScript('window.SiriusCalendar.get("team-calendar").view.type', 'listWeek')
        ->assertScript('window.SiriusCalendar.get("second-calendar").view.type', 'listWeek')->assertNoJavaScriptErrors();
});

it('opens the application edit dialog by keyboard and refreshes events after saving', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->keys('#team-calendar [data-calendar-event-id="kickoff"]', 'Enter')
        ->assertPresent('#team-calendar-edit:modal')->assertValue('#team-calendar-title', 'Website kickoff')
        ->fill('#team-calendar-title', 'Revised kickoff')->click('#team-calendar-edit button:has-text("Save session")')
        ->assertNotPresent('#team-calendar-edit:modal')->assertSeeIn('#team-calendar', 'Revised kickoff')->assertNoJavaScriptErrors();
});

it('resizes hidden calendars in Tabs Dialog and Slideover', function (): void {
    $page = visit('/development/calendar')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->click('#calendar-tabs [role="tab"]:has-text("Calendar")')->assertSeeIn('#tab-calendar', 'Website kickoff')
        ->click('[data-sir-dialog-open="calendar-dialog"]')->assertPresent('#calendar-dialog:modal')->assertSeeIn('#dialog-calendar', 'Website kickoff')
        ->click('#calendar-dialog [data-sir-dialog-close]')->assertNotPresent('#calendar-dialog:modal')
        ->click('[data-sir-dialog-open="calendar-slideover"]')->assertPresent('#calendar-slideover:modal')->assertSeeIn('#slideover-calendar', 'Website kickoff')
        ->assertNoJavaScriptErrors();
});

it('persists a dragged event and restores a rejected drag', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->drag('#team-calendar [data-calendar-event-id="kickoff"]', '#team-calendar [data-date="2028-10-17"]');
    $page->assertScript('window.SiriusCalendar.get("team-calendar").getEventById("kickoff").startStr', '2028-10-17T09:00:00+07:00')
        ->assertAttribute('#team-calendar', 'aria-busy', 'false');
    $page->click('button:has-text("Toggle rejected changes")')->assertSee('Changes: rejected.');
    $page->drag('#team-calendar [data-calendar-event-id="kickoff"]', '#team-calendar [data-date="2028-10-18"]');
    $page->assertSeeIn('#team-calendar [data-calendar-status]', 'The change was not saved.')
        ->assertScript('getComputedStyle(document.querySelector("#team-calendar [data-calendar-loading]")).display', 'none')
        ->assertScript('document.querySelector("#team-calendar [data-calendar-ui]").inert', false)
        ->assertScript('window.SiriusCalendar.get("team-calendar").getEventById("kickoff").startStr', '2028-10-17T09:00:00+07:00')
        ->assertNoJavaScriptErrors();
});

it('resizes an all day event and preserves the exclusive end', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Design workshop');
    $page->hover('#team-calendar [data-calendar-event-id="workshop"]');
    $page->drag('#team-calendar [data-calendar-event-id="workshop"] > div:last-child', '#team-calendar [data-date="2028-10-20"]');
    $page->assertScript('window.SiriusCalendar.get("team-calendar").getEventById("workshop").endStr', '2028-10-21')
        ->assertAttribute('#team-calendar', 'aria-busy', 'false')->assertNoJavaScriptErrors();
});

it('selects a real date range and creates an all day session with an exclusive end', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->drag('#team-calendar [data-date="2028-10-21"]', '#team-calendar [data-date="2028-10-23"]');
    $page->assertPresent('#team-calendar-edit:modal')->assertValue('#team-calendar-start', '21/10/2028 00:00:00')
        ->assertValue('#team-calendar-end', '24/10/2028 00:00:00')->assertChecked('#team-calendar-all-day')
        ->fill('#team-calendar-title', 'Team offsite')->click('#team-calendar-edit button:has-text("Save session")')
        ->assertSeeIn('#team-calendar [data-date="2028-10-21"]', 'Team offsite')->assertNoJavaScriptErrors();
});

it('keeps Jakarta instants correct in a New York browser and when timezone changes', function (): void {
    $page = visit('/livewire-components/calendar/actions')->withTimezone('America/New_York')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->assertScript('window.SiriusCalendar.get("team-calendar").getEventById("kickoff").start.toISOString()', '2028-10-16T02:00:00.000Z')
        ->click('button:has-text("Switch timezone")')->assertScript('window.SiriusCalendar.get("team-calendar").getOption("timeZone")', 'UTC')
        ->assertScript('window.SiriusCalendar.get("team-calendar").getEventById("kickoff").start.toISOString()', '2028-10-16T02:00:00.000Z')
        ->assertNoJavaScriptErrors();
});

it('shows an inline fetch error and retry without a Livewire error overlay', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->script('const calendarFetch = window.fetch; let failCalendar = true; window.fetch = (...args) => { if (failCalendar && String(args[1]?.body).includes("fetchEvents")) { failCalendar = false; return Promise.resolve(new Response("Unavailable", { status: 503 })); } return calendarFetch(...args); }; window.SiriusCalendar.get("team-calendar").refetchEvents();');
    $page->assertSeeIn('#team-calendar', 'Unable to load the schedule. Try again.')
        ->assertScript('getComputedStyle(document.querySelector("#team-calendar [data-calendar-loading]")).display', 'none')
        ->assertScript('document.querySelector("#team-calendar [data-calendar-ui]").inert', false)
        ->assertAttribute('#team-calendar', 'aria-busy', 'false')->click('#team-calendar [data-calendar-retry]')
        ->assertSeeIn('#team-calendar', 'Website kickoff')->assertDontSeeIn('#team-calendar', 'Unable to load the schedule. Try again.')
        ->assertNoJavaScriptErrors();
});

it('keeps a local render extension through refresh and cleans instances after navigation', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->script('window.calendarCleanup = window.SiriusCalendar.register("team-calendar", () => ({ eventContent(info) { const span = document.createElement("span"); span.dataset.customCalendar = "true"; span.textContent = info.event.title; return { domNodes: [span] }; } })); void 0;');
    $page->assertPresent('#team-calendar [data-custom-calendar]')->click('button:has-text("Refresh events")')
        ->assertPresent('#team-calendar [data-custom-calendar]');
    $page->click('[data-docs-sidebar] summary:has-text("Table")')->click('[data-docs-sidebar] a[href$="/livewire-components/table"]')->assertPathIs('/livewire-components/table')
        ->assertScript('window.SiriusCalendar.get("team-calendar")', null);
    $page->click('[data-docs-sidebar] summary:has-text("Calendar")')->click('[data-docs-sidebar] a[href$="/livewire-components/calendar/actions"]')->assertSeeIn('#team-calendar', 'Website kickoff')
        ->assertPresent('#team-calendar [data-custom-calendar]')->assertScript('document.querySelectorAll("#team-calendar").length', 1)
        ->assertNoJavaScriptErrors();
});

it('fits mobile themes and shows an empty agenda', function (bool $dark): void {
    $pending = visit('/livewire-components/calendar')->on()->mobile();
    $page = ($dark ? $pending->inDarkMode() : $pending->inLightMode())->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->assertScript('document.documentElement.scrollWidth <= window.innerWidth', true);
    $page->script('window.SiriusCalendar.get("team-calendar").changeView("listWeek", "2028-11-06");');
    $page->assertSeeIn('#team-calendar', 'No events in this range.')
        ->assertScript('document.documentElement.scrollWidth <= window.innerWidth', true)->assertNoJavaScriptErrors();
})->with([false, true]);

it('restores a dragged event when its request fails and leaves other calendars usable', function (): void {
    $page = visit('/development/calendar')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->script('const originalCalendarFetch = window.fetch; let failMutation = true; window.fetch = (...args) => { if (failMutation && String(args[1]?.body).includes("interact")) { failMutation = false; return Promise.resolve(new Response("Unavailable", { status: 503 })); } return originalCalendarFetch(...args); };');
    $page->drag('#team-calendar [data-calendar-event-id="kickoff"]', '#team-calendar [data-date="2028-10-17"]');
    $page->assertSeeIn('#team-calendar [data-calendar-status]', 'The change was not saved.')
        ->assertScript('window.SiriusCalendar.get("team-calendar").getEventById("kickoff").startStr', '2028-10-16T09:00:00+07:00')
        ->assertAttribute('#team-calendar', 'aria-busy', 'false')->click('#second-calendar button[aria-label="Next"]')
        ->assertScript('window.SiriusCalendar.get("second-calendar").view.currentStart.toISOString()', '2028-10-23T00:00:00.000Z')
        ->assertNoJavaScriptErrors();
});

it('discards an obsolete fetch response and still opens the currently visible event', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->script('const previousCalendarFetch = window.fetch; let delayCalendar = true; window.calendarDelayed = false; window.fetch = async (...args) => { const response = await previousCalendarFetch(...args); if (delayCalendar && String(args[1]?.body).includes("fetchEvents")) { delayCalendar = false; await new Promise(resolve => setTimeout(resolve, 250)); window.calendarDelayed = true; } return response; }; const currentCalendar = window.SiriusCalendar.get("team-calendar"); currentCalendar.next(); setTimeout(() => currentCalendar.prev(), 50);');
    $page->assertScript('window.calendarDelayed', true)->assertSeeIn('#team-calendar', 'Website kickoff')
        ->assertAttribute('#team-calendar', 'aria-busy', 'false')->click('#team-calendar [data-calendar-event-id="kickoff"]');
    $page->assertPresent('#team-calendar-edit:modal')->assertValue('#team-calendar-title', 'Website kickoff')->assertNoJavaScriptErrors();
});

it('tears down conditional instances and remounts without duplicate calendars', function (): void {
    $page = visit('/development/calendar')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->script('window.calendarHost = Livewire.find(document.querySelector("#team-calendar").parentElement.closest("[wire\\\\:id]").getAttribute("wire:id")); window.calendarHost.$set("visible", false);');
    $page->assertNotPresent('#team-calendar')->assertScript('window.SiriusCalendar.get("team-calendar")', null);
    $page->script('window.calendarHost.$set("visible", true);');
    $page->assertSeeIn('#team-calendar', 'Website kickoff')->assertScript('document.querySelectorAll("#team-calendar").length', 1)
        ->assertScript('window.SiriusCalendar.get("rtl-calendar").getOption("direction")', 'rtl')->assertNoJavaScriptErrors();
});

it('escapes event titles returned by the application source', function (): void {
    $title = '<img src=x onerror=window.calendarXss=true>';
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->click('#team-calendar [data-calendar-event-id="kickoff"]')->assertPresent('#team-calendar-edit:modal')
        ->fill('#team-calendar-title', $title)->click('#team-calendar-edit button:has-text("Save session")')
        ->assertSeeIn('#team-calendar', $title)->assertScript('window.calendarXss === undefined', true)->assertNoJavaScriptErrors();
});

it('identifies the clicked date of recurring events without opening an edit form', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->script('document.addEventListener("schedule:edit", event => { window.clickedOccurrence = event.detail.context.occurrence; });');
    $page->click('#team-calendar [data-date="2028-10-17"] [data-calendar-event-id="standup"]')
        ->assertScript('window.clickedOccurrence?.start', '2028-10-17T09:00:00+07:00')->assertNotPresent('#team-calendar-edit:modal');
    $page->click('#team-calendar [data-date="2028-10-18"] [data-calendar-event-id="standup"]')
        ->assertScript('window.clickedOccurrence?.start', '2028-10-18T09:00:00+07:00')->assertNoJavaScriptErrors();
});

it('navigates Calendar submenus and mounts each page-specific demo without leftover instances', function (): void {
    $page = visit('/livewire-components/calendar')->assertSeeIn('#team-calendar', 'Website kickoff');
    $page->assertNotPresent('#team-calendar-edit')->click('[data-docs-sidebar] a[href$="/livewire-components/calendar/events"]')
        ->assertPathIs('/livewire-components/calendar/events')->assertSeeIn('#collection-calendar', 'Website kickoff')
        ->assertSeeIn('#invoice-calendar', 'INV-1042 · Northstar Studio')
        ->assertScript('window.SiriusCalendar.get("team-calendar")', null);
    $page->click('[data-docs-sidebar] a[href$="/livewire-components/calendar/options"]')
        ->assertPathIs('/livewire-components/calendar/options')->assertSeeIn('#options-calendar', 'Website kickoff')
        ->assertScript('window.SiriusCalendar.get("options-calendar").view.type', 'timeGridWeek')
        ->assertScript('window.SiriusCalendar.get("options-calendar").getOption("weekends")', false)
        ->assertScript('window.SiriusCalendar.get("options-calendar").getOption("locale")', 'id')
        ->assertScript('window.SiriusCalendar.get("collection-calendar")', null)
        ->assertScript('window.SiriusCalendar.get("invoice-calendar")', null);
    $page->click('[data-docs-sidebar] a[href$="/livewire-components/calendar/actions"]')
        ->assertPathIs('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff')
        ->click('#team-calendar [data-calendar-event-id="kickoff"]')->assertPresent('#team-calendar-edit:modal')
        ->assertScript('window.SiriusCalendar.get("options-calendar")', null)->assertNoJavaScriptErrors();
});

it('covers the whole calendar while fetching and restores keyboard focus without blocking other calendars', function (): void {
    $page = visit('/development/calendar')->assertSeeIn('#team-calendar', 'Website kickoff')->assertAttribute('#team-calendar', 'aria-busy', 'false');
    $page->script('const calendarFetch = window.fetch; window.holdCalendarFetch = true; window.fetch = (...args) => { const response = calendarFetch(...args); if (window.holdCalendarFetch && String(args[1]?.body).includes("fetchEvents")) { window.holdCalendarFetch = false; return new Promise(resolve => { window.releaseCalendarFetch = () => resolve(response); }); } return response; }; document.querySelector("#team-calendar button[aria-label=\"Next\"]").focus(); window.SiriusCalendar.get("team-calendar").refetchEvents();');
    $page->assertVisible('#team-calendar [data-calendar-loading]')->assertSeeIn('#team-calendar [data-calendar-loading]', 'Loading schedule…')
        ->assertAttribute('#team-calendar', 'aria-busy', 'true')
        ->assertScript('document.querySelector("#team-calendar [data-calendar-ui]").inert', true)
        ->assertScript('(() => { const root = document.querySelector("#team-calendar").getBoundingClientRect(); const overlay = document.querySelector("#team-calendar [data-calendar-loading]").getBoundingClientRect(); return ["top", "right", "bottom", "left"].every(side => Math.abs(root[side] - overlay[side]) < 1); })()', true);
    $page->script('document.querySelector("#team-calendar button[aria-label=\"Next\"]").click();');
    $page->assertScript('window.SiriusCalendar.get("team-calendar").view.currentStart.toISOString()', '2028-09-30T17:00:00.000Z')
        ->click('#second-calendar button[aria-label="Next"]')
        ->assertScript('window.SiriusCalendar.get("second-calendar").view.currentStart.toISOString()', '2028-10-23T00:00:00.000Z');
    $page->script('window.calendarOutsideFocus = document.querySelector("[data-sir-dialog-open=calendar-dialog]"); window.calendarOutsideFocus.focus();');
    $page->script('window.releaseCalendarFetch();');
    $page->assertScript('getComputedStyle(document.querySelector("#team-calendar [data-calendar-loading]")).display', 'none')->assertAttribute('#team-calendar', 'aria-busy', 'false')
        ->assertScript('document.querySelector("#team-calendar [data-calendar-ui]").inert', false)
        ->assertScript('document.activeElement === window.calendarOutsideFocus', true);
    $page->script('window.holdCalendarFetch = true; document.querySelector("#team-calendar button[aria-label=Next]").focus(); window.SiriusCalendar.get("team-calendar").refetchEvents();');
    $page->assertVisible('#team-calendar [data-calendar-loading]');
    $page->script('window.releaseCalendarFetch();');
    $page->assertAttribute('#team-calendar', 'aria-busy', 'false')->assertScript('document.activeElement === document.querySelector("#team-calendar button[aria-label=Next]")', true)
        ->assertNoJavaScriptErrors();
});

it('keeps the calendar covered through saving and the following event refresh', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff')->assertAttribute('#team-calendar', 'aria-busy', 'false');
    $page->script('const calendarFetch = window.fetch; window.fetch = (...args) => { const response = calendarFetch(...args); const body = String(args[1]?.body); if (body.includes("interact")) return new Promise(resolve => { window.releaseCalendarSave = () => resolve(response); }); if (body.includes("fetchEvents")) return new Promise(resolve => { window.releaseCalendarFetch = () => resolve(response); }); return response; }; void 0;');
    $page->drag('#team-calendar [data-calendar-event-id="kickoff"]', '#team-calendar [data-date="2028-10-17"]');
    $page->assertVisible('#team-calendar [data-calendar-loading]')->assertSeeIn('#team-calendar [data-calendar-loading]', 'Saving schedule…')
        ->assertScript('document.querySelector("#team-calendar [data-calendar-ui]").inert', true);
    $page->script('window.releaseCalendarSave();');
    $page->assertScript('typeof window.releaseCalendarFetch', 'function')->assertVisible('#team-calendar [data-calendar-loading]')
        ->assertSeeIn('#team-calendar [data-calendar-loading]', 'Loading schedule…')
        ->assertAttribute('#team-calendar', 'aria-busy', 'true');
    $page->script('window.releaseCalendarFetch();');
    $page->assertScript('getComputedStyle(document.querySelector("#team-calendar [data-calendar-loading]")).display', 'none')->assertAttribute('#team-calendar', 'aria-busy', 'false')
        ->assertScript('document.querySelector("#team-calendar [data-calendar-ui]").inert', false)
        ->assertScript('window.SiriusCalendar.get("team-calendar").getEventById("kickoff").startStr', '2028-10-17T09:00:00+07:00')
        ->assertNoJavaScriptErrors();
});

it('covers pending event actions and removes the overlay when the application form opens', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff')->assertAttribute('#team-calendar', 'aria-busy', 'false');
    $page->script('const calendarFetch = window.fetch; window.fetch = (...args) => { const response = calendarFetch(...args); if (String(args[1]?.body).includes("interact")) return new Promise(resolve => { window.releaseCalendarAction = () => resolve(response); }); return response; }; void 0;');
    $page->click('#team-calendar [data-calendar-event-id="kickoff"]')->assertVisible('#team-calendar [data-calendar-loading]')
        ->assertNotPresent('#team-calendar-edit:modal')->assertAttribute('#team-calendar', 'aria-busy', 'true');
    $page->script('window.releaseCalendarAction();');
    $page->assertPresent('#team-calendar-edit:modal')->assertValue('#team-calendar-title', 'Website kickoff')
        ->assertScript('getComputedStyle(document.querySelector("#team-calendar [data-calendar-loading]")).display', 'none')->assertAttribute('#team-calendar', 'aria-busy', 'false')
        ->assertScript('document.activeElement.closest("#team-calendar-edit") !== null', true)->assertNoJavaScriptErrors();
});

it('preserves the previous calendar height and loading center until a new view finishes fetching', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff')->assertAttribute('#team-calendar', 'aria-busy', 'false');
    $page->script('const calendarFetch = window.fetch; window.holdCalendarView = false; window.fetch = (...args) => { const response = calendarFetch(...args); if (window.holdCalendarView && String(args[1]?.body).includes("fetchEvents")) { window.holdCalendarView = false; return new Promise(resolve => { window.releaseCalendarView = () => resolve(response); }); } return response; }; const root = document.querySelector("#team-calendar"); root.addEventListener("click", event => { if (event.target.closest(".sir-calendar-toolbar button")) { const box = root.getBoundingClientRect(); window.previousCalendarHeight = box.height; window.previousCalendarCenter = box.top + box.height / 2; } }, true); void 0;');
    foreach (['Week', 'Month', 'Agenda'] as $view) {
        $page->script('window.holdCalendarView = true;');
        $page->click('#team-calendar button:has-text("' . $view . '")')->assertVisible('#team-calendar [data-calendar-loading]')
            ->assertScript('Math.abs(document.querySelector("#team-calendar").getBoundingClientRect().height - window.previousCalendarHeight) < 1', true)
            ->assertScript('(() => { const box = document.querySelector("#team-calendar [data-calendar-loading]").getBoundingClientRect(); return Math.abs(box.top + box.height / 2 - window.previousCalendarCenter) < 1; })()', true);
        $page->script('window.releaseCalendarView();');
        $page->assertAttribute('#team-calendar', 'aria-busy', 'false')
            ->assertScript('document.querySelector("#team-calendar").style.getPropertyValue("--sir-calendar-loading-height")', '')
            ->assertScript('window.SiriusCalendar.get("team-calendar").getOption("height")', 'auto');
    }
    $page->assertNoJavaScriptErrors();
});

it('renders a themed more popup with working event actions outside the calendar DOM', function (): void {
    $page = visit('/livewire-components/calendar/events')->inDarkMode()->assertSeeIn('#invoice-calendar', 'INV-1042 · Northstar Studio');
    $page->click('#invoice-calendar [data-date="2028-10-17"] [aria-haspopup="dialog"]')
        ->assertVisible('[role="dialog"][data-date="2028-10-17"]')
        ->assertScript('getComputedStyle(document.querySelector("[role=dialog][data-date=\\"2028-10-17\\"]")).backgroundColor', 'oklch(0.2 0.02 260)')
        ->assertScript('(() => { const popup = document.querySelector("[role=dialog][data-date=\\"2028-10-17\\"]"); return !document.querySelector("#invoice-calendar").contains(popup) && popup.scrollWidth <= popup.clientWidth; })()', true);
    $page->script('document.addEventListener("calendar:event-click", event => { window.moreEventContext = event.detail; });');
    $page->click('[role="dialog"][data-date="2028-10-17"] [data-calendar-event-id="9"]')
        ->assertScript('window.moreEventContext?.id', 'invoice-calendar')
        ->assertScript('window.moreEventContext?.eventId', '9')->assertAttribute('#invoice-calendar', 'aria-busy', 'false')
        ->assertNoJavaScriptErrors();
});

it('keeps Sunday event resize handles from adding horizontal overflow on hover', function (): void {
    $page = visit('/livewire-components/calendar/actions')->assertSeeIn('#team-calendar', 'Website kickoff')->assertAttribute('#team-calendar', 'aria-busy', 'false');
    $page->script('window.SiriusCalendar.get("team-calendar").getEventById("release").setDates("2028-09-27", "2028-10-02", {allDay: true});');
    $page->assertPresent('#team-calendar [data-calendar-event-id="release"]');
    $page->script('window.beforeCalendarHover = document.querySelector("#team-calendar").getBoundingClientRect().height;');
    $page->hover('#team-calendar [data-calendar-event-id="release"]')
        ->assertScript('(() => { const ui = document.querySelector("#team-calendar [data-calendar-ui]"); return ui.scrollWidth <= ui.clientWidth; })()', true)
        ->assertScript('Math.abs(document.querySelector("#team-calendar").getBoundingClientRect().height - window.beforeCalendarHover) < 1', true)
        ->assertNoJavaScriptErrors();
});
