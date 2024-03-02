<?php

namespace App\Http\Requests\Api\Novels;

use Illuminate\Foundation\Http\FormRequest;

class NovelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_uuid' => 'required|exists:users,uuid',
            'name' => 'required|string',
            'description' => 'required',
            'image' => 'required|file|mimes:img,image,png',
            'is_publish' => 'required|boolean',
            'is_private' => 'required|boolean',
            'genre' => 'required|array',
        ];
    }
}
