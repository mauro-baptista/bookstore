<?php

namespace App\Http\Controllers\Book\Borrow;

use App\Models\Book;
use Illuminate\Http\JsonResponse;

class StoreController
{
    public function __invoke(Book $book): JsonResponse
    {
        abort_unless($book->isAvailable(), 422, 'already_borrowed');

        auth()->user()->books()->attach($book);

        return response()->json([], 201);
    }
}
