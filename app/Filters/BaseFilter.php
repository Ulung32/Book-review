<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BaseFilter {
    /**
    * @var array
    */
    protected $safeParameters = [];

    /**
    * @var array
    */
    protected $columnMap = [];

    /**
    * @var \Illuminate\Database\Eloquent\Builder
    */
    protected Builder $query;

    /**
    * set query builder for this class
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return void
    */
    public function setQuery(Builder $query){
        $this->query = $query;
    }

    /**
    * mapping url query into Eloquent ORM query builder
    *
    * @param Illuminate\Http\Request $request
    * @return Illuminate\Database\Eloquent\Builder
    */
    public function filter(Request $request){
        $eloQuery = $this->query;
        
        foreach($this->safeParameters as $parameter => $operator){
            if($request->has( $parameter )){
                $column = $this->columnMap[$parameter] ?? $parameter;

                if($operator == "like"){
                    $eloQuery->where($column, $operator, '%' . $request->query($parameter) . '%');
                }else{
                    $eloQuery->where($column, $operator, $request->query( $parameter));
                }
            }
        }

        return $eloQuery;
    }
}
