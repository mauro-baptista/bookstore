<?php

namespace App\Http\Controllers\Book;

use App\Models\Book;
use Illuminate\Http\Response;

class ReturnController
{
    public function __invoke(Book $book): Response
    {
        $book->load('users');

        abort_if($book->users->pluck('id')->doesntContain(auth()->user()->id), '422', 'not_borrowed');

        auth()->user()->books()->detach($book);

        return response()->noContent();
    }
}
