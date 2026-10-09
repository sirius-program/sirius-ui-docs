<?php

declare(strict_types=1);

it('renders real charts for every bundled controller mixed datasets and the time adapter', function (): void {
    $page = visit('/development/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    foreach (['bar', 'line', 'pie', 'doughnut', 'radar', 'polarArea', 'scatter', 'bubble'] as $type) {
        $page->assertScript('window.SiriusChart.get("native-' . $type . '")?.config.type', $type)
            ->assertAttribute('#native-' . $type, 'data-chart-state', 'ready');
    }
    $page->assertScript('window.SiriusChart.get("mixed-chart").getDatasetMeta(1).type', 'line')
        ->assertScript('window.SiriusChart.get("time-chart").scales.x.type', 'time')
        ->assertScript('window.SiriusChart.get("time-chart").scales.x.ticks.length > 0', true)
        ->assertScript('window.SiriusChart.get("revenue-chart").data.datasets[0].backgroundColor', 'rgba(54, 162, 235, 0.5)')
        ->assertScript('window.SiriusChart.get("static-chart").height', 200)
        ->assertScript('Array.from(document.querySelector("#revenue-chart canvas").getContext("2d").getImageData(0,0,200,200).data).some((v,i)=>i%4===3 && v>0)', true)
        ->assertNoJavaScriptErrors();
});

