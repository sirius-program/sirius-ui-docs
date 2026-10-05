<?php

declare(strict_types=1);

it('navigates the Table submenus and keeps their demos interactive after Livewire navigation', function (): void {
    $page = visit('/livewire-components/table')->type('#overview-table-search', 'Northstar')
        ->assertSeeIn('#overview-table .sir-table-footer', '9 shown of 9 invoices');
    $page->click('[data-flux-sidebar] a[href$="/livewire-components/table/query"]')
        ->assertPathIs('/livewire-components/table/query')
        ->type('#query-collection-table-search', 'Northstar')
        ->assertSeeIn('#query-collection-table .sir-table-footer', '1 shown of 1 invoices')
        ->assertSeeIn('#query-eloquent-table .sir-table-footer', '10 shown of 34 invoices')
        ->clear('#query-collection-table-search')
        ->click('#query-collection-table .sir-table-pagination button:has-text("Next")')
        ->assertSeeIn('#query-collection-table tbody', 'Bright Books');
    $page->click('[data-flux-sidebar] a[href$="/livewire-components/table/columns"]')
        ->assertPathIs('/livewire-components/table/columns')
        ->assertSeeIn('#columns-table tbody', '$127.50 · Paid')
        ->click('#columns-table th button:has-text("Customer")')
        ->assertSeeIn('#columns-table tbody tr:first-child', 'Bright Books');
    $page->click('[data-flux-sidebar] a[href$="/livewire-components/table/filters"]')
        ->assertPathIs('/livewire-components/table/filters')
        ->click('#invoice-table-filters-trigger')->type('#invoice-table-filter-status-search', 'Paid')
        ->click('#invoice-table-filters-menu .option[data-value="paid"]')
        ->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 11 invoices');
    $page->click('[data-flux-sidebar] a[href$="/livewire-components/table/row-actions"]')
        ->assertPathIs('/livewire-components/table/row-actions')
        ->click('#invoice-table button[aria-label="Review INV-1042"]')
        ->assertPresent('#invoice-review:modal')->assertSeeIn('#invoice-review', 'INV-1042')
        ->assertNoJavaScriptErrors();
});

it('searches filters sorts and paginates without losing dropdown input or crossing Table instances', function (): void {
    $page = visit('/development/table');
    $page->type('#invoice-table-search', 'Northstar')->assertSeeIn('#invoice-table tbody tr:first-child', 'Northstar Studio')
        ->assertDontSeeIn('#invoice-table tbody', 'Orbit Coffee')->assertSeeIn('#second-table tbody tr:nth-child(2)', 'Orbit Coffee');
    $page->click('#invoice-table-filters-trigger')->type('#invoice-table-filter-status-search', 'Paid')
        ->click('#invoice-table-filters-menu .option[data-value="paid"]')
        ->assertSeeIn('#invoice-table tbody tr:first-child', 'Paid')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->type('#invoice-table-filter-customer', 'Northstar')->assertSeeIn('#invoice-table tbody', 'INV-1046');
    $page->assertAttribute('#invoice-table', 'aria-busy', 'false');
    $page->click('#invoice-table-filters-trigger')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'false');
    $page->click('#invoice-table-filters-trigger')->click('#invoice-table-filters-menu button:has-text("Reset filters")')
        ->assertSeeIn('#invoice-table .sir-table-footer', '9 shown of 9 invoices');
    $page->click('#invoice-table-filters-trigger')->clear('#invoice-table-search')
        ->click('#invoice-table th button:has-text("Invoice")')->assertAttribute('#invoice-table th:first-child', 'aria-sort', 'ascending')
        ->assertSeeIn('#invoice-table th:first-child button span', '↑')
        ->click('#invoice-table th button:has-text("Invoice")')->assertAttribute('#invoice-table th:first-child', 'aria-sort', 'descending')
        ->assertSeeIn('#invoice-table th:first-child button span', '↓')
        ->click('#invoice-table th button:has-text("Invoice")')->assertAttribute('#invoice-table th:first-child', 'aria-sort', 'none')
        ->click('#invoice-table .sir-table-pagination button[aria-label="Page 2"]')->assertSeeIn('#invoice-table .sir-table-footer', '11–20')
        ->click('#invoice-table .sir-table-pagination button:has-text("Back")')->assertSeeIn('#invoice-table .sir-table-footer', '1–10')
        ->assertScript('document.querySelector("#invoice-table .sir-table-pagination button:first-child").disabled', true)
        ->click('#invoice-table .sir-table-pagination button:has-text("Next")')->assertSeeIn('#invoice-table .sir-table-footer', '11–20')
        ->click('#invoice-table .sir-table-pagination button[aria-label="Page 4"]')->assertSeeIn('#invoice-table .sir-table-footer', '31–34')
        ->assertScript('document.querySelector("#invoice-table .sir-table-pagination button:last-child").disabled', true)
        ->select('#invoice-table-per-page', '25')->assertSeeIn('#invoice-table .sir-table-footer', '1–25')
        ->assertNoJavaScriptErrors();
});

