<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:2', 'max:256'],
            'description' => ['nullable', 'min:10', 'max:2048'],
            'publisher' => ['nullable', 'min:2', 'max:256'],
            'author' => ['nullable', 'min:2', 'max:256'],
            'cover_photo' => ['nullable', 'url'],
            'price' => ['required', 'integer', 'min:0', 'max:999999'],
        ];
    }
}
