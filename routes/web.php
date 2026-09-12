<?php

declare(strict_types=1);

use App\Http\Controllers\BasicControlController;
use App\Http\Controllers\BasicFormController;
use App\Http\Controllers\FormValidationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('dashboard', 'dashboard')->name('dashboard');
Route::view('components', 'components.index')->name('components.index');
Route::view('components/label', 'components.label-docs')->name('components.label');
Route::view('components/forms', 'components.form-conventions')->name('components.forms');
Route::post('components/forms', FormValidationController::class)->name('components.forms.validate');
Route::get('components/{control}', BasicControlController::class)
    ->whereIn('control', ['input', 'password', 'textarea', 'checkbox', 'radio', 'switch', 'choices'])->name('components.control');
Route::post('components/basic-example', BasicFormController::class)->name('components.basic.store');

if (app()->environment(['local', 'testing'])) {
    Route::view('development/integrations', 'development.integrations')->name('development.integrations');
    Route::view('development/plain-blade', 'development.plain-blade')->name('development.plain-blade');
    Route::view('development/basic-controls', 'development.basic-controls')->name('development.basic-controls');
    Route::view('development/standalone-controls', 'development.standalone-controls')->name('development.standalone-controls');
}

require __DIR__ . '/settings.php';
