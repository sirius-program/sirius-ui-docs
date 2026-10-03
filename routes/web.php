<?php

declare(strict_types=1);

use App\Http\Controllers\BasicFormController;
use App\Http\Controllers\ControlExampleController;
use App\Http\Controllers\CurrencyExampleController;
use App\Http\Controllers\DatetimePickerExampleController;
use App\Http\Controllers\DialogFormExampleController;
use App\Http\Controllers\FileUploadExampleController;
use App\Http\Controllers\FormExampleController;
use App\Http\Controllers\FormUploadStoreController;
use App\Http\Controllers\FormValidationController;
use App\Http\Controllers\PhoneExampleController;
use App\Http\Controllers\RichtextExampleController;
use App\Http\Controllers\RichtextImageShowController;
use App\Http\Controllers\RichtextImageStoreController;
use App\Http\Controllers\SelectExampleController;
use App\Http\Controllers\SelectOptionController;
use App\Http\Controllers\SlideoverFormExampleController;
use App\Http\Controllers\SliderExampleController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/settings.php';

Route::view('/', 'welcome')->name('home');
Route::view('dashboard', 'dashboard')->name('dashboard');
Route::view('getting-started', 'started')->name('started');

Route::view('blade-components/choices', 'blade-components.choices-docs')->name('blade-components.choices');
Route::view('blade-components/currency', 'blade-components.currency-docs')->name('blade-components.currency');
Route::post('blade-components/currency-example', CurrencyExampleController::class)->name('blade-components.currency.store');
Route::view('blade-components/datetime-picker', 'blade-components.datetime-picker-docs')->name('blade-components.datetime-picker');
Route::post('blade-components/datetime-picker-example', DatetimePickerExampleController::class)->name('blade-components.datetime-picker.store');
Route::view('blade-components/file-upload', 'blade-components.file-upload-docs')->name('blade-components.file-upload');
Route::post('blade-components/file-upload-example', FileUploadExampleController::class)->name('blade-components.file-upload.store');
Route::get('blade-components/form', [FormExampleController::class, 'index'])->name('blade-components.form');
Route::post('blade-components/form-projects', [FormExampleController::class, 'store'])->name('blade-components.form.store');
Route::match(['PUT', 'PATCH'], 'blade-components/form-projects', [FormExampleController::class, 'update'])->name('blade-components.form.update');
Route::delete('blade-components/form-projects', [FormExampleController::class, 'destroy'])->name('blade-components.form.destroy');
Route::post('blade-components/form-upload', FormUploadStoreController::class)->name('blade-components.form.upload');
Route::view('blade-components/input', 'blade-components.input-docs')->name('blade-components.input');
Route::view('blade-components/label', 'blade-components.label-docs')->name('blade-components.label');
Route::view('blade-components/phone', 'blade-components.phone-docs')->name('blade-components.phone');
Route::post('blade-components/phone-example', PhoneExampleController::class)->name('blade-components.phone.store');
Route::view('blade-components/richtext', 'blade-components.richtext-docs')->name('blade-components.richtext');
Route::post('blade-components/richtext-example', RichtextExampleController::class)->name('blade-components.richtext.store');
Route::post('blade-components/richtext-images', RichtextImageStoreController::class)->middleware('throttle:20,1')->name('blade-components.richtext.images.store');
Route::get('blade-components/richtext-images/{file}', RichtextImageShowController::class)->where('file', '[A-Za-z0-9]+\.(jpg|jpeg|png|webp)')->name('blade-components.richtext.images.show');
Route::view('blade-components/select', 'blade-components.select-docs')->name('blade-components.select');
Route::post('blade-components/select-example', SelectExampleController::class)->name('blade-components.select.store');
Route::get('blade-components/select-options', SelectOptionController::class)->name('blade-components.select.options');
Route::view('blade-components/slider', 'blade-components.slider-docs')->name('blade-components.slider');
Route::post('blade-components/slider-example', SliderExampleController::class)->name('blade-components.slider.store');
Route::view('blade-components/textarea', 'blade-components.textarea-docs')->name('blade-components.textarea');

