<?php

declare(strict_types=1);

it('updates checked rows without an overlay while preserving external loading', function (string $selector, string $count): void {
    $page = visit('/livewire-components/table/bulk-actions');
    $holdRequest = 'window.originalSelectionFetch = window.fetch; window.selectionRequestHeld = false; window.fetch = (...args) => String(args[0]).includes("livewire") ? new Promise(resolve => { window.selectionRequestHeld = true; window.releaseSelectionRequest = () => { window.fetch = window.originalSelectionFetch; resolve(window.originalSelectionFetch(...args)); }; }) : window.originalSelectionFetch(...args);';
    $page->script($holdRequest);
    $page->click($selector)->assertScript('window.selectionRequestHeld', true)
        ->assertScript('document.querySelector("#bulk-invoices [data-table-loading]").hidden', true)
        ->assertScript('document.querySelector("#bulk-invoices [data-table-content]").inert', false);
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail:{id:"bulk-invoices",loading:true}}));');
    $page->assertVisible('#bulk-invoices [data-table-loading]');
    $page->script('window.releaseSelectionRequest();');
    $page->assertSeeIn('#bulk-invoices [data-table-selected-count]', $count)
        ->assertVisible('#bulk-invoices [data-table-loading]')->assertAttribute('#bulk-invoices', 'aria-busy', 'true');
    $page->script('document.dispatchEvent(new CustomEvent("table:loading", {detail:{id:"bulk-invoices",loading:false}}));');
    $page->assertAttribute('#bulk-invoices', 'aria-busy', 'false');
    $page->script($holdRequest);
    $page->click($selector)->assertScript('window.selectionRequestHeld', true)
        ->assertScript('document.querySelector("#bulk-invoices [data-table-loading]").hidden', true)
        ->assertScript('document.querySelector("#bulk-invoices [data-table-content]").inert', false);
    $page->script('window.releaseSelectionRequest();');
    $page->assertSeeIn('#bulk-invoices [data-table-selected-count]', '0 selected')->assertNoJavaScriptErrors();
})->with(['row' => ['#bulk-invoices-select-row-0', '1 selected'], 'current page' => ['#bulk-invoices-select-page', '10 selected']]);

it('selects this page and preserves cross page choices with keyboard operation', function (): void {
    $page = visit('/livewire-components/table/bulk-actions')->assertScript('document.querySelector("#bulk-invoices-bulk-trigger").disabled', true)
        ->click('#bulk-invoices-select-row-0')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '1 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', true)
        ->keys('#bulk-invoices-select-page', 'Space')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '10 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").checked', true)
        ->click('#bulk-invoices .sir-table-pagination button:has-text("Next")')
        ->assertSeeIn('#bulk-invoices .sir-table-footer', '11–20')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").checked', false)
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', false)
        ->assertScript('Array.from(document.querySelectorAll("#bulk-invoices tbody input[type=checkbox]")).every(input => !input.checked)', true)
        ->click('#bulk-invoices-select-row-0')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '11 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").checked', false)
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', true)
        ->click('#bulk-invoices th button:has-text("Customer")')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '11 selected')
        ->select('#bulk-invoices-per-page', '25')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '11 selected');
    $page->click('#bulk-invoices-bulk-trigger')->click('#bulk-invoices-bulk-menu button:has-text("Review selected")')
        ->assertPresent('#bulk-invoices-review:modal')->assertSeeIn('#bulk-invoices-review', 'INV-1042')
        ->assertSeeIn('#bulk-invoices-review', 'INV-1052')->click('#bulk-invoices-review button:has-text("Cancel")')
        ->assertMissing('#bulk-invoices-review:modal')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '11 selected')
        ->type('#bulk-invoices-search', 'Orbit')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '0 selected')
        ->assertScript('document.querySelector("#bulk-invoices-bulk-trigger").disabled', true)->assertNoJavaScriptErrors();
});

