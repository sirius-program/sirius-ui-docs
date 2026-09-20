<?php

declare(strict_types=1);

it('selects native local options with keyboard and submits stable single and multiple IDs', function (): void {
    $page = visit('/blade-components/select');
    $single = '[data-sir-select]:has(#blade-select-shipping) .ts-control input';
    $page->click($single)->type($single, 'Collect')->keys($single, 'ArrowDown')->keys($single, 'Enter');
    expect($page->script('new FormData(document.querySelector("[data-blade-select]")).get("shipping")'))->toBe('0');
    $multiple = '[data-sir-select]:has(#blade-select-topics) .ts-control input';
    $page->click($multiple)->type($multiple, 'Design')->keys($multiple, 'Enter');
    expect($page->script('new FormData(document.querySelector("[data-blade-select]")).getAll("topics[]")'))->toBe(['design']);
    $page->assertNoJavaScriptErrors();
});

it('loads Livewire selections resolves remote labels and preserves values across validation and readonly changes', function (): void {
    $page = visit('/blade-components/select')->click('[data-select-example] button:has-text("Load Value")')
        ->assertSeeIn('[data-select-example] [data-sir-select]:has([data-select-venue]) .ts-control .item', 'Bali garden pavilion')->assertSeeIn('[data-select-example] [data-sir-select]:has([data-select-shipping]) .ts-control .item', 'Collect from store')
        ->click('[data-select-example] button:has-text("Submit / Validate")')->assertSee('Selections validated. Nothing was stored.')
        ->click('[data-select-example] button:has-text("Toggle Readonly")');
    $page->assertAttribute('[data-select-example] [data-sir-select]:has([data-select-shipping]) .ts-control input', 'aria-readonly', 'true');
    $page->click('[data-select-example] button:has-text("Reset Sample")')->assertMissing('[data-select-example] .ts-control .item');
    $wire = 'Livewire.find(document.querySelector("[data-select-example]").getAttribute("wire:id"))';
    expect($page->script($wire . '.$get("shipping")'))->toBeNull();
    expect($page->script($wire . '.$get("topics")'))->toBe([]);
    $page->assertNoJavaScriptErrors();
});

it('searches paginated remote options without losing existing selections', function (): void {
    $page = visit('/blade-components/select');
    $input = '[data-sir-select]:has(#blade-select-venue) .ts-control input';
    $page->click($input)->assertSee('Jakarta conference hall');
    $page->click('[data-sir-select]:has(#blade-select-venue) button:has-text("Load more")')->assertSeeIn('[data-sir-select]:has(#blade-select-venue) .ts-dropdown-content', 'Bali garden pavilion');
    $page->click('[data-sir-select]:has(#blade-select-venue) .option[data-value="bali"]');
    expect($page->script('new FormData(document.querySelector("[data-blade-select]")).get("venue")'))->toBe('bali');
    $page->click($input)->type($input, 'Yogyakarta')->assertSee('Yogyakarta cultural center');
    expect($page->script('new FormData(document.querySelector("[data-blade-select]")).get("venue")'))->toBe('bali');
    $page->assertNoJavaScriptErrors();
});

it('resets native selections and external controls and handles disabled readonly and option updates', function (): void {
    $page = visit('/development/select');
    expect($page->script('typeof window.Livewire'))->toBe('undefined');
    expect($page->script('Object.fromEntries(new FormData(document.querySelector("form")))'))->toBe(['shipping' => '0', 'topics[]' => 'design', 'readonly' => 'design', 'external' => 'research']);
    $page->click('[data-sir-select]:has(#native-single) [data-select-clear]');
    expect($page->script('new FormData(document.querySelector("form")).get("shipping")'))->toBe('');
    $page->click('[data-sir-select]:has(#external-select) [data-select-clear]')->click('Native reset');
    $page->assertSeeIn('[data-sir-select]:has(#native-single) .item', 'Collect from store')->assertSeeIn('[data-sir-select]:has(#external-select) .item', 'Research');
    $page->assertDisabled('[data-sir-select]:has(#native-disabled) .ts-control input');
    $page->assertDisabled('[data-sir-select]:has(#native-readonly) [data-select-clear]');
    $page->script('document.querySelector("#native-single").add(new Option("Same-day delivery", "same-day"))');
    $input = '[data-sir-select]:has(#native-single) .ts-control input';
    $page->click('[data-sir-select]:has(#native-single) .ts-control')->type($input, 'Same-day')->keys($input, 'Enter');
    expect($page->script('new FormData(document.querySelector("form")).get("shipping")'))->toBe('same-day');
    $page->script('const select = document.querySelector("#native-single"); select.value = "express"; select.dispatchEvent(new Event("change", {bubbles:true}))');
    $page->assertSeeIn('[data-sir-select]:has(#native-single) .item', 'Express delivery')->assertNoJavaScriptErrors();
});

