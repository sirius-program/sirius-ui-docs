# Phase 23 — Livewire Chart

Completed on 2026-10-07. Full phase-gate results are recorded below.

## Shipped contract

The concrete Sirius\Ui\Livewire\Chart component is available as &lt;livewire:sirius::chart&gt;. Place it inside an application Livewire parent and pass data, type, options, label, description, width, height, and loading. These props are reactive; change them in the parent. An optional safe id becomes the locked chart identity, with a random five-character default.

Data contains native labels and a list of datasets. Numeric/null values, coordinate objects, tuples, keyed data, mixed dataset types, and serializable dataset settings pass through. All eight standard controllers are bundled. Eloquent and Collection mapping, data refresh, authorization, and aggregation belong to the application. No package model, source endpoint, or application migration is introduced.

PHP configuration accepts JSON-compatible values, rejects objects/functions/resources, non-finite numbers, excessive nesting, prototype keys, malformed datasets, unsafe controller names, and nonpositive sizing. Native option semantics still belong to Chart.js; unsupported native controllers/scales or faulty local factories show a translated inline error and Retry.

Default options are responsive true, maintainAspectRatio false, and animation duration 200 ms. The default stage is container-width by 320 px. Width is capped by the container. An explicit height forces maintainAspectRatio false; responsive false disables resize tracking. Number formatting defaults through sirius-ui.locale → app.locale → app.fallback_locale → en, normalized to an Intl locale; options.locale wins. No separate chart-specific global config was introduced.

Merge order: theme/library defaults, PHP options, then local extension options. Explicit height and reduced-motion policy override both. Theme defaults color scale text, grid/border lines, and legend/title text without suppressing the native dataset color palette or replacing explicit axis colors.

SiriusChart.register(id, factory) receives {id, element, wire, library} and returns only {options, plugins}. It supports actual local JavaScript callbacks, formatters, plugin objects, and application registration of additional native controllers/scales. Factories may not replace the managed canvas, type/data, synchronization, disposal, or reserved siriusTheme plugin. No JavaScript strings from Livewire are evaluated. Plugin resource cleanup belongs in afterDestroy; the returned unregister function removes only its current registration. Application events must validate their payload and authorize any action.

SiriusChart.get(id) returns the native chart or null after removal. Data changes reuse it; type/options/theme/factory changes replace it. Persistent changes belong in parent props. The root emits bubbling sirius:chart-ready and sirius:chart-error events. Hidden-to-visible resizing works in Tabs, Dialog, and Slideover. Removal/navigation destroys native instances, observers, and loading interceptors.

Loading covers the chart stage, preserves height, marks aria-busy, and blocks pointer/keyboard interaction. Requests from the chart or immediate Livewire parent show it automatically; explicit loading covers other application work. Empty/all-null values show the translated empty state. Rendering errors use inline Retry; application code handles failed data-source requests.

Canvas naming, optional linked descriptions, and translated fallback text remain available. Applications should provide their own text/table alternative for chart values; public demos were simplified during the documentation follow-up. Reduced motion disables animation, including animation requested by local extensions. Translations resolve individual keys under sirius::sirius-ui.chart.*, preserving fallback keys for partially translated groups; publishing remains sirius-ui-translations.

## Free dependencies and notices

| Dependency | Exact version | License |
| --- | --- | --- |
| chart.js | 4.5.1 | MIT |
| @kurkle/color | 0.3.4 | MIT |
| chartjs-adapter-date-fns | 3.0.0 | MIT |
| date-fns | 4.4.0 | MIT |

Chart.js was selected after checking its official native controller, mixed-chart, data, responsive, accessibility, update, plugin, and integration documentation and proving actual Livewire rendering. It covers the requested chart scope with no runtime CDN, account, paid plugin, or API key. The adapter and date-fns versions are proven by the browser time-scale case. Time/timeseries scales use the browser timezone, with English date-fns time labels by default. Additional date-fns locale objects can be imported by an application and passed through a local extension; sirius-ui.timezone is not applied to chart axes.

