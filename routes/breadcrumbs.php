<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Fixtures
Breadcrumbs::for('development.navigation', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.navigation');
    $trail->push('Navigation integration', route('development.navigation'));
});

Breadcrumbs::for('development.avatar', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Avatar integration', route('development.avatar'));
});

Breadcrumbs::for('development.basic-controls', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push('Basic control integration', route('development.basic-controls'));
});

Breadcrumbs::for('development.currency-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.currency');
    $trail->push('Currency binding integration', route('development.currency-bindings'));
});

Breadcrumbs::for('development.date-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.datetime-picker');
    $trail->push('Date binding integration', route('development.date-bindings'));
});

Breadcrumbs::for('development.fields', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push(__('Field integration'), route('development.fields'));
});

Breadcrumbs::for('development.phone-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.phone');
    $trail->push('Phone binding integration', route('development.phone-bindings'));
});

Breadcrumbs::for('development.richtext-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.richtext');
    $trail->push('Richtext binding integration', route('development.richtext-bindings'));
});

Breadcrumbs::for('development.select-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.select');
    $trail->push('Select binding integration', route('development.select-bindings'));
});

Breadcrumbs::for('development.slider-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.slider');
    $trail->push('Slider bindings', route('development.slider-bindings'));
});

Breadcrumbs::for('development.presentation', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Presentation integration', route('development.presentation'));
});

Breadcrumbs::for('development.layout-components', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Layout integration', route('development.layout-components'));
});

Breadcrumbs::for('development.tabs-timeline', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Tabs and Timeline integration', route('development.tabs-timeline'));
});

Breadcrumbs::for('development.overlays', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push('Overlay integration', route('development.overlays'));
});

Breadcrumbs::for('development.toast', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push('Toast integration', route('development.toast'));
});

// User Menu

Breadcrumbs::for('settings', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Settings'), route('appearance.edit'));
});

Breadcrumbs::for('appearance.edit', function (BreadcrumbTrail $trail): void {
    $trail->parent('settings');
    $trail->push(__('Appearance'), route('appearance.edit'));
});

// Main Menu

Breadcrumbs::for('home', function (BreadcrumbTrail $trail): void {
    $trail->push(__('Home'), route('home'));
});

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Dashboard'), route('dashboard'));
});

Breadcrumbs::for('started', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Getting Started'), route('started'));
});

// Blade Components

Breadcrumbs::for('blade-components.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Blade Components'));
});

// Form Control

Breadcrumbs::for('blade-components.form-control', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push(__('Form Control'));
});

Breadcrumbs::for('blade-components.choices', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Checkbox, Radio & Switch', route('blade-components.choices'));
});

Breadcrumbs::for('blade-components.currency', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Currency', route('blade-components.currency'));
});

Breadcrumbs::for('blade-components.datetime-picker', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Datetime Picker', route('blade-components.datetime-picker'));
});

Breadcrumbs::for('blade-components.file-upload', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('File Upload', route('blade-components.file-upload'));
});

Breadcrumbs::for('blade-components.form', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Form', route('blade-components.form'));
});

Breadcrumbs::for('blade-components.input', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Input', route('blade-components.input'));
});

Breadcrumbs::for('blade-components.label', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push(__('Label'), route('blade-components.label'));
});

Breadcrumbs::for('blade-components.phone', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Phone', route('blade-components.phone'));
});

Breadcrumbs::for('blade-components.richtext', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Richtext', route('blade-components.richtext'));
});

Breadcrumbs::for('blade-components.select', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Select', route('blade-components.select'));
});

Breadcrumbs::for('blade-components.slider', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Slider', route('blade-components.slider'));
});

Breadcrumbs::for('blade-components.textarea', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.form-control');
    $trail->push('Textarea', route('blade-components.textarea'));
});

// Presentation

Breadcrumbs::for('blade-components.presentation', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push(__('Presentation'));
});

Breadcrumbs::for('blade-components.badge', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Badge', route('blade-components.badge'));
});

Breadcrumbs::for('blade-components.alert', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Alert', route('blade-components.alert'));
});

Breadcrumbs::for('blade-components.avatar', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Avatar', route('blade-components.avatar'));
});

Breadcrumbs::for('blade-components.button', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Button', route('blade-components.button'));
});

Breadcrumbs::for('blade-components.button-group', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Button Group', route('blade-components.button-group'));
});

Breadcrumbs::for('blade-components.icon', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Icon', route('blade-components.icon'));
});

Breadcrumbs::for('blade-components.message', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Message', route('blade-components.message'));
});

Breadcrumbs::for('blade-components.popover', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Popover', route('blade-components.popover'));
});

Breadcrumbs::for('blade-components.skeleton', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Skeleton', route('blade-components.skeleton'));
});

Breadcrumbs::for('blade-components.timeline', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Timeline', route('blade-components.timeline'));
});

Breadcrumbs::for('blade-components.toast', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Toast', route('blade-components.toast'));
});

Breadcrumbs::for('blade-components.tooltip', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.presentation');
    $trail->push('Tooltip', route('blade-components.tooltip'));
});

// Navigation

Breadcrumbs::for('blade-components.navigation', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push('Navigation');
});

Breadcrumbs::for('blade-components.breadcrumb', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.navigation');
    $trail->push('Breadcrumb', route('blade-components.breadcrumb'));
});

Breadcrumbs::for('blade-components.dropdown', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.navigation');
    $trail->push('Dropdown', route('blade-components.dropdown'));
});

Breadcrumbs::for('blade-components.menu', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.navigation');
    $trail->push('Menu', route('blade-components.menu'));
});

// Layout

Breadcrumbs::for('blade-components.layout', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push(__('Layout'));
});

Breadcrumbs::for('blade-components.accordion', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Accordion', route('blade-components.accordion'));
});

Breadcrumbs::for('blade-components.card', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Card', route('blade-components.card'));
});

Breadcrumbs::for('blade-components.dialog', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Dialog', route('blade-components.dialog'));
});

Breadcrumbs::for('blade-components.slideover', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Slideover', route('blade-components.slideover'));
});

Breadcrumbs::for('blade-components.separator', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Separator', route('blade-components.separator'));
});

Breadcrumbs::for('blade-components.tabs', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.layout');
    $trail->push('Tabs', route('blade-components.tabs'));
});