it('updates reactive parent data without replacing the chart and recreates it for type and options', function (): void {
    $page = visit('/development/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->script('window.initialChart = window.SiriusChart.get("revenue-chart");');
    $page->click('[data-revenue-demo="revenue-chart"] button:has-text("Load projection")')
        ->assertScript('window.SiriusChart.get("revenue-chart").data.datasets[0].data[0]', 1400)
        ->assertScript('window.SiriusChart.get("revenue-chart") === window.initialChart', true)
        ->click('[data-revenue-demo="revenue-chart"] button:has-text("Change type")')
        ->assertScript('window.SiriusChart.get("revenue-chart").config.type', 'line')
        ->assertScript('window.SiriusChart.get("revenue-chart") !== window.initialChart', true)
        ->assertScript('window.initialChart.ctx', null)
        ->click('[data-revenue-demo="revenue-chart"] button:has-text("Change options")')
        ->assertScript('window.SiriusChart.get("revenue-chart").options.plugins.legend.display', false)
        ->assertScript('document.querySelector("#revenue-chart [data-chart-stage]").style.height', '240px')
        ->assertScript('window.SiriusChart.get("second-chart").data.datasets[0].data[0]', 20)
        ->assertNoJavaScriptErrors();
});

it('keeps empty and explicit loading states at a stable height and recovers when data returns', function (): void {
    $page = visit('/development/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->click('button:has-text("Clear data")')->assertSeeIn('#revenue-chart', 'No chart data.')
        ->assertAttribute('#revenue-chart', 'data-chart-state', 'empty')
        ->assertScript('document.querySelector("#revenue-chart [data-chart-stage]").offsetHeight', 320)
        ->click('button:has-text("Toggle loading")')->assertAttribute('#revenue-chart', 'aria-busy', 'true')
        ->assertVisible('#revenue-chart [data-chart-loading]')
        ->click('button:has-text("Toggle loading")')->assertAttribute('#revenue-chart', 'aria-busy', 'false')
        ->click('button:has-text("Reset sample")')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready')
        ->assertVisible('#revenue-chart canvas')->assertNoJavaScriptErrors();
});

it('resizes charts when revealed in Tabs Dialog and Slideover', function (): void {
    $page = visit('/development/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->click('#chart-tabs [role="tab"]:has-text("Chart")')
        ->assertScript('window.SiriusChart.get("tab-chart").width > 200', true)
        ->click('[data-sir-dialog-open="chart-dialog"]')->assertPresent('#chart-dialog:modal')
        ->assertScript('window.SiriusChart.get("dialog-chart").width > 200', true);
    $page->script('window.dialogChart = window.SiriusChart.get("dialog-chart");');
    $page->click('#chart-dialog [data-sir-dialog-close]')->assertNotPresent('#chart-dialog:modal')
        ->click('[data-sir-dialog-open="chart-dialog"]')->assertPresent('#chart-dialog:modal')
        ->assertScript('window.dialogChart === window.SiriusChart.get("dialog-chart")', true)
        ->click('#chart-dialog [data-sir-dialog-close]')
        ->assertNotPresent('#chart-dialog:modal')
        ->click('[data-sir-dialog-open="chart-slideover"]')->assertPresent('#chart-slideover:modal')
        ->assertScript('window.SiriusChart.get("slideover-chart").width > 200', true)->assertNoJavaScriptErrors();
});

it('runs local callbacks and plugins and retains them across reactive updates', function (): void {
    $page = visit('/livewire-components/chart/extensions')->assertAttribute('#extensions-chart', 'data-chart-state', 'ready');
    $page->assertScript('typeof window.SiriusChart.get("extensions-chart").options.onClick', 'function')
        ->assertScript('window.SiriusChart.get("extensions-chart").config.plugins.some(plugin => plugin.id === "areaOutline")', true);
    $position = $page->script('(() => { const chart=window.SiriusChart.get("extensions-chart"); const p=chart.getDatasetMeta(0).data[0].getCenterPoint(); return {x:p.x,y:p.y}; })()');
    $page->page()->locator('#extensions-chart canvas')->click(['position' => $position]);
    $page->assertSeeIn('[data-chart-selection]', 'Jan: 1200')
        ->click('button:has-text("Load projection")')
        ->assertScript('window.SiriusChart.get("extensions-chart").data.datasets[0].data[0]', 1400)
        ->assertScript('window.SiriusChart.get("extensions-chart").options.plugins.tooltip.callbacks.label({dataset:{label:"Revenue"},parsed:{y:1400}})', 'Revenue: $1,400.00')
        ->assertNoJavaScriptErrors();
});

it('cleans plugins and native instances on removal remount and navigation', function (): void {
    $page = visit('/development/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->script('window.chartDraws=0; window.chartDestroyed=0; window.unregisterChart=window.SiriusChart.register("revenue-chart", () => ({plugins:[{id:"cleanupProbe", afterDraw(){window.chartDraws++}, afterDestroy(){window.chartDestroyed++}}]})); void 0;');
    $page->assertScript('window.chartDraws > 0', true);
    for ($index = 0; $index < 2; $index++) {
        $page->click('button:has-text("Toggle chart")')
            ->assertScript('Livewire.find(document.querySelector("[data-revenue-demo]").getAttribute("wire:id")).$get("visible")', false)
            ->assertNotPresent('#revenue-chart')
            ->assertScript('window.SiriusChart.get("revenue-chart")', null)
            ->click('button:has-text("Toggle chart")')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready')
            ->assertScript('document.querySelectorAll("#revenue-chart canvas").length', 1);
    }
    $page->assertScript('window.chartDestroyed', 2);
    $page->click('[data-docs-sidebar] button[data-sir-submenu-trigger]:has-text("Chart")')
        ->click('[data-docs-sidebar] a[href$="/livewire-components/chart/options"]')->assertPathIs('/livewire-components/chart/options')
        ->assertAttribute('#options-chart', 'data-chart-state', 'ready')->assertScript('window.SiriusChart.get("revenue-chart")', null)
        ->assertScript('window.chartDestroyed', 3)->assertNoJavaScriptErrors();
});

it('shows translated render errors and can retry after a local extension repairs configuration', function (): void {
    $page = visit('/development/chart')->assertAttribute('#invalid-chart', 'data-chart-state', 'error')
        ->assertSeeIn('#invalid-chart', 'Unable to display the chart. Try again.');
    $page->script('window.SiriusChart.register("invalid-chart", ({library}) => { class CustomBar extends library.registry.getController("bar") {} CustomBar.id="unknownController"; CustomBar.defaults=library.registry.getController("bar").defaults; CustomBar.overrides=library.registry.getController("bar").overrides; library.register(CustomBar); return {}; }); void 0;');
    $page->assertAttribute('#invalid-chart', 'data-chart-state', 'ready')->assertVisible('#invalid-chart canvas')->assertNoJavaScriptErrors();
});

it('fits mobile themes and preserves accessible chart naming', function (bool $dark): void {
    $pending = visit('/livewire-components/chart')->on()->mobile();
    $page = ($dark ? $pending->inDarkMode() : $pending->inLightMode())->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->assertScript('document.documentElement.scrollWidth <= window.innerWidth', true)
        ->assertScript('window.SiriusChart.get("revenue-chart").scales.x.options.ticks.color === getComputedStyle(document.querySelector("#revenue-chart")).color', true)
        ->assertAttribute('#revenue-chart canvas', 'aria-label', 'Monthly revenue')
        ->assertScript('document.querySelector("#revenue-chart canvas").hasAttribute("aria-describedby")', false)
        ->assertNoJavaScriptErrors();
    $page->screenshotElement('#revenue-chart', $dark ? 'chart-dark' : 'chart-light');
})->with([true, false]);

it('disables chart animations for reduced motion even when a local extension requests animation', function (): void {
    $page = visit('/livewire-components/chart', ['reducedMotion' => 'reduce'])->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->script('window.SiriusChart.register("revenue-chart", () => ({options:{animation:{duration:1000}}})); void 0;');
    $page->assertScript('window.SiriusChart.get("revenue-chart").options.animation', false)
        ->click('button:has-text("Load projection")')
        ->assertScript('window.SiriusChart.get("revenue-chart").data.datasets[0].data[0]', 1400)->assertNoJavaScriptErrors();
});

it('keeps parent requests covered until their responses arrive without blocking another chart', function (): void {
    $page = visit('/development/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->script('window.originalChartFetch=window.fetch; window.fetch=(...args)=>{const pending=window.originalChartFetch(...args); return String(args[1]?.body).includes("loadProjection") ? pending.then(response=>new Promise(resolve=>{window.releaseChartResponse=()=>resolve(response)})) : pending;}; void 0;');
    $page->click('[data-revenue-demo="revenue-chart"] button:has-text("Load projection")')
        ->assertAttribute('#revenue-chart', 'aria-busy', 'true')->assertVisible('#revenue-chart [data-chart-loading]')
        ->assertAttribute('#second-chart', 'aria-busy', 'false')
        ->assertScript('document.querySelector("#revenue-chart [data-chart-stage]").offsetHeight', 320);
    $page->assertScript('typeof window.releaseChartResponse', 'function');
    $page->script('window.releaseChartResponse(); window.fetch=window.originalChartFetch;');
    $page->assertScript('window.SiriusChart.get("revenue-chart").data.datasets[0].data[0]', 1400)
        ->assertAttribute('#revenue-chart', 'aria-busy', 'false')->assertNoJavaScriptErrors();
});

it('shows retry for a failing local factory and recovers without duplicate canvas instances', function (): void {
    $page = visit('/livewire-components/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->script('window.failChartOnce=true; window.SiriusChart.register("revenue-chart", () => {if(window.failChartOnce){window.failChartOnce=false; throw new Error("Application extension failed")} return {options:{plugins:{legend:{display:false}}}};}); void 0;');
    $page->assertAttribute('#revenue-chart', 'data-chart-state', 'error')->assertSeeIn('#revenue-chart', 'Unable to display the chart. Try again.')
        ->click('#revenue-chart [data-chart-retry]')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready')
        ->assertScript('window.SiriusChart.get("revenue-chart").options.plugins.legend.display', false)
        ->assertScript('document.querySelectorAll("#revenue-chart canvas").length', 1)->assertNoJavaScriptErrors();
});

it('applies explicit size changes to nonresponsive charts and preserves local option precedence', function (): void {
    $page = visit('/livewire-components/chart')->assertAttribute('#revenue-chart', 'data-chart-state', 'ready');
    $page->script('window.SiriusChart.register("revenue-chart", () => ({options:{responsive:false,maintainAspectRatio:true,locale:"de-DE",scales:{y:{ticks:{color:"#ff0000"}}}}})); void 0;');
    $page->assertScript('window.SiriusChart.get("revenue-chart").options.responsive', false)
        ->assertScript('window.SiriusChart.get("revenue-chart").options.maintainAspectRatio', false)
        ->assertScript('window.SiriusChart.get("revenue-chart").options.locale', 'de-DE')
        ->assertScript('window.SiriusChart.get("revenue-chart").scales.y.options.ticks.color', '#ff0000');
    $page->script('window.sizedChart=window.SiriusChart.get("revenue-chart"); Livewire.find(document.querySelector("[data-revenue-demo]").getAttribute("wire:id")).$set("height",200); void 0;');
    $page->assertScript('window.SiriusChart.get("revenue-chart").height', 200)
        ->assertScript('window.SiriusChart.get("revenue-chart") === window.sizedChart', true)
        ->assertNoJavaScriptErrors();
});

it('honors native aspect ratios when height is omitted without overflowing the stage', function (): void {
    $page = visit('/development/chart')->assertAttribute('#second-chart', 'data-chart-state', 'ready');
    $page->script('window.SiriusChart.register("second-chart", () => ({options:{maintainAspectRatio:true,aspectRatio:1}})); void 0;');
    $page->assertScript('Math.abs(window.SiriusChart.get("second-chart").width - window.SiriusChart.get("second-chart").height) < 2', true)
        ->assertScript('(() => {const root=document.querySelector("#second-chart");return root.querySelector("canvas").getBoundingClientRect().bottom <= root.querySelector("[data-chart-stage]").getBoundingClientRect().bottom+1})()', true)
        ->assertNoJavaScriptErrors();
});
