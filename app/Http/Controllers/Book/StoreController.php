<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class StoreController
{
    public function __invoke(BookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());

        $resource = new BookResource($book);

        return response()->json($resource, 201);
    }
}
