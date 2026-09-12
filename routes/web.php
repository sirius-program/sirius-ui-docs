<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('dashboard', 'dashboard')->name('dashboard');
Route::view('components', 'components.index')->name('components.index');

if (app()->environment(['local', 'testing'])) {
    Route::view('development/integrations', 'development.integrations')->name('development.integrations');
    Route::view('development/plain-blade', 'development.plain-blade')->name('development.plain-blade');
}

require __DIR__ . '/settings.php';
