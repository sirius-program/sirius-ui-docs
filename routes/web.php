<?php

declare(strict_types=1);

use App\Http\Controllers\BasicControlController;
use App\Http\Controllers\BasicFormController;
use App\Http\Controllers\ControlExampleController;
use App\Http\Controllers\CurrencyExampleController;
use App\Http\Controllers\FormValidationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('dashboard', 'dashboard')->name('dashboard');
Route::view('getting-started', 'started')->name('started');
Route::view('blade-components/label', 'blade-components.label-docs')->name('blade-components.label');
Route::view('blade-components/currency', 'blade-components.currency-docs')->name('blade-components.currency');
Route::post('blade-components/currency-example', CurrencyExampleController::class)->name('blade-components.currency.store');
Route::get('blade-components/{control}', BasicControlController::class)
    ->whereIn('control', ['input', 'password', 'textarea', 'checkbox', 'radio', 'switch', 'choices'])->name('blade-components.control');
Route::post('blade-components/basic-example', BasicFormController::class)->name('blade-components.basic.store');
Route::post('blade-components/examples/{kind}', ControlExampleController::class)
    ->whereIn('kind', ['input', 'password', 'textarea', 'checkbox', 'radio', 'switch', 'label'])->name('blade-components.examples.store');

if (app()->environment(['local', 'testing'])) {
    Route::view('development/currency-bindings', 'development.currency-bindings')->name('development.currency-bindings');
    Route::view('development/currency', 'development.currency')->name('development.currency');
    Route::view('development/fields', 'development.fields')->name('development.fields');
    Route::post('development/fields', FormValidationController::class)->name('development.fields.validate');
    Route::view('development/integrations', 'development.integrations')->name('development.integrations');
    Route::view('development/plain-blade', 'development.plain-blade')->name('development.plain-blade');
    Route::view('development/basic-controls', 'development.basic-controls')->name('development.basic-controls');
    Route::view('development/standalone-controls', 'development.standalone-controls')->name('development.standalone-controls');
}

require __DIR__ . '/settings.php';