it('keeps Table columns stable when paging through different records', function (): void {
    $page = visit('/livewire-components/table/bulk-actions');
    $page->script('window.tableColumnWidths = Array.from(document.querySelectorAll("#bulk-invoices th")).map(cell => cell.getBoundingClientRect().width);');
    $page->assertScript('window.tableColumnWidths[0] >= 36 && window.tableColumnWidths[0] <= 60', true)
        ->assertScript('Math.max(...window.tableColumnWidths.slice(1)) - Math.min(...window.tableColumnWidths.slice(1)) < 2', true)
        ->click('#bulk-invoices .sir-table-pagination button:has-text("Next")')
        ->assertSeeIn('#bulk-invoices .sir-table-footer', '11–20')
        ->assertScript('Array.from(document.querySelectorAll("#bulk-invoices th")).every((cell, index) => Math.abs(cell.getBoundingClientRect().width - window.tableColumnWidths[index]) < 2)', true)
        ->assertNoJavaScriptErrors();
});

it('updates header and row checkboxes after deselection and explicit application cleanup', function (): void {
    $page = visit('/livewire-components/table/bulk-actions')->click('#bulk-invoices-select-page')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '10 selected')
        ->click('#bulk-invoices-select-row-0')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '9 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").checked', false)
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', true)
        ->click('#bulk-invoices-select-page')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '10 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").checked', true)
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', false)
        ->click('#bulk-invoices-select-page')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '0 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").checked', false)
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', false)
        ->assertScript('Array.from(document.querySelectorAll("#bulk-invoices tbody input[type=checkbox]")).every(input => !input.checked)', true)
        ->click('#bulk-invoices-select-page')->assertSeeIn('#bulk-invoices [data-table-selected-count]', '10 selected');
    $page->script('document.dispatchEvent(new CustomEvent("table:remove-selection.bulk-invoices", {bubbles:true, detail:{ids:[1]}}));');
    $page->assertSeeIn('#bulk-invoices [data-table-selected-count]', '9 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-row-0").checked', false)
        ->assertScript('document.querySelector("#bulk-invoices-select-page").checked', false)
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', true);
    $page->script('document.dispatchEvent(new CustomEvent("table:clear-selection.bulk-invoices", {bubbles:true}));');
    $page->assertSeeIn('#bulk-invoices [data-table-selected-count]', '0 selected')
        ->assertScript('document.querySelector("#bulk-invoices-select-page").indeterminate', false)
        ->assertScript('Array.from(document.querySelectorAll("#bulk-invoices input[data-table-checked]")).every(input => !input.checked)', true)
        ->assertNoJavaScriptErrors();
});

it('recovers review loading after failure and removes selection only after application success', function (): void {
    $page = visit('/livewire-components/table/bulk-actions')->click('#bulk-invoices-select-row-0')
        ->click('#bulk-invoices-select-row-1')->click('#bulk-invoices-bulk-trigger')
        ->click('#bulk-invoices-bulk-menu button:has-text("Review selected")')
        ->click('#bulk-invoices-review button:has-text("Start review")')->assertSeeIn('#bulk-invoices-review', 'The note field is required.')
        ->type('#bulk-invoices-note', 'Ready for billing')->click('#bulk-invoices-review button:has-text("Start review")')
        ->assertAttribute('#bulk-invoices', 'aria-busy', 'true')->assertVisible('#bulk-invoices [data-table-loading]')
        ->assertScript('document.querySelector("#bulk-invoices-bulk-trigger").disabled', true)
        ->assertScript('document.querySelector("#bulk-invoices [data-table-content]").inert', true)
        ->assertScript('document.querySelector("#bulk-invoices-search").disabled', false)
        ->click('#bulk-invoices-review button:has-text("Simulate failure")')
        ->assertAttribute('#bulk-invoices', 'aria-busy', 'false')->assertPresent('#bulk-invoices-review:modal')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '2 selected')
        ->click('#bulk-invoices-review button:has-text("Start review")')
        ->click('#bulk-invoices-review button:has-text("Complete review")')->assertMissing('#bulk-invoices-review:modal')
        ->assertSeeIn('#bulk-invoices-feedback', 'Reviewed 2 invoices: Ready for billing')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '0 selected')
        ->assertAttribute('#bulk-invoices', 'aria-busy', 'false')->assertNoJavaScriptErrors();
});

