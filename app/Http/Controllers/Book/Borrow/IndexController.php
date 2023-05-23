<?php

namespace App\Http\Controllers\Book\Borrow;

use App\Http\Resources\BookCollection;

class IndexController
{
    public function __invoke(): BookCollection
    {
        return new BookCollection(auth()->user()->books);
    }
}
