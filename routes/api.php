<?php

use App\Http\Controllers\Book;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'books/',
], function () {
    Route::get('/', Book\IndexController::class);
    Route::get('/borrow', Book\Borrow\IndexController::class);

    Route::get('/{book}', Book\ShowController::class);

    Route::post('/{book}/borrow', Book\Borrow\StoreController::class);
    Route::delete('/{book}/borrow', Book\Borrow\DeleteController::class);
});
