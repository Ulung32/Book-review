<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        $review = $this->route('review'); 

        // Check if the authenticated user is the owner of the review
        return $user != null && $user->id === $review->user_id && $user->tokenCan('reviews.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => ['sometimes', 'required', 'numeric', 'min:1', 'max:10'],
            'review' => ['sometimes', 'string'],
        ];
    }
}
