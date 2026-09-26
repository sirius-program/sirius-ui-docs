<?php

declare(strict_types=1);

use App\Http\Controllers\BasicControlController;
use App\Http\Controllers\BasicFormController;
use App\Http\Controllers\ControlExampleController;
use App\Http\Controllers\CurrencyExampleController;
use App\Http\Controllers\DatetimePickerExampleController;
use App\Http\Controllers\FileUploadExampleController;
use App\Http\Controllers\FormValidationController;
use App\Http\Controllers\PhoneExampleController;
use App\Http\Controllers\SelectExampleController;
use App\Http\Controllers\SelectOptionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('dashboard', 'dashboard')->name('dashboard');
Route::view('getting-started', 'started')->name('started');
Route::view('blade-components/label', 'blade-components.label-docs')->name('blade-components.label');
Route::view('blade-components/currency', 'blade-components.currency-docs')->name('blade-components.currency');
Route::post('blade-components/currency-example', CurrencyExampleController::class)->name('blade-components.currency.store');
Route::view('blade-components/datetime-picker', 'blade-components.datetime-picker-docs')->name('blade-components.datetime-picker');
Route::post('blade-components/datetime-picker-example', DatetimePickerExampleController::class)->name('blade-components.datetime-picker.store');
Route::view('blade-components/select', 'blade-components.select-docs')->name('blade-components.select');
Route::view('blade-components/file-upload', 'blade-components.file-upload-docs')->name('blade-components.file-upload');
Route::post('blade-components/file-upload-example', FileUploadExampleController::class)->name('blade-components.file-upload.store');
Route::post('blade-components/select-example', SelectExampleController::class)->name('blade-components.select.store');
Route::get('blade-components/select-options', SelectOptionController::class)->name('blade-components.select.options');
Route::view('blade-components/phone', 'blade-components.phone-docs')->name('blade-components.phone');
Route::post('blade-components/phone-example', PhoneExampleController::class)->name('blade-components.phone.store');
Route::get('blade-components/{control}', BasicControlController::class)
    ->whereIn('control', ['input', 'password', 'textarea', 'checkbox', 'radio', 'switch', 'choices'])->name('blade-components.control');
Route::post('blade-components/basic-example', BasicFormController::class)->name('blade-components.basic.store');
Route::post('blade-components/examples/{kind}', ControlExampleController::class)
    ->whereIn('kind', ['input', 'password', 'textarea', 'checkbox', 'radio', 'switch', 'label'])->name('blade-components.examples.store');

if (app()->environment(['local', 'testing'])) {
    Route::view('development/select', 'development.select')->name('development.select');
    Route::view('development/select-bindings', 'development.select-bindings')->name('development.select-bindings');
    Route::view('development/phone', 'development.phone')->name('development.phone');
    Route::view('development/phone-bindings', 'development.phone-bindings')->name('development.phone-bindings');
    Route::view('development/datetime-picker', 'development.datetime-picker')->name('development.datetime-picker');
    Route::view('development/date-bindings', 'development.date-bindings')->name('development.date-bindings');
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
