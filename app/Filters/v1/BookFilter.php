<?php

namespace App\Filters\v1;

use App\Models\Book;
use App\Filters\BaseFilter;

class BookFilter extends BaseFilter {
    /**
    * set attributes for this class
    *
    */
    public function __construct(){
        $this->safeParameters = [
            'author' => 'like',
            'minRating' => '>=',
            'title' => 'like'
        ];

        $this->columnMap = [
            'minRating' => 'rating'
        ];

        $this->query = Book::query();
    }

}
