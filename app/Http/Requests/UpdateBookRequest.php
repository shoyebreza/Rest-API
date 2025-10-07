<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'isbn' => [
                'required',
                'string',
                Rule::unique('books', 'isbn')->ignore($this->route('book')->id),
            ],
            'description' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
            'genre' => 'nullable|string',
            'published_at' => 'nullable|date',
            'total_copies' => 'nullable|numeric|min:0',
            'price' => 'required|integer|min:1',
            'cover_image' => 'nullable|string',
        ];
    }
}
