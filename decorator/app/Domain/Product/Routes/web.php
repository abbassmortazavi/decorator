<?php

use App\Domain\Home\Http\Controllers\Web\HomeController;
use App\Domain\Home\Http\Controllers\Web\OptionController;
use Illuminate\Support\Facades\Route;
/**
 *  home backend
 */
Route::prefix('backend')
    ->as('backend.')
   // ->middleware(['auth:web'])
    ->group(static function () {
        Route::get('test', [HomeController::class, 'admin'])->name('home.admin');
    });
