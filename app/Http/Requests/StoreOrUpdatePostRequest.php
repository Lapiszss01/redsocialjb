<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'body' => 'required|min:1',
            'image' => 'nullable|file|max:2048',
            'published_at' => 'nullable|date',
        ];
    }
}