it('applies shift clicked sort priorities and keeps ordinary clicks exclusive', function (): void {
    $page = visit('/development/table')->click('#invoice-table th button:has-text("Customer")')
        ->assertSeeIn('#invoice-table tbody tr:first-child', 'INV-1044');
    $shiftClick = 'document.querySelector("#invoice-table th:nth-child(3) button").dispatchEvent(new MouseEvent("click", { bubbles: true, shiftKey: true }));';
    $page->script($shiftClick);
    $page->assertAttribute('#invoice-table th:nth-child(3) button', 'aria-label', 'Status: ascending (priority 2)')
        ->assertSeeIn('#invoice-table tbody tr:first-child', 'INV-1044');
    $page->script($shiftClick);
    $page->assertAttribute('#invoice-table th:nth-child(3) button', 'aria-label', 'Status: descending (priority 2)')
        ->assertSeeIn('#invoice-table tbody tr:first-child', 'INV-1048');
    $page->script($shiftClick);
    $page->assertSeeIn('#invoice-table tbody tr:first-child', 'INV-1044')
        ->assertScript('document.querySelector("#invoice-table th:nth-child(3) button").hasAttribute("aria-label")', false)
        ->click('#invoice-table th button:has-text("Invoice")')->assertAttribute('#invoice-table th:first-child', 'aria-sort', 'ascending')
        ->assertAttribute('#invoice-table th:nth-child(2)', 'aria-sort', 'none')
        ->assertAttribute('#second-table th:first-child', 'aria-sort', 'none')->assertNoJavaScriptErrors();
});

it('searches remote Select filters and clears their resolved values without closing the filter panel', function (): void {
    $page = visit('/development/table')->click('#invoice-table-filters-trigger');
    $input = '#invoice-table-filter-client-search';
    $select = '[data-sir-select]:has(#invoice-table-filter-client)';
    $page->click($input)->assertSeeIn($select . ' .ts-dropdown', 'Bright Books')
        ->click($select . ' button:has-text("Load more")')->assertSeeIn($select . ' .ts-dropdown', 'Orbit Coffee')
        ->type($input, 'Northstar')->assertSeeIn($select . ' .ts-dropdown', 'Northstar Studio');
    $page->script('const panel = document.querySelector("#invoice-table-filters-menu"); panel.getAnimations().forEach(animation => animation.finish()); window.filterAnimations = 0; panel.addEventListener("animationstart", () => window.filterAnimations++);');
    $page->click($select . ' .option[data-value="Northstar Studio"]')
        ->assertSeeIn($select . ' .item', 'Northstar Studio')->assertSeeIn('#invoice-table .sir-table-footer', '9 shown of 9 invoices')
        ->assertScript('document.activeElement.id', 'invoice-table-filter-client-search')
        ->assertScript('window.filterAnimations', 0)
        ->click($select . ' .ts-control')->assertVisible($input)
        ->assertScript('(() => { const root = document.querySelector("[data-sir-select]:has(#invoice-table-filter-client)"); const item = root.querySelector(".item").getBoundingClientRect(); const input = root.querySelector(".ts-control input").getBoundingClientRect(); return Math.abs((item.top + item.bottom) / 2 - (input.top + input.bottom) / 2) < 2; })()', true)
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->assertScript('getComputedStyle(document.querySelector("#invoice-table-filter-client")).display', 'none')
        ->click($select . ' [data-select-clear]')->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 34 invoices')
        ->assertMissing($select . ' .item')->assertNoJavaScriptErrors();
});

