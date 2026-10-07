# Changelog

## Unreleased — 2026-10-07

### Added

- Blade form controls: Label, Input/password, Textarea, Checkbox, Radio, Switch, Currency, Datetime Picker, Phone, Select, File Upload, Richtext, Slider, and native Form.
- Presentation, layout, and navigation components: Icon, Button/group, Badge, Message, Card, Accordion, Dialog, Alert, Slideover, Toast, Avatar, Separator, Skeleton, Breadcrumb, Menu, Dropdown, Tooltip, Popover, Tabs, and Timeline.
- Livewire Table with Builder/Collection sources and external row/bulk action contexts; FullCalendar Standard scheduling with application-owned persistence; Chart.js charts with reactive data and local extensions.
- Version-matched AI agent skill, offline references, Boost discovery, and explicit standalone project-local installation.
- Sirius-based documentation shell, individual component examples, and split Table/Calendar/Chart guides.

### Release validation fixes

- Translate Currency/Datetime Picker validity feedback, password visibility labels, and Phone feedback/accessibility text through the package translation file. Explicit labels retain priority.
- Restore PHP 8.3-compatible test syntax and set Rector's minimum target accordingly.
- Preserve country display labels across metadata builds and check generated metadata/assets in CI.
- Extend CI to all six Laravel 12/13 and PHP 8.3/8.4/8.5 combinations.
- Update approved security dependencies and align Vite+ tooling for clean installation. Composer/npm audits are clean on the validation date.

See [Phase 26](PHASE_26.md) for tests, compatibility versions, installation evidence, and deferred validation. Release numbering and publication are still pending.
