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

Breadcrumbs::for('components.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Components'), route('components.index'));
});

Breadcrumbs::for('components.label', function (BreadcrumbTrail $trail): void {
    $trail->parent('components.index');
    $trail->push(__('Label'), route('components.label'));
});

Breadcrumbs::for('components.forms', function (BreadcrumbTrail $trail): void {
    $trail->parent('components.index');
    $trail->push(__('Form conventions'), route('components.forms'));
});

Breadcrumbs::for('settings', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push(__('Settings'), route('appearance.edit'));
});

Breadcrumbs::for('appearance.edit', function (BreadcrumbTrail $trail): void {
    $trail->parent('settings');
    $trail->push(__('Appearance'), route('appearance.edit'));
});