it('keeps filter panel and Select widths stable through selection clearing and reset', function (int $width): void {
    $page = visit('/development/table')->resize($width, 900)->click('#invoice-table-filters-trigger');
    $page->script('window.filterWidths = () => ["#invoice-table-filters-menu", "[data-sir-select]:has(#invoice-table-filter-status) .sir-select-shell", "[data-sir-select]:has(#invoice-table-filter-client) .sir-select-shell"].map(selector => document.querySelector(selector).getBoundingClientRect().width); window.initialFilterWidths = window.filterWidths();');
    $page->assertScript('window.initialFilterWidths[0]', min(316, $width - 16));

    $page->click('#invoice-table-filter-status-search')->assertVisible('[data-sir-select]:has(#invoice-table-filter-status) .ts-dropdown');
    $page->script('window.initialOptionsWidth = document.querySelector("[data-sir-select]:has(#invoice-table-filter-status) .ts-dropdown").getBoundingClientRect().width;');
    $page->type('#invoice-table-filter-status-search', str_repeat('Long search ', 8))
        ->assertSeeIn('[data-sir-select]:has(#invoice-table-filter-status) .ts-dropdown', 'No options found')
        ->assertScript('JSON.stringify(window.filterWidths()) === JSON.stringify(window.initialFilterWidths)', true)
        ->clear('#invoice-table-filter-status-search')
        ->type('#invoice-table-filter-status-search', 'Paid')->click('#invoice-table-filters-menu .option[data-value="paid"]')
        ->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 11 invoices')
        ->assertScript('JSON.stringify(window.filterWidths()) === JSON.stringify(window.initialFilterWidths)', true)
        ->click('[data-sir-select]:has(#invoice-table-filter-status) .ts-control')
        ->assertVisible('[data-sir-select]:has(#invoice-table-filter-status) .ts-dropdown')
        ->assertScript('document.querySelector("[data-sir-select]:has(#invoice-table-filter-status) .ts-dropdown").getBoundingClientRect().width === window.initialOptionsWidth', true)
        ->click('[data-sir-select]:has(#invoice-table-filter-status) [data-select-clear]')
        ->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 34 invoices')
        ->assertScript('JSON.stringify(window.filterWidths()) === JSON.stringify(window.initialFilterWidths)', true)
        ->type('#invoice-table-filter-client-search', 'Northstar')
        ->click('[data-sir-select]:has(#invoice-table-filter-client) .option[data-value="Northstar Studio"]')
        ->assertSeeIn('#invoice-table .sir-table-footer', '9 shown of 9 invoices')
        ->assertScript('JSON.stringify(window.filterWidths()) === JSON.stringify(window.initialFilterWidths)', true)
        ->click('#invoice-table-filters-menu button:has-text("Reset filters")')
        ->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 34 invoices')
        ->assertScript('JSON.stringify(window.filterWidths()) === JSON.stringify(window.initialFilterWidths)', true)
        ->assertScript('(() => { const panel = document.querySelector("#invoice-table-filters-menu").getBoundingClientRect(); return panel.left >= 0 && panel.right <= innerWidth; })()', true)
        ->assertNoJavaScriptErrors();
})->with([1440, 320]);

