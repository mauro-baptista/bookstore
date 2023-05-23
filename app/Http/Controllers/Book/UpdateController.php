<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;

class UpdateController
{
    public function __invoke(Book $book, BookRequest $request): BookResource
    {
        $book->forceFill($request->validated())->save();

        return new BookResource($book->fresh());
    }
}
