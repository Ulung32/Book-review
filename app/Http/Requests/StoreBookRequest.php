<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();

        return $user != null && $user->tokenCan('books.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required','string'],
            'author' => ['required','string'],
            'sumary' => ['required','string'],
        ];
    }

    protected function prepareForValidation()
    {
        // Remove rating and review_count from the request data before validation
        $this->merge([
            'rating' => 0,
            'review_count' => 0,
        ]);
    }
}
