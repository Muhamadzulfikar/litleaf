<?php

namespace App\Http\Requests\Api\Novels;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $rules = [
            'user_uuid' => 'required|exists:users,uuid',
            'name' => 'required|string',
            'description' => 'required',
            'image' => 'required|file|mimes:jpg,jpeg,png',
            'is_publish' => 'required|boolean',
            'is_private' => 'required|boolean',
            'genre' => 'required|array',
        ];

        if ($this->method() === 'PUT') {
            $rules['image'] = 'sometimes|nullable|file|mimes:jpg,jpeg,png';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'user_uuid' => 'user',
        ];
    }

    /**
     * Failed Validation Error.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'request' => request()->all(),
        ], 422));
    }
}
