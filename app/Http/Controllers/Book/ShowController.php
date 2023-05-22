<?php

namespace App\Http\Controllers\Book;

use App\Http\Resources\BookResource;
use App\Models\Book;

class ShowController
{
    public function __invoke(Book $book): BookResource
    {
        return new BookResource($book);
    }
}
