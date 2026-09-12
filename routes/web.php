<?php

declare(strict_types=1);

use App\Http\Controllers\FormValidationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('dashboard', 'dashboard')->name('dashboard');
Route::view('components', 'components.index')->name('components.index');
Route::view('components/label', 'components.label-docs')->name('components.label');
Route::view('components/forms', 'components.form-conventions')->name('components.forms');
Route::post('components/forms', FormValidationController::class)->name('components.forms.validate');

if (app()->environment(['local', 'testing'])) {
    Route::view('development/integrations', 'development.integrations')->name('development.integrations');
    Route::view('development/plain-blade', 'development.plain-blade')->name('development.plain-blade');
}

require __DIR__ . '/settings.php';
