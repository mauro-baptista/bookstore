<?php

namespace App\Http\Controllers\Book;

use App\Models\Book;
use Illuminate\Http\Response;

class DeleteController
{
    public function __invoke(Book $book): Response
    {
        $book->delete();

        return response()->noContent();
    }
}
