<?php

namespace App\Http\Resources\v1\Review;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "userId"=> $this->user_id,
            "bookId"=> $this->book_id,
            "rating"=> $this->rating,
            "review"=> $this->review
        ];
    }
}
