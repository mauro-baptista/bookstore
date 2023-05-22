<?php

namespace App\Http\Controllers\Book\Borrow;

use App\Http\Resources\BookCollection;

class IndexController
{
    public function __invoke()
    {
        return new BookCollection(auth()->user()->books);
    }
}