it('selects and resets date time and datetime filters inside the dropdown', function (): void {
    $page = visit('/development/table')->click('#invoice-table-filters-trigger');
    $page->type('#invoice-table-filter-issued', '15/10/2028')->keys('#invoice-table-filter-issued', 'Tab')
        ->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 12 invoices')
        ->click('#invoice-table-filter-issued')->assertVisible('#invoice-table-filter-issued-calendar.open')
        ->assertScript('document.querySelector("#invoice-table-filters-menu").contains(document.querySelector("#invoice-table-filter-issued-calendar"))', true)
        ->click('#invoice-table-filter-issued-calendar .flatpickr-day[aria-label="October 16, 2028"]')
        ->assertValue('#invoice-table-filter-issued', '16/10/2028')->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 11 invoices')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->click('[data-sir-datetime-picker]:has(#invoice-table-filter-issued) [data-sir-date-clear]')
        ->type('#invoice-table-filter-reminder', '14:30')->keys('#invoice-table-filter-reminder', 'Tab')
        ->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 17 invoices')
        ->type('#invoice-table-filter-sent', '15/10/2028 14:30:00')->keys('#invoice-table-filter-sent', 'Tab')
        ->assertSeeIn('#invoice-table .sir-table-footer', '6 shown of 6 invoices')
        ->click('#invoice-table-filters-menu button:has-text("Reset filters")')
        ->assertValue('#invoice-table-filter-issued', '')->assertValue('#invoice-table-filter-reminder', '')
        ->assertValue('#invoice-table-filter-sent', '')->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 34 invoices')
        ->assertNoJavaScriptErrors();
});

it('focuses visible filter controls and lets Escape close nested widgets while keeping their dropdown open', function (): void {
    $page = visit('/development/table')->keys('#invoice-table-filters-trigger', 'ArrowDown')
        ->assertScript('document.activeElement.id', 'invoice-table-filter-customer');
    $page->type('#invoice-table-filter-status-search', 'Paid')->assertVisible('#invoice-table-filters-menu .option[data-value="paid"]')
        ->keys('#invoice-table-filter-status-search', 'Escape')
        ->assertScript('document.querySelector("[data-sir-select]:has(#invoice-table-filter-status) .ts-wrapper").classList.contains("dropdown-active")', false)
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->keys('#invoice-table-filter-status-search', 'Escape')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->click('#invoice-table-filters-trigger')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'false')
        ->assertScript('document.activeElement.id', 'invoice-table-filters-trigger');
    $page->click('#invoice-table-filters-trigger')->click('#invoice-table-filter-issued')
        ->assertVisible('#invoice-table-filter-issued-calendar.open')->keys('#invoice-table-filter-issued', 'Escape')
        ->assertMissing('#invoice-table-filter-issued-calendar.open')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->keys('#invoice-table-filter-issued', 'Escape')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->click('#invoice-table-filters-trigger')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'false')
        ->assertNoJavaScriptErrors();
});

it('keeps Table filters open through focus changes and only dismisses them by click', function (): void {
    $page = visit('/development/table')->click('#invoice-table-filters-trigger');
    $page->keys('#invoice-table-filters-trigger', 'Escape')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->keys('#invoice-table-filters-trigger', 'Enter')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'false')
        ->keys('#invoice-table-filters-trigger', 'Enter')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true');
    $page->keys('#invoice-table-filters-menu button:has-text("Reset filters")', 'Tab')
        ->assertScript('document.activeElement.id', 'invoice-table-search')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true');
    $page->script('document.querySelector("#second-table-search").focus();');
    $page->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->click('#invoice-table-filter-customer')->type('#invoice-table-filter-customer', 'Northstar')
        ->assertSeeIn('#invoice-table .sir-table-footer', '9 shown of 9 invoices')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->click('#invoice-table-search')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'false')
        ->click('#invoice-table-filters-trigger')->click('#invoice-table-filters-trigger')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'false')->assertNoJavaScriptErrors();
});

it('keeps a date filter open when its calendar is rendered outside the dropdown', function (): void {
    $page = visit('/livewire-components/table/filters')->click('#invoice-table-filters-trigger')->click('#invoice-table-filter-issued');
    $page->assertVisible('#invoice-table-filter-issued-calendar.open');
    // Widgets may portal their overlay outside the field during initialization or DOM updates.
    $page->script('document.body.append(document.querySelector("#invoice-table-filter-issued-calendar"));');
    $page->click('#invoice-table-filter-issued-calendar .flatpickr-day.today')
        ->assertScript('document.querySelector("#invoice-table-filter-issued").value !== ""', true)
        ->assertSeeIn('#invoice-table .sir-table-footer', '0 shown of 0 invoices')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->click('#invoice-table-search')->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'false')
        ->assertNoJavaScriptErrors();
});

