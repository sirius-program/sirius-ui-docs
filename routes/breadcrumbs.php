<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

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

Breadcrumbs::for('blade-components.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Blade Components'));
});

Breadcrumbs::for('blade-components.label', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push(__('Label'), route('blade-components.label'));
});

Breadcrumbs::for('development.fields', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push(__('Field integration'), route('development.fields'));
});

Breadcrumbs::for('blade-components.control', function (BreadcrumbTrail $trail, string $control): void {
    $trail->parent('blade-components.index');
    $trail->push($control === 'choices' ? 'Checkbox, Radio & Switch' : ucfirst($control), route('blade-components.control', ['control' => $control]));
});

Breadcrumbs::for('development.basic-controls', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push('Basic control integration', route('development.basic-controls'));
});

Breadcrumbs::for('settings', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Settings'), route('appearance.edit'));
});

Breadcrumbs::for('appearance.edit', function (BreadcrumbTrail $trail): void {
    $trail->parent('settings');
    $trail->push(__('Appearance'), route('appearance.edit'));
});

Breadcrumbs::for('blade-components.currency', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push('Currency', route('blade-components.currency'));
});

Breadcrumbs::for('development.currency-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.currency');
    $trail->push('Currency binding integration', route('development.currency-bindings'));
});

Breadcrumbs::for('blade-components.datetime-picker', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.index');
    $trail->push('Datetime Picker', route('blade-components.datetime-picker'));
});

Breadcrumbs::for('development.date-bindings', function (BreadcrumbTrail $trail): void {
    $trail->parent('blade-components.datetime-picker');
    $trail->push('Date binding integration', route('development.date-bindings'));
});
