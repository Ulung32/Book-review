<?php

namespace App\Filters\v1;

use App\Filters\BaseFilter;
use App\Models\Review;

class ReviewFilter extends BaseFilter{
    public function __construct(){
        $this->safeParameters = [
            'userId' => '=',
            'bookId' => '=',
            'minRating' => '>='
        ];

        $this->columnMap = [
            'userId' => 'user_id',
            'bookId' => 'book_id',
            'minRating' => 'rating'
        ];

        $this->query = Review::query();
    }
}