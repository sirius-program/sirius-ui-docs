<?php

use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;

Route::redirect('settings', 'settings/appearance');
Route::livewire('settings/appearance', Appearance::class)->name('appearance.edit');