it('synchronizes Alpine arrays and independent Livewire controls through remount and navigation', function (): void {
    $page = visit('/development/select-bindings')->assertSeeIn('[data-alpine-choice]', '0')->assertSeeIn('[data-alpine-interests]', '["design"]');
    $page->click('[data-sir-select]:has(#alpine-select) [data-select-clear]')->assertSeeIn('[data-alpine-choice]', 'null');
    $page->click('Load Alpine selections')->assertSeeIn('[data-sir-select]:has(#alpine-select) .item', 'Express delivery')->assertSeeIn('[data-alpine-interests]', '["research"]');
    $page->click('[data-select-instance="first"] button:has-text("Load Value")')->assertSeeIn('[data-select-instance="first"] [data-sir-select]:has([data-select-shipping]) .item', 'Collect from store');
    $page->assertMissing('[data-select-instance="second"] .item');
    $wire = 'Livewire.find(document.querySelector("[data-select-instance=first] [data-select-example]").getAttribute("wire:id"))';
    $page->script($wire . '.$set("showControls", false)');
    $page->assertMissing('[data-select-instance="first"] .ts-wrapper');
    $page->script($wire . '.$set("showControls", true)');
    $page->assertSeeIn('[data-select-instance="first"] [data-sir-select]:has([data-select-shipping]) .item', 'Collect from store');
    $page->click('Phone')->assertPresent('[data-phone-delivery]')->click('Select')->assertPresent('[data-select-shipping]')->assertNoJavaScriptErrors();
});

it('ignores stale search responses and offers retry after remote failures', function (): void {
    $page = visit('/blade-components/select');
    $page->script('window.originalFetch = window.fetch; window.selectFail = true; window.selectRequests = []; window.fetch = async (url, init) => { if (!String(url).includes("select-options")) return window.originalFetch(url, init); const q = new URL(url).searchParams.get("q") || ""; window.selectRequests.push(q); if (q === "fail" && window.selectFail) return new Response("{}", {status: 503}); await new Promise(resolve => setTimeout(resolve, q === "old" ? 700 : 20)); return new Response(JSON.stringify({options: q === "fail" ? [] : [{value:q || "initial", label:q || "Initial"}], hasMore:false}), {headers:{"Content-Type":"application/json"}}); };');
    $input = '[data-sir-select]:has(#blade-select-venue) .ts-control input';
    $page->click($input)->type($input, 'old');
    $page->script('new Promise(resolve => { const check = () => window.selectRequests.includes("old") ? resolve(true) : setTimeout(check, 10); check(); })');
    $page->type($input, 'new')->assertSeeIn('[data-sir-select]:has(#blade-select-venue) .ts-dropdown-content', 'new');
    $page->script('new Promise(resolve => setTimeout(resolve, 750))');
    $page->assertMissing('[data-sir-select]:has(#blade-select-venue) .option[data-value="old"]');
    $page->type($input, 'fail')->assertSee('Unable to load options. Try again.');
    expect($page->script('document.querySelector("#blade-select-venue-label-status").parentElement.classList.contains("sir-label-row")'))->toBeTrue();
    $page->script('window.selectFail = false; void 0');
    $page->click('[data-sir-select]:has(#blade-select-venue) button[aria-label="Retry"]')->assertSee('No options found.')->assertNoJavaScriptErrors();
});

it('keeps the select page within mobile light and dark layouts', function (): void {
    $page = visit('/blade-components/select')->resize(390, 844);
    foreach ([false, true] as $dark) {
        $page->script('document.documentElement.classList.toggle("dark", ' . ($dark ? 'true' : 'false') . ')');
        expect($page->script('document.documentElement.scrollWidth <= innerWidth'))->toBeTrue();
        $page->screenshot(fullPage: true, filename: $dark ? 'select-mobile-dark' : 'select-mobile-light');
    }
    $page->assertNoJavaScriptErrors();
});

it('keeps native selects hidden after user selection and shows groups and suffix actions', function (): void {
    $page = visit('/blade-components/select');
    $root = '[data-select-example] [data-sir-select]:has([data-select-shipping])';
    $page->click($root . ' .ts-control')->assertSeeIn($root . ' [data-group="Local"] .optgroup-header', 'Local');
    $page->click($root . ' .option[data-value="0"]')->waitForEvent('networkidle');
    expect($page->script('getComputedStyle(document.querySelector("[data-select-shipping]")).display'))->toBe('none');
    expect($page->script('Livewire.find(document.querySelector("[data-select-example]").getAttribute("wire:id")).$get("shipping")'))->toBe('0');
    $page->click('[data-blade-select] button[value="load"]')->assertSeeIn('[data-sir-select]:has(#blade-select-topics) .ts-control', 'Design');
    expect($page->script('(() => { const root = document.querySelector("[data-sir-select]:has(#blade-select-topics)"); return root.querySelector("[data-select-clear]").getBoundingClientRect().left >= root.querySelector(".ts-wrapper").getBoundingClientRect().right; })()'))->toBeTrue();
    $page->assertNoJavaScriptErrors();
});
