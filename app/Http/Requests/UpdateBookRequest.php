<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();

        return $user != null && $user->tokenCan('books.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['sometimes', 'required','string'],
            'author' => ['sometimes', 'required','string'],
            'sumary' => ['sometimes', 'required','string'],
        ];
    }

    protected function prepareForValidation()
    {
        // Remove rating and review_count from the request data before validation
        $this->merge([
            'rating' => null,
            'review_count' => 0,
        ]);
    }
}
