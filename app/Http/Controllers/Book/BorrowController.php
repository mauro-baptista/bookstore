<?php

namespace App\Http\Controllers\Book;

use App\Models\Book;
use Illuminate\Http\Response;

class BorrowController
{
    public function __invoke(Book $book): Response
    {
        abort_unless($book->isAvailable(), 422, 'already_borrowed');

        auth()->user()->books()->attach($book);

        return response()->noContent();
    }
}