The build includes license texts for all bundled Chart dependencies in dist/third-party-notices.txt. Notice content is assembled in memory and written once, reducing repeated Windows file opens and avoiding partial notices if dependency validation fails. This followed a transient file-open failure during a build; no vendor or Windows files were changed.

Primary references: [Chart.js integration](https://www.chartjs.org/docs/latest/getting-started/integration.html), [configuration](https://www.chartjs.org/docs/latest/configuration/), [data structures](https://www.chartjs.org/docs/latest/general/data-structures.html), [mixed charts](https://www.chartjs.org/docs/latest/charts/mixed.html), [updates](https://www.chartjs.org/docs/latest/developers/updates.html), [plugins](https://www.chartjs.org/docs/latest/developers/plugins.html), [responsive sizing](https://www.chartjs.org/docs/latest/configuration/responsive.html), [accessibility](https://www.chartjs.org/docs/latest/general/accessibility.html), and [date-fns adapter](https://github.com/chartjs/chartjs-adapter-date-fns).

## Documentation and verification

Public pages are Overview at /livewire-components/chart, then /data, /extensions, and /options. Each has its own demo and Usage partial. Overview owns the full attributes, assets, global defaults, and separate translations sections. Chart sits alphabetically between Calendar and Table; Overview stays first within the group. Development integration lives at /development/chart in local/testing environments.

The Collection demo updates parent data/type/options and clears/restores data. Visibility/loading toggles are available only in development mode for lifecycle testing; conditional mounting lives in the demo wrapper so the Usage snippet remains a single chart. Public revenue demos omit these toggles, the revenue table, and its description. The Eloquent demo aggregates workspace-scoped invoice values. The extension demo formats tooltips, draws an inline plugin, and sends point indexes to an application Livewire listener that resolves current server values and rejects unrelated/missing points.

The loading adapter uses a scoped global Livewire message interceptor. The installed Livewire 4.4.4 per-component interceptor unsubscribe function throws during cleanup, so it is not used. The global interceptor is filtered to relevant component IDs and removed normally.

- Package composer test: passed, 662 tests / 2,056 assertions, including Pint, PHPStan max, Rector, and architecture checks.
- Docs composer test: passed, 208 tests / 1,200 assertions, including Pint, PHPStan, and Rector.
- Full docs browser gate: passed, 240 tests / 2,674 assertions, including all 13 Chart browser cases, with no test warnings. A final additional native aspect-ratio case passed separately (1 test / 4 assertions) against the same production build.
- Both asset builds: passed.

The first full browser run passed all Chart cases but failed one existing multiple-file upload assertion. Targeted replay of the upload tests and Chart tests passed (19 tests / 190 assertions), followed by a successful full suite. No upload component or upload test changes were needed.

Compared with the pre-phase compiled assets, Chart adds 260,554 bytes of JavaScript (84,286 bytes gzip, about 82.3 KiB), and 967 bytes of CSS (163 bytes gzip). The docs build retains its existing optional Fontaine and large-chunk notices. The five existing npm build-tool advisories were present before adding Chart; no unrelated dependency upgrades were made.

Browser coverage exercises native rendered canvas output, all controllers, mixed/time scales, fixed sizing, theme colors/palette, reactive parent updates and instance reuse/replacement, callbacks to Livewire, local plugins and disposal, repeated removal/remount, navigation, hidden resizing, stable empty/loading stages, held real request responses, instance isolation, rendering errors/retry, mobile light/dark themes, and reduced motion. The final verification is Windows/Chromium; the wider OS/browser/framework release matrix remains Phase 26.

Documentation cleanup verification on 2026-10-07: Toggle chart and Toggle loading are restricted to development mode; the public revenue table and its description are removed. The chart Usage snippet stays unconditional; lifecycle visibility is handled by the demo wrapper. Tests were aligned with the simplified current demos, including the removed invoice table and Collection demo on Data. The invoice demo keeps a separate Livewire root wrapper around its child chart.

- Docs build and composer test passed: 208 tests / 1,218 assertions, with lint, types, and refactoring passing.
- Final full browser suite passed: 241 tests / 2,677 assertions, including all 14 Chart cases, with no test warnings.
- Package implementation and assets were unchanged by this follow-up.
