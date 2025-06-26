<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkController;

Route::controller(ShortLinkController::class)->group(function () {
    Route::get('/', 'index')->name('shorten.link.index');
    Route::post('/', 'store')->name('shorten.link.store');
    Route::get('/edit/{shortLink}', 'edit')->name('shorten.link.edit');
    Route::put('/{shortLink}', 'update')->name('shorten.link.update');
    Route::delete('/{shortLink}', 'destroy')->name('shorten.link.destroy');
    Route::get('/{code}', 'shortenLink')->name('shorten.link');
});