it('restores date filter focus after choosing a date and completing its Table request', function (): void {
    $page = visit('/development/table')->click('#invoice-table-filters-trigger')->click('#invoice-table-filter-issued');
    $page->script('window.dateChanges = []; document.querySelector("[data-sir-datetime-picker]:has(#invoice-table-filter-issued) [data-sir-date-value]").addEventListener("change", event => window.dateChanges.push(event.target.value));');
    $page->page()->locator('#invoice-table-filter-issued-calendar .flatpickr-day.today')->click(['delay' => 250]);
    $page->assertSeeIn('#invoice-table .sir-table-footer', '0 shown of 0 invoices')
        ->assertAttribute('#invoice-table', 'aria-busy', 'false')
        ->assertScript('window.dateChanges.length', 1)
        ->assertScript('document.activeElement.id', 'invoice-table-filter-issued')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')->assertNoJavaScriptErrors();
});

it('opens separately owned overlays passes the correct row and validates a review in the application', function (): void {
    $page = visit('/livewire-components/table/row-actions')->click('#invoice-table button[aria-label="Review INV-1042"]')
        ->assertPresent('#invoice-review:modal')->assertSeeIn('#invoice-review', 'INV-1042')
        ->click('#invoice-review button:has-text("Save review")')->assertSeeIn('#invoice-review', 'The note field is required.')
        ->assertAttribute('#invoice-table', 'aria-busy', 'false')->assertPresent('#invoice-review:modal');
    $page->type('#invoice-note', 'Ready for billing')->click('#invoice-review button:has-text("Save review")')
        ->assertMissing('#invoice-review:modal')->assertSeeIn('#table-feedback', 'INV-1042: Ready for billing');
    $page->click('#invoice-table button[aria-label="Remind INV-1043"]')->assertPresent('#invoice-confirm:modal')
        ->assertSeeIn('#invoice-confirm', 'INV-1043')->click('#invoice-confirm button:has-text("Cancel")')
        ->click('#invoice-table button[aria-label="Details INV-1044"]')->assertPresent('#invoice-details:modal')
        ->assertSeeIn('#invoice-details', 'INV-1044')->keys('#invoice-details button[data-sir-dialog-close]', 'Escape')
        ->assertAttribute('#invoice-table a[aria-label="Open INV-1042"]', 'href', '#')
        ->click('#invoice-table a[aria-label="Open INV-1042"]')->assertPathIs('/livewire-components/table/row-actions')
        ->assertSee('Northstar Studio')->assertNoJavaScriptErrors();
});

it('blocks results and pagination during its request while leaving the toolbar available', function (): void {
    $page = visit('/development/table');
    $page->script('(() => { window.originalTableFetch = window.fetch; window.fetch = (...args) => String(args[0]).includes("livewire") ? new Promise(resolve => { window.releaseTableRequest = () => { window.fetch = window.originalTableFetch; resolve(window.originalTableFetch(...args)); }; }) : window.originalTableFetch(...args); return true; })()');
    $page->click('#invoice-table th button:has-text("Invoice")')->assertAttribute('#invoice-table', 'aria-busy', 'true')
        ->assertVisible('#invoice-table [data-table-loading]')->assertScript('document.querySelector("#invoice-table [data-table-content]").inert', true)
        ->assertScript('document.querySelector("#invoice-table-search").closest("[inert]") === null', true)
        ->assertScript('(() => { const overlay = document.querySelector("#invoice-table [data-table-loading]").getBoundingClientRect(); const toolbar = document.querySelector("#invoice-table .sir-table-toolbar").getBoundingClientRect(); return overlay.top >= toolbar.bottom; })()', true)
        ->assertScript('document.querySelector("#second-table [data-table-content]").inert', false)
        ->click('#invoice-table-filters-trigger')->click('#invoice-table-filter-issued')
        ->assertVisible('#invoice-table-filter-issued-calendar.open')
        ->assertScript('document.activeElement.id', 'invoice-table-filter-issued');
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail: {id: "invoice-table", loading: true}}));');
    $page->script('document.querySelector("#invoice-table .sir-table-pagination button[aria-label=\"Page 2\"]").click(); window.releaseTableRequest();');
    $page->assertScript('document.querySelector("#invoice-table [data-table-content]").hasAttribute("data-table-request")', false)
        ->assertAttribute('#invoice-table', 'aria-busy', 'true')->assertVisible('#invoice-table [data-table-loading]');
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail: {id: "invoice-table", loading: false}}));');
    $page->assertAttribute('#invoice-table', 'aria-busy', 'false')->assertSeeIn('#invoice-table .sir-table-footer', '1–10')
        ->type('#invoice-table-search', 'Orbit')->assertDontSeeIn('#invoice-table tbody', 'Northstar Studio')->assertNoJavaScriptErrors();
});

