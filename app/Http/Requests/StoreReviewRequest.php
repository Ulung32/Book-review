<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Review;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'book_id' => ['required', 'exists:books,id'], 
            'rating' => ['required', 'numeric', 'min:1', 'max:10'],
            'user_id' => [
            'required', 
            'exists:users,id', 
                function($attribute, $value, $fail) {
                    // Check if the user already has a review for the same book
                    $exists = Review::where('user_id', $this->user_id)
                                    ->where('book_id', $this->book_id)
                                    ->exists();

                    if ($exists) {
                        $fail('The user has already submitted a review for this book.');
                    }
                }
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'book_id' => $this->bookId,
            'user_id' => $this->userId,
        ]);
    }
}
