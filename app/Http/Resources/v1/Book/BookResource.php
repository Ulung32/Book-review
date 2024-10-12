<?php

namespace App\Http\Resources\v1\Book;

use App\Http\Resources\v1\Review\ReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            "title"=> $this->title,
            "author" => $this->author,
            "sumary" => $this->sumary,
            "rating" => $this->rating,
            "reviewCount" => $this->reviewCount,
            "reviews" => ReviewResource::collection($this->whenLoaded("reviews")),
        ];
    }
}
