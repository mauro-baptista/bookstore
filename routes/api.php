<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\Book;
use Illuminate\Support\Facades\Route;

Route::get('access/', AccessController::class);

Route::group([
    'prefix' => 'books/',
], function () {
    Route::get('/', Book\IndexController::class);
    Route::get('/borrow', Book\Borrow\IndexController::class);

    Route::get('/{book}', Book\ShowController::class);

    Route::post('/{book}/borrow', Book\Borrow\StoreController::class);
    Route::delete('/{book}/borrow', Book\Borrow\DeleteController::class);

    Route::group([
        'middleware' => ['role:manager'],
    ], function () {
        Route::post('/', Book\StoreController::class)->middleware('permission:store book');
        Route::put('/{book}', Book\UpdateController::class)->middleware('permission:update book');
        Route::delete('/{book}', Book\DeleteController::class)->middleware('permission:delete book');
    });
});