Route::post('blade-components/basic-example', BasicFormController::class)->name('blade-components.basic.store');
Route::post('blade-components/examples/input', ControlExampleController::class)->defaults('kind', 'input')->name('blade-components.input.store');
Route::post('blade-components/examples/password', ControlExampleController::class)->defaults('kind', 'password')->name('blade-components.password.store');
Route::post('blade-components/examples/textarea', ControlExampleController::class)->defaults('kind', 'textarea')->name('blade-components.textarea.store');
Route::post('blade-components/examples/checkbox', ControlExampleController::class)->defaults('kind', 'checkbox')->name('blade-components.checkbox.store');
Route::post('blade-components/examples/radio', ControlExampleController::class)->defaults('kind', 'radio')->name('blade-components.radio.store');
Route::post('blade-components/examples/switch', ControlExampleController::class)->defaults('kind', 'switch')->name('blade-components.switch.store');
Route::post('blade-components/examples/label', ControlExampleController::class)->defaults('kind', 'label')->name('blade-components.label.store');

if (app()->environment(['local', 'testing'])) {
    Route::view('development/integrations', 'development.integrations')->name('development.integrations');
    Route::view('development/plain-blade', 'development.plain-blade')->name('development.plain-blade');
    Route::view('development/standalone-controls', 'development.standalone-controls')->name('development.standalone-controls');
    Route::view('development/basic-controls', 'development.basic-controls')->name('development.basic-controls');
    Route::view('development/currency', 'development.currency')->name('development.currency');
    Route::view('development/currency-bindings', 'development.currency-bindings')->name('development.currency-bindings');
    Route::view('development/date-bindings', 'development.date-bindings')->name('development.date-bindings');
    Route::view('development/datetime-picker', 'development.datetime-picker')->name('development.datetime-picker');
    Route::view('development/dialog-native', 'development.dialog-native')->name('development.dialog-native');
    Route::view('development/fields', 'development.fields')->name('development.fields');
    Route::post('development/fields', FormValidationController::class)->name('development.fields.validate');
    Route::view('development/phone', 'development.phone')->name('development.phone');
    Route::view('development/phone-bindings', 'development.phone-bindings')->name('development.phone-bindings');
    Route::view('development/richtext', 'development.richtext')->name('development.richtext');
    Route::view('development/richtext-bindings', 'development.richtext-bindings')->name('development.richtext-bindings');
    Route::view('development/select', 'development.select')->name('development.select');
    Route::view('development/select-bindings', 'development.select-bindings')->name('development.select-bindings');
    Route::view('development/slider', 'development.slider')->name('development.slider');
    Route::view('development/slider-bindings', 'development.slider-bindings')->name('development.slider-bindings');
    Route::view('development/layout-components', 'development.layout-components')->name('development.layout-components');
    Route::view('development/presentation', 'development.presentation')->name('development.presentation');
    Route::view('development/overlays', 'development.overlays')->name('development.overlays');
}

Route::view('blade-components/badge', 'blade-components.badge-docs')->name('blade-components.badge');
Route::view('blade-components/alert', 'blade-components.alert-docs')->name('blade-components.alert');
Route::view('blade-components/button', 'blade-components.button-docs')->name('blade-components.button');
Route::view('blade-components/button-group', 'blade-components.button-group-docs')->name('blade-components.button-group');
Route::view('blade-components/icon', 'blade-components.icon-docs')->name('blade-components.icon');
Route::view('blade-components/message', 'blade-components.message-docs')->name('blade-components.message');

Route::view('blade-components/card', 'blade-components.card-docs')->name('blade-components.card');
Route::view('blade-components/accordion', 'blade-components.accordion-docs')->name('blade-components.accordion');
Route::view('blade-components/dialog', 'blade-components.dialog-docs')->name('blade-components.dialog');
Route::view('blade-components/slideover', 'blade-components.slideover-docs')->name('blade-components.slideover');

Route::post('blade-components/dialog-example', DialogFormExampleController::class)->name('blade-components.dialog.store');
Route::post('blade-components/slideover-example', SlideoverFormExampleController::class)->name('blade-components.slideover.store');
