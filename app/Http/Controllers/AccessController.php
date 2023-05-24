<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AccessController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => 'success',
        ], 200);
    }
}
