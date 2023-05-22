<?php

use App\Http\Controllers\Book;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'books/',
], function () {
    Route::get('/', Book\IndexController::class);
    Route::get('/{book}', Book\ShowController::class);
    Route::get('/{book}/borrow', Book\BorrowController::class);
    Route::get('/{book}/return', Book\ReturnController::class);
});