it('keeps filters and search interactive during external loading without enabling row actions', function (): void {
    $page = visit('/development/table')->click('#invoice-table-filters-trigger')->click('#invoice-table-filter-issued');
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail: {id: "invoice-table", loading: true}}));');
    $page->assertAttribute('#invoice-table', 'aria-busy', 'true')
        ->assertScript('document.activeElement.id', 'invoice-table-filter-issued')
        ->click('#invoice-table-filter-issued-calendar .flatpickr-day.today')
        ->assertSeeIn('#invoice-table .sir-table-footer', '0 shown of 0 invoices')
        ->assertScript('document.activeElement.id', 'invoice-table-filter-issued')
        ->assertAttribute('#invoice-table-filters-trigger', 'aria-expanded', 'true')
        ->click('#invoice-table-filters-menu button:has-text("Reset filters")')
        ->assertSeeIn('#invoice-table .sir-table-footer', '10 shown of 34 invoices')
        ->type('#invoice-table-search', 'Orbit')->assertSeeIn('#invoice-table .sir-table-footer', '9 shown of 9 invoices')
        ->assertAttribute('#invoice-table', 'aria-busy', 'true')->assertVisible('#invoice-table [data-table-loading]');
    $page->script('document.querySelector("#invoice-table button[aria-label=\"Review INV-1043\"]").click();');
    $page->assertMissing('#invoice-review:modal');
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail: {id: "invoice-table", loading: false}}));');
    $page->assertAttribute('#invoice-table', 'aria-busy', 'false')->click('#invoice-table button[aria-label="Review INV-1043"]')
        ->assertPresent('#invoice-review:modal')->assertNoJavaScriptErrors();
});

it('honors external loading without blocking overlays or another Table and recovers after cancellation', function (): void {
    $page = visit('/development/table')->click('#invoice-table button[aria-label="Review INV-1042"]')->assertPresent('#invoice-review:modal');
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail: {id: "invoice-table", loading: true}}));');
    $page->assertAttribute('#invoice-table', 'aria-busy', 'true')->type('#invoice-note', 'Overlay is still usable')
        ->assertScript('document.querySelector("#invoice-note").value', 'Overlay is still usable')
        ->assertScript('document.querySelector("#second-table [data-table-content]").inert', false);
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail: {id: "invoice-table", loading: false}}));');
    $page->assertAttribute('#invoice-table', 'aria-busy', 'false')->keys('#invoice-note', 'Escape')
        ->click('#table-navigation')->assertPathIs('/livewire-components/table')->assertAttribute('#overview-table', 'aria-busy', 'false')
        ->assertNoJavaScriptErrors();
});

it('keeps borders footer and filter controls usable on mobile in both themes', function (): void {
    $page = visit('/livewire-components/table/filters')->resize(390, 780);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ');');
        $page->assertScript('getComputedStyle(document.querySelector("#invoice-table td")).borderRightWidth', '1px')
            ->assertScript('(() => { const el = document.querySelector("#invoice-table .sir-table-footer"); return getComputedStyle(el).gridTemplateColumns.split(" ").length; })()', 1)
            ->click('#invoice-table-filters-trigger')->assertVisible('#invoice-table-filter-status-search')
            ->click('#invoice-table-filters-trigger');
    }
    $page->script('document.querySelector("#invoice-table").scrollIntoView({block: "start"});');
    $page->screenshot(fullPage: false, filename: 'table-mobile')->assertNoJavaScriptErrors();
});