it('keeps cancelled processing selections and reopens the same application owned overlay', function (): void {
    $page = visit('/livewire-components/table/bulk-actions')->click('#bulk-invoices-select-row-0')
        ->click('#bulk-invoices-bulk-trigger')->click('#bulk-invoices-bulk-menu button:has-text("Review selected")')
        ->type('#bulk-invoices-note', 'Check later')->click('#bulk-invoices-review button:has-text("Start review")')
        ->assertAttribute('#bulk-invoices', 'aria-busy', 'true')->click('#bulk-invoices-review button:has-text("Cancel")')
        ->assertMissing('#bulk-invoices-review:modal')->assertAttribute('#bulk-invoices', 'aria-busy', 'false')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '1 selected')
        ->click('#bulk-invoices-bulk-trigger')->click('#bulk-invoices-bulk-menu button:has-text("View selection")')
        ->assertPresent('#bulk-invoices-details:modal')->assertSeeIn('#bulk-invoices-details', 'INV-1042')
        ->click('#bulk-invoices-details button:has-text("Close")')->assertMissing('#bulk-invoices-details:modal')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '1 selected')->assertNoJavaScriptErrors();
});

it('passes selected IDs through Alert and navigation and clears them only on explicit completion', function (): void {
    $page = visit('/livewire-components/table/bulk-actions')->click('#bulk-invoices-select-row-0')
        ->click('#bulk-invoices-bulk-trigger')->click('#bulk-invoices-bulk-menu button:has-text("Prepare reminders")')
        ->assertPresent('#bulk-invoices-confirm:modal')->assertSeeIn('#bulk-invoices-confirm', 'INV-1042')
        ->click('#bulk-invoices-confirm button:has-text("Cancel")')->assertMissing('#bulk-invoices-confirm:modal')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '1 selected')
        ->click('#bulk-invoices-bulk-trigger')->click('#bulk-invoices-bulk-menu button:has-text("Prepare reminders")')
        ->click('#bulk-invoices-confirm button:has-text("Prepare reminders")')
        ->assertSeeIn('#bulk-invoices-feedback', 'Prepared reminders for 1 invoices. Nothing was sent.')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '0 selected')
        ->click('#bulk-invoices-select-row-0')->click('#bulk-invoices-select-row-1')->click('#bulk-invoices-bulk-trigger')
        ->click('#bulk-invoices-bulk-menu a:has-text("Open selected invoices")')
        ->assertPathIs('/livewire-components/table/bulk-actions')->assertSeeIn('#linked-selection', 'INV-1042, INV-1043')
        ->assertSeeIn('#bulk-invoices [data-table-selected-count]', '0 selected')->assertNoJavaScriptErrors();
});

it('isolates bulk selection and cleanup across Tables and clears choices on registered filter changes', function (): void {
    $page = visit('/development/table')->click('#bulk-first-select-row-0')->click('#bulk-second-select-row-1')
        ->assertSeeIn('#bulk-first [data-table-selected-count]', '1 selected')
        ->assertSeeIn('#bulk-second [data-table-selected-count]', '1 selected');
    $page->script('document.dispatchEvent(new CustomEvent("table:clear-selection.bulk-first", {bubbles:true}));');
    $page->assertSeeIn('#bulk-first [data-table-selected-count]', '0 selected')
        ->assertSeeIn('#bulk-second [data-table-selected-count]', '1 selected')
        ->click('#bulk-second-filters-trigger')->type('#bulk-second-filter-status-search', 'Paid')
        ->click('#bulk-second-filters-menu .option[data-value="paid"]')
        ->assertSeeIn('#bulk-second [data-table-selected-count]', '0 selected')->assertNoJavaScriptErrors();
});

it('keeps bulk selection and buttons usable in mobile light and dark layouts', function (string $theme): void {
    $page = visit('/livewire-components/table/bulk-actions');
    $page->script('document.documentElement.classList.toggle("dark", ' . ($theme === 'dark' ? 'true' : 'false') . ');');
    $page->resize(320, 780)->click('#bulk-invoices-select-row-0')->click('#bulk-invoices-bulk-trigger')
        ->assertVisible('#bulk-invoices-bulk-menu')->assertScript('document.documentElement.scrollWidth <= innerWidth', true)
        ->click('#bulk-invoices-bulk-menu button:has-text("View selection")')->assertPresent('#bulk-invoices-details:modal')
        ->assertNoJavaScriptErrors();
})->with(['light', 'dark']);
