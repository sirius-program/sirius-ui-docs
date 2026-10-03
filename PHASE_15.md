# Phase 15 — Avatar, Separator, and Skeleton

## Component contracts

Avatar accepts `src`, `alt`, `fallback`, `size` (`sm`, `md`, `lg`, `xl`), and `variant` (`circle`, `rounded`). The default size is md and shape is circle. Initials use the first and last words, or the first character of a single word, with Unicode uppercase support. An empty fallback displays the existing Blade user icon. The wrapper reserves space before the image loads. Missing, loading, or failed images display the fallback; changing the source allows recovery without automatic retry loops. The source and accessible descriptions are escaped.

The wrapper owns the accessible image name, using `alt` or consumer ARIA naming. With no name it is decorative; the nested image and initials do not create duplicate accessible content. Wrapper attributes, classes, and styles are forwarded. Avatar needs the bundled CSS and JavaScript. One document-level owner handles image events, source changes, Livewire morphs, removal/remounting, and navigation, including renders that reset the image state while retaining a cached image. No Alpine or Livewire wrapper is required for ordinary Blade use.

Separator renders a horizontal `hr` by default or a vertical `div`, with the matching separator orientation. `decorative=true` removes it from accessible content. A vertical separator stretches within a flex row; classes/styles can set another height. Separator uses the existing border color tokens and only needs CSS. It is a static divider, not a resizable splitter.

Skeleton accepts `width`, `height`, and `shape` (`rounded`, `rectangle`, `circle`). Defaults are 100%, 1rem, and rounded. Positive numbers are pixels; strings support the CSS length units listed in docs. Equal dimensions make a circle. The existing border token supplies its color. A gentle 1.8-second fade runs only when reduced motion is not requested. Skeleton remains hidden from assistive technology and is not keyboard focusable; its surrounding content owns loading announcements and `aria-busy`. It only needs CSS.

These anonymous Blade components retain the existing architecture boundaries and configurable namespace. No dependency, configuration key, translation string, production PHP class, or publishing tag was added. The package README remains a link to docs.

## Documentation and verification

Each component has separate Demo, Usage, Attributes, and Assets and interaction sections, with individual prop rows and copyable sources for every demo. Avatar demonstrates both variants; Skeleton demonstrates all shapes. Public demos use Blade. The Avatar Livewire lifecycle fixture is isolated at `/development/avatar` in local/testing environments. Avatar and Skeleton are inserted alphabetically in Presentation; Separator is inserted alphabetically in Layout. The docs index and README are updated.

Package feature tests cover Unicode initials, missing sources, size/shape contracts, accessible names and decorative state, escaped input, attribute forwarding, customized namespaces, separator semantics, Skeleton dimensions/accessibility, and invalid contracts. Docs feature tests render all pages and exercise the Livewire fixture. Browser tests verify failed-image fallback and recovery without layout shifts, unrelated Livewire morphs, removal/remounting, navigation, separator dimensions, mobile layouts in both themes, Skeleton visibility and sizing, and reduced-motion behavior. Mobile screenshots were visually reviewed.

Both asset builds passed. Package `composer test` passed with **393 tests / 1,294 assertions**. Docs `composer test` passed with **151 tests / 849 assertions**. The complete docs `composer test:browser -- --processes=2` passed with **128 tests / 1,446 assertions**. Lint, static analysis, Rector, and architecture checks passed. The existing compatibility CI matrix remains responsible for cross-version verification.

Image state uses both completion and natural dimensions because a failed image can also be marked complete; see [MDN image completion](https://developer.mozilla.org/en-US/docs/Web/API/HTMLImageElement/complete) and [natural dimensions](https://developer.mozilla.org/en-US/docs/Web/API/HTMLImageElement/naturalWidth). Accessibility and motion references: [separator role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/separator_role) and [reduced motion](https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/At-rules/@media/prefers-reduced-motion).
