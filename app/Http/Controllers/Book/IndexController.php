<?php

namespace App\Http\Controllers\Book;

use App\Http\Resources\BookCollection;
use App\Models\Book;

class IndexController
{
    public function __invoke(): BookCollection
    {
        return new BookCollection(Book::all());
    }
}